
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
							{{-- <div class="form-group">
								<input type="name" placeholder="Name" class="form-box input-box form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}">
								@if ($errors->has('name'))
									<p class="help-block text-danger">{{ $errors->first('name') }}</p>
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
								<input type="mobile" placeholder="mobile" class="form-box input-box form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" name="mobile">
								@if ($errors->has('mobile'))
									<p class="help-block text-danger">{{ $errors->first('mobile') }}</p>
								@endif
							</div>
							
							<div class="form-group">
								<select name="country_id" id="country-dropdown" class="form-box input-box form-control {{ $errors->has('country_id') ? 'is-invalid' : '' }}">
									<option value="">Select Country</option>
									@foreach($countries as $country)
									<option value="{{ $country->id }}">{{ $country->name }}</option>
									@endforeach
								</select>
								@if ($errors->has('country_id'))
								<p class="help-block text-danger">{{ $errors->first('country_id') }}</p>
								@endif
							</div>
							<div class="form-group">
								<select name="state_id" id="state-dropdown" class="form-box input-box form-control {{ $errors->has('state_id') ? 'is-invalid' : '' }}">
								</select>
								@if ($errors->has('state_id'))
								<p class="help-block text-danger">{{ $errors->first('state_id') }}</p>
								@endif
							</div>
							<div class="form-group">
								<select name="city_id" id="city-dropdown" class="form-box input-box form-control {{ $errors->has('city_id') ? 'is-invalid' : '' }}">
								</select>
								@if ($errors->has('city_id'))
								<p class="help-block text-danger">{{ $errors->first('city_id') }}</p>
								@endif
							</div>
							<div class="form-group">
								<textarea name="address">{{ old('address') }}</textarea>
								<input type="mobile" placeholder="mobile" class="form-box input-box form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" name="mobile">
								@if ($errors->has('mobile'))
									<p class="help-block text-danger">{{ $errors->first('mobile') }}</p>
								@endif
							</div>
							<div class="form-group">
								<button class="btn btn-primary btn-block" type="submit">Register</button>
							</div> --}}
							 {{-- Name --}}
							<div class="form-group">
								<input type="text" placeholder="Full Name" class="form-box input-box form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}">
								@if ($errors->has('name'))
									<p class="help-block text-danger">{{ $errors->first('name') }}</p>
								@endif
							</div>

							{{-- Email --}}
							<div class="form-group">
								<input type="email" placeholder="Email" class="form-box input-box form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}">
								@if ($errors->has('email'))
									<p class="help-block text-danger">{{ $errors->first('email') }}</p>
								@endif
							</div>

							{{-- Mobile --}}
							<div class="form-group">
								<input type="text" placeholder="Mobile" class="form-box input-box form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}">
								@if ($errors->has('mobile'))
									<p class="help-block text-danger">{{ $errors->first('mobile') }}</p>
								@endif
							</div>

							{{-- Country --}}
							<div class="form-group">
								<select name="country_id" id="country-dropdown" class="form-box input-box form-control {{ $errors->has('country_id') ? 'is-invalid' : '' }}">
									<option value="">Select Country</option>
									@foreach($countries as $country)
										<option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
									@endforeach
								</select>
								@if ($errors->has('country_id'))
									<p class="help-block text-danger">{{ $errors->first('country_id') }}</p>
								@endif
							</div>

							{{-- State --}}
							<div class="form-group">
								<select name="state_id" id="state-dropdown" class="form-box input-box form-control {{ $errors->has('state_id') ? 'is-invalid' : '' }}">
									<option value="">Select State</option>
								</select>
								@if ($errors->has('state_id'))
									<p class="help-block text-danger">{{ $errors->first('state_id') }}</p>
								@endif
							</div>

							{{-- City --}}
							<div class="form-group">
								<select name="city_id" id="city-dropdown" class="form-box input-box form-control {{ $errors->has('city_id') ? 'is-invalid' : '' }}">
									<option value="">Select City</option>
								</select>
								@if ($errors->has('city_id'))
									<p class="help-block text-danger">{{ $errors->first('city_id') }}</p>
								@endif
							</div>

							{{-- Address --}}
							<div class="form-group">
								<textarea placeholder="Address" class="form-box input-box form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address">{{ old('address') }}</textarea>
								@if ($errors->has('address'))
									<p class="help-block text-danger">{{ $errors->first('address') }}</p>
								@endif
							</div>

							{{-- Gender --}}
							<div class="form-group">
								<select name="gender" class="form-box input-box form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}">
									<option value="">Select Gender</option>
									<option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
									<option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
									<option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
								</select>
								@if ($errors->has('gender'))
									<p class="help-block text-danger">{{ $errors->first('gender') }}</p>
								@endif
							</div>

							{{-- Password --}}
							<div class="form-group">
								<input type="password" placeholder="Password" class="form-box input-box form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password">
								@if ($errors->has('password'))
									<p class="help-block text-danger">{{ $errors->first('password') }}</p>
								@endif
							</div>

							{{-- Confirm Password --}}
							<div class="form-group">
								<input type="password" placeholder="Confirm Password" class="form-box input-box form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" name="password_confirmation">
								@if ($errors->has('password_confirmation'))
									<p class="help-block text-danger">{{ $errors->first('password_confirmation') }}</p>
								@endif
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