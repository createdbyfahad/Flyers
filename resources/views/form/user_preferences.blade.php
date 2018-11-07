@extends('layouts.main')

@section('title')
	Edit user info
@stop

@section('content')


@include('partials.user-cp-menu', ['current' => 'preferences'])
<div class="user-cp-form panel panel-default col-md-8">
	<div class="panel-heading">
		<h4>{{trans("word.user_preferences")}}</h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" method="POST" action="{{ route('userPreferencesEdit') }}" enctype="multipart/form-data">
			{{ csrf_field() }}

			<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				<label for="password" class="col-md-4 control-label">First, enter {{trans('auth.password')}}</label>
				<div class="col-md-6">
					<input id="password" type="password" class="form-control" name="password" required>

					@if ($errors->has('password'))
						<span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
					@endif
				</div>
			</div>
			<hr />

			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
				<label for="name" class="col-md-4 control-label">{{trans('auth.full_name')}}</label>

				<div class="col-md-6">
					<input id="name" type="text" class="form-control" name="name" value="{{ (old('name') != null)? old('name') : $user->name}}" required autofocus>

					@if ($errors->has('name'))
						<span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
				<label for="phone" class="col-md-4 control-label">{{trans('auth.phone')}}</label>

				<div class="col-md-6">
					<input id="phone" type="phone" class="form-control" name="phone" value="{{ (old('phone') != null)? old('phone') : $user->phone}}" required>

					@if ($errors->has('phone'))
						<span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				<label for="email" class="col-md-4 control-label">{{trans('auth.email')}} ({{trans('auth.optional')}})</label>

				<div class="col-md-6">
					<input id="email" type="email" class="form-control" name="email" value="{{ (old('email') != null)? old('email') : $user->email}}">

					@if ($errors->has('email'))
						<span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
					@endif
				</div>
			</div>

			<hr />

			<div class="user-preferences-profile clearfix col-md-6 col-md-offset-4">
				<div class="col-md-3 user-preferences-profile-pic">
					<img src="{{$user->profilePic}}" />
				</div>
				<div class="col-md-9 user-preferences-profile-info">
					<h4>{{$user->profileName}}</h4>
					<img src="http://movies4android.com/content/stars.png" /><br /><small>4 reviews</small>
				</div>
			</div>

			<div class="form-group">
				<label for="publicName" class="col-md-4 control-label">{{trans('auth.choosePublicName')}}</label>

				<div class="col-md-6">
					<div class="radio">
						<label>
							<input type="radio" name="publicNameRadio" value="0" @if($user->public_name === 0)checked @endif>
							{{$user->first_name}}
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="publicNameRadio" value="1" @if($user->public_name === 1)checked @endif>
							<input type="text" name="nicknameVal" class="form-control" value="{{ (old('nicknameVal') != null)? old('nicknameVal') : $user->nickname}}" />
						</label>
					</div>
					@if ($errors->has('nicknameVal'))
						<span class="help-block">
                                        <strong>{{ $errors->first('nicknameVal') }}</strong>
                                    </span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('profilePic') ? ' has-error' : '' }}">
				<label for="profilePic" class="col-md-4 control-label">{{trans('auth.profilePic')}} ({{trans('auth.optional')}})</label>

				<div class="col-md-6">
					<input id="profilePic" type="file" class="form-control" name="profilePic" accept=".jpg,.jpeg,.png">
					<input id="profilePicDisable" type="checkbox" name="profilePicDisable" /> Delete photo
					@if ($errors->has('profilePic'))
						<span class="help-block">
							<strong>{{ $errors->first('profilePic') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button type="submit" class="btn btn-primary">
						{{trans('auth.update')}}
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
@stop
