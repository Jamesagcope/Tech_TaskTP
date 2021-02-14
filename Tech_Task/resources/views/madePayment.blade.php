@extends('layout.master')

@section('madePayment')
    <br/>
    <nav class="navbar">
        <lu class="nav-item active">
            <a class="nav-link" href="/paymentHistory">Payment History</a>
            <a class="nav-link" href="/transaction">New Transaction</a>
            <a class="nav-link" href="/logout">Logout</a>
        </lu>
    </nav>
    <p align="center" class="h5">Logged in as {{session()->get('email')}}</p>
    <h3 align="center">Enter Amount and Reference for Transaction</h3>




@endsection
