@extends('auth.layout')
@section('content')
	<div class="login-wrapper">
		<div class="container">
			<div class="loginbox">
				<div class="login-left"> <img class="img-fluid" src="assets/img/logo.png" alt="Logo"> </div>
				<div class="login-right">
					<div class="login-right-wrap">
						<h1>Login</h1>
						<p class="account-subtitle">Access to our dashboard</p>
						@if (session('error'))
							<div style="color: red;">
								{{ session('error') }}
							</div>
						@endif
						<form method="post" action="{{ route('submit.login') }}">
						{{ csrf_field() }}
							<div class="form-group">
								<input type="email" placeholder="Email" class="form-box input-box form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}">
								@if ($errors->has('email'))
									<p class="help-block text-danger">{{ $errors->first('email') }}</p>
								@endif
							</div>
							<div class="form-group">
								<input type="password" placeholder="Password" class="form-box input-box form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password">
								@if ($errors->has('password'))
									<p class="help-block text-danger">{{ $errors->first('password') }}</p>
								@endif
							</div>
							<div class="form-group">
								<button class="btn btn-primary btn-block" type="submit">Login</button>
							</div>
						</form>
						<div class="text-center dont-have">Don’t have an account? <a href="{{ route('register') }}">Register</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@push('custom-scripts')
<script type="text/javascript">

</script>
@endpush
@stop