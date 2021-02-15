@extends('layout.master')

@section('api')
    <p>$id</p>
    <style>body {background-color:#f6f6f5;}</style>
    <script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{'id'}}"></script>
    <form action="/madePayment" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>

@endsection
