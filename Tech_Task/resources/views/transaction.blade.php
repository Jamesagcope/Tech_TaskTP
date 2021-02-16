@extends('layout.master')

@section('transaction')
    <br/>
    <nav class="navbar">
        <lu class="nav-item active">
            <a class="nav-link" href="/paymentHistory">Payment History</a>
            <a class="nav-link" href="/logout">Logout</a>
        </lu>
    </nav>
    <p align="center" class="h5">Logged in as {{session()->get('email')}}</p>
    <h3 align="center">Enter Amount and Reference for Transaction</h3>
    <form method="post" action="apiRequest">
        {{ csrf_field() }}
        <div class="form-group">
            <input placeholder="Amount" pattern="^\d*(\.\d{0,2})?$" name="amount" class="form-control"/>
        </div>
        <div class="form-group">
            <input placeholder="Reference" type="text" name="reference" class="form-control"/>
        </div>
        <div class="form-group">
            <input placeholder="Bill Address" type="text" name="billingAddress" class="form-control"/>
        </div>
        <div class="form-group">
            <input placeholder="customer information" type="text" name="customerInfo" class="form-control"/>
        </div>
        <div class="form-group">
            <input type="submit" name="pay" class="btn btn-primary" value="Pay"/>
        </div>
    </form>
@endsection
