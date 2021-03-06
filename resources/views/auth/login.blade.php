@extends('layouts.main')

@section('title')
	{{trans('auth.login')}}
@stop

@section('content')
<div class="user-register-form panel panel-default col-md-8 col-md-offset-2">
	<div class="panel-heading">
		<h2>{{trans('auth.login')}}</h2>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" method="POST" action="{{ route('login') }}">
			{{ csrf_field() }}

			<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
				<label for="phone" class="col-md-4 control-label">{{trans('auth.phone')}}</label>

				<div class="col-md-6">
					<input id="phone" type="phone" class="form-control" name="phone" value="{{ old('phone') }}" required autofocus>

					@if ($errors->has('phone'))
						<span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				<label for="password" class="col-md-4 control-label">{{trans('auth.password')}}</label>

				<div class="col-md-6">
					<input id="password" type="password" class="form-control" name="password" required>

					@if ($errors->has('password'))
						<span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{trans('auth.remember_me')}}
						</label>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-8 col-md-offset-4">
					<button type="submit" class="btn btn-primary">
						{{trans('auth.login')}}
					</button>

					<a class="btn btn-link" href="{{ route('password.request') }}">
						{{trans('auth.forgot_pass')}}
					</a>
				</div>
			</div>
		</form>
	</div>
	</div>
</div>
@stop
