
@extends('auth.layout')
@section('content')
	<div class="login-wrapper">
		<div class="container">
			<div class="loginbox">
				<div class="login-left"> <img class="img-fluid" src="assets/img/logo.png" alt="Logo"> </div>
				@if (session('success'))
					<div style="color: green;">
						{{ session('success') }}
					</div>
				@endif
				<div class="login-right">
					<div class="login-right-wrap">
						<h1>Register</h1>
						<p class="account-subtitle"></p>
						
						<form method="post" action="{{ route('submit.register') }}">
						{{ csrf_field() }}
							<div class="form-group">
								<input type="first_name" placeholder="First Name" class="form-box input-box form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}">
								@if ($errors->has('first_name'))
									<p class="help-block text-danger">{{ $errors->first('first_name') }}</p>
								@endif
							</div>
							<div class="form-group">
								<input type="last_name" placeholder="Last Name" class="form-box input-box form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}">
								@if ($errors->has('last_name'))
									<p class="help-block text-danger">{{ $errors->first('last_name') }}</p>
								@endif
							</div>
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
								<button class="btn btn-primary btn-block" type="submit">Register</button>
							</div>
						</form>
						<div class="text-center dont-have">Already Registerd? <a href="{{ route('login') }}">Login</a></div>
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