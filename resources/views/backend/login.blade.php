@extends('layouts.negivation')
	@section('content')
	@section('title','Đăng nhập')
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 m-auto">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Log in</div>
				<div class="panel-body">
				<form role="form"  method="POST" id='form'>
					@csrf
						<fieldset>
							<div class="form-group">
							<input class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" placeholder="E-mail" name="email" id='email' value="{{old('email')}}" type="email">
								@if($errors->has('email')) 
								<span class="invalid-feedback">{{ $errors->first("email") }}</span>
								@endif
							</div>
							
							<div class="form-group">
							<input class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" placeholder="Password" id='password' name="password"  autofocus type="password" value="{{old('password')}}">
								@if(!$errors->has('email') && $errors->has('password')) 
								<span class="invalid-feedback">{{ $errors->first("password") }}</span>
							@endif
							</div>
							
							<div class="checkbox">
								<label>
									<input name="remember" type="checkbox" value="Remember Me">Remember Me
								</label>
							</div>
							<input type="submit" id='submit' class="btn btn-primary" value="submit">
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	@endsection	
	