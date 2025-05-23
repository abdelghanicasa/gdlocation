<?php

namespace App\Helpers;

use Carbon\Carbon;

class AppHelper
{
    /**
     * Formater une date selon un format personnalisé.
     *
     * @param  string  $date  La date à formater.
     * @param  string  $format Le format de la date.
     * @return string
     */
    public static function formatDate($date, $format = 'd-m-Y')
    {
        if (!$date) return '—'; // Retourne '—' si la date est vide.

        return Carbon::parse($date)->format($format);
    }

    // Date avec heure (ex: 11-05-2025 14:30)
    public static function formatDateTime($date, $format = 'd-m-Y H:i')
    {
        if (!$date) return '—';

        return Carbon::parse($date)->format($format);
    }

    // Heure uniquement, sans secondes (ex: 14:30)
    public static function formatHour($date, $format = 'H:i')
    {
        if (!$date) return '—';

        return Carbon::parse($date)->format($format);
    }

    public static function cleanNumber($number)
    {
        return fmod($number, 1) == 0.0 ? intval($number) : rtrim(rtrim(number_format($number, 2, '.', ''), '0'), '.');
    }

    // Utilisation
    // <!-- Date seule -->
    // {{ \AppHelper::formatDate($promo->expires_at) }}

    // <!-- Date + Heure -->
    // {{ \AppHelper::formatDateTime($promo->expires_at) }}

    // <!-- Heure seule (sans secondes) -->
    // {{ \AppHelper::formatHour($promo->expires_at) }}
}



