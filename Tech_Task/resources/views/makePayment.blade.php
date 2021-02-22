@extends('layout.master')

@section('payment')
    <style>body {background-color:#f6f6f5;}</style>
    <script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$idResponse}}"></script>
    <form action="/requests/" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
@endsection
