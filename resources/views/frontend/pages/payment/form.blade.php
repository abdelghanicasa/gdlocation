@extends('frontend.layouts.app')

@section('content')
    <div class="container">
    <?php
$reference = session('reference');
$montant = session('montant');
$email = session('email');
echo $email;
?>
        <h1>Paiement en ligne</h1>
        <form id="paymentForm" method="POST" action="{{ route('payment.process') }}">
            @csrf
            <div class="form-group">
                <label for="amount">Montant (€).</label>
                <input type="number" class="form-control" id="amount" name="amount" value="{{ $montant }}" min="1" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Payer</button>
        </form>
    </div>
@endsection