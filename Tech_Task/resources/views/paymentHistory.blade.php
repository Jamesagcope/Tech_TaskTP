@extends('layout.master')

@section('payHistory')
    <br/>
    <nav class="navbar">
        <lu class="nav-item active">
            <a class="nav-link" href="/transaction">New Transaction</a>
            <a class="nav-link" href="/logout">Logout</a>
        </lu>
    </nav>
    <p align="center" class="h5">Logged in as {{session()->get('email')}}</p>
    <div class="row">
        <div class="col-md-12">
            <br/>
            <h3 align="center">Payment Data</h3>
            <br/>
            <table class="table table-bordered">
                <tr>
                    <th>Amount</th>
                    <th>Reference</th>
                    <th>Time paid</th>
                </tr>
                @foreach($payments as $row)
                <tr>
                    <td>{{$row['amount']}}</td>
                    <td>{{$row['Reference']}}</td>
                    <td>{{$row['created_at']}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
