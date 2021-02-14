@extends('layout.master')

@section('login')

    <h3 align="center">Login</h3>

    <br/>
    <form method="post" action="check">
        {{ csrf_field() }}
        <div class="form-group">
            <input placeholder="Email" type="email" name="email" class="form-control"/>
        </div>
        <div class="form-group">
            <input placeholder="Password" type="password" name="password" class="form-control"/>
        </div>
        <div class="form-group">
            <input type="submit" name="login" class="btn btn-primary" value="Login"/>
        </div>
    </form>

    <a href="/register" class="btn btn-primary" type="submit" >Register new account</a>
    <br/><br/>
@endsection
