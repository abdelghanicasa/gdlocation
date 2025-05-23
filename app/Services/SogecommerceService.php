<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SogecommerceService
{
    protected $merchantId;
    protected $environment;
    protected $hmacKey;
    protected $publicKey;

    public function __construct()
    {
        $this->merchantId = config('sogecommerce.merchant_id');
        $this->environment = config('sogecommerce.environment');
        $this->hmacKey = $this->environment === 'PRODUCTION' 
            ? config('sogecommerce.hmac_key_prod')
            : config('sogecommerce.hmac_key_test');
        $this->publicKey = $this->environment === 'PRODUCTION'
            ? config('sogecommerce.public_key_prod')
            : config('sogecommerce.public_key_test');
    }

    public function getClientConfiguration()
    {
        return [
            'merchantId' => $this->merchantId, // Ajouté
            'secretKey' => $this->hmacKey,     // Ajouté
            'publicKey' => $this->publicKey,
            'apiUrl' => config('sogecommerce.api_url'),
            'jsUrl' => config('sogecommerce.js_url'),
            'environment' => $this->environment,
        ];
    }

    public function createPaymentSession($orderData)
    {
        $payload = [
            'amount' => $orderData['amount'] * 100,
            'currency' => 'EUR',
            'orderId' => $orderData['orderId'],
            'customer' => ['email' => $orderData['email']],
            'configuration' => [
                'returnUrl' => route('payment.return'),
                'notificationUrl' => route('payment.callback')
            ]
        ];
    
        Log::debug('Payload envoyé à Sogecommerce :', $payload);
    
        $response = Http::withBasicAuth(
            $this->merchantId, 
            config('sogecommerce.test_password')
        )->post(config('sogecommerce.api_url').'/    NJ/V4/Charge/CreatePayment', $payload);
    
        Log::debug('Réponse brute Sogecommerce :', [$response->status(), $response->body()]);
    
        return $response->json();
    }

    public function verifyIpnSignature($data)
    {
        if (!isset($data['kr-hash'])) {
            return false;
        }

        $receivedHash = $data['kr-hash'];
        unset($data['kr-hash']);

        // Triez les paramètres par ordre alphabétique
        ksort($data);

        // Concaténez toutes les valeurs
        $stringToHash = '';
        foreach ($data as $value) {
            $stringToHash .= $value;
        }

        // Calculez le HMAC-SHA-256
        $calculatedHash = hash_hmac('sha256', $stringToHash, $this->hmacKey);

        return hash_equals($calculatedHash, $receivedHash);
    }

    public function createPaymentOrder(array $orderData)
    {
        $endpoint = '/api-payment/V4/Charge/CreatePaymentOrder';
        $url = config('sogecommerce.api_url') . $endpoint;

        $payload = [
            'amount' => $orderData['amount'] * 100, // Convert to cents
            'currency' => 'EUR',
            'orderId' => $orderData['orderId'],
            'channelOptions' => [
                'channelType' => 'URL'
            ],
            'configuration' => [
                'returnUrl' => route('payment.response'),
                'notificationUrl' => route('payment.ipn')
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode(
                    config('sogecommerce.merchant_id') . ':' . config('sogecommerce.test_password')
                )
            ])->post($url, $payload);

            if ($response->failed()) {
                Log::error('Sogecommerce payment creation failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'payload' => $payload
                ]);
                return [
                    'error' => true,
                    'message' => 'Payment creation failed. Please check the logs for more details.'
                ];
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Exception during Sogecommerce payment creation', [
                'message' => $e->getMessage(),
                'payload' => $payload
            ]);
            return [
                'error' => true,
                'message' => 'An unexpected error occurred during payment creation.'
            ];
        }
    }
}