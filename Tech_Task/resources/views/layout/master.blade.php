<!DOCTYPE html>
<html>
<head>
    <title>Testing Transactions</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jguery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script src="https://maxcnd.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        .box{
            width:700px;
            margin:0 auto;
            border:1px solid #ccc;
        }
        .navbar{
            alignmnt: center;
            text-align: center;
        }
        .nav-link{
            text-decoration: none;
            color: #223fff;
            width: 100px;
            padding: 20px;
            font-size: 15px;
            text-transform: uppercase;
            font-weight: bold;
        }

    </style>
</head>
<body>
<br/>

<div class="container box">
    <br/>
    @include('layout.alert')
    @yield('login')
    @yield('register')
    @yield('transaction')
    @yield('payHistory')
    @yield('madePayment')
    @yield('payment')

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
        @endforeach
    @endif
</div>
</body>
</html>
