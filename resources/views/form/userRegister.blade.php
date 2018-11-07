@extends('layouts.main')

@section('title') Register a new user @stop
@section('scripts.header')
@stop
@section('content')
    <h3>New User Registration</h3>
    <div class="main-login main-center">
        <form class="form-horizontal" method="POST" action="/u/register/process">

            <div class="form-group">
                <label for="name" class="cols-sm-2 control-label">{{trans('auth.full_name')}}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="name" id="name"  placeholder="Enter your Name"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="cols-sm-2 control-label">{{trans('auth.email')}} ({{trans('auth.optional')}})</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="username" class="cols-sm-2 control-label">{{trans('auth.phone')}}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="phone" id="phone"  placeholder=""/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="cols-sm-2 control-label">{{trans('auth.password')}}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm" class="cols-sm-2 control-label">{{trans('auth.password_confirm')}}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" name="password_confirmation" id="confirm"  placeholder="Confirm your Password"/>
                    </div>
                </div>
            </div>

            <div class="form-group ">
                <button type="submit" class="btn btn-primary btn-lg btn-block login-button">{{trans('auth.register')}}</button>
            </div>
            <div class="login-register">
                <a href="index.php">Login</a>
            </div>
            {{ csrf_field() }}
        </form>
    </div>

    @include('partials.formErrors')
@stop
