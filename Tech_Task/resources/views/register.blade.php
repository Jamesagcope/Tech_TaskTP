@extends('layout.master')

@section('register')

<h3 align="center">Register new account</h3>
<br/>
<form method="post" action="{{URL::to('/create')}}">
    {{ csrf_field() }}
    <div class="form-group">
        <input placeholder="Email" type="email" name="email" class="form-control"/>
    </div>
    <div class="form-group">
        <input placeholder="Password" type="password" name="password" class="form-control"/>
    </div>
    <div class="form-group">
        <input type="submit" name="register" class="btn btn-primary" value="Register"/>
    </div>
</form>

@endsection
