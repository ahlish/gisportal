@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="row" style="text-align: center;">
       <div class="col-sm-12">Login</div>
   </div>
    <form method="post" action="/check_login" class="form-horizontal form-label-left">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row" style="margin: 5px 0;">
            <div class="col-sm-6" style="text-align: right;">Username : </div>
            <div class="col-sm-6"><input type="text" name="username" /> </div>
        </div>
        <div class="row" style="margin: 5px 0;">
            <div class="col-sm-6" style="text-align: right;">Password : </div>
            <div class="col-sm-6"><input type="password" name="password" /> </div>
        </div>
        <div class="row">
            <div class="col-sm-6" style="text-align: right;"><input type="submit" name="login" value="Login"/></div>
        </div>
    </form>
</div>
@endsection