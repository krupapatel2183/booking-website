
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
								<input type="text" placeholder="Full Name" class="form-box input-box form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}">
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
								<input type="text" placeholder="Mobile" class="form-box input-box form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}">
								@if ($errors->has('mobile'))
									<p class="help-block text-danger">{{ $errors->first('mobile') }}</p>
								@endif
							</div>

							<div class="form-group">
								<select name="country" id="country-dropdown" class="form-box input-box form-control {{ $errors->has('country') ? 'is-invalid' : '' }}">
									<option value="">Select Country</option>
									@foreach($countries as $country)
										<option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
									@endforeach
								</select>
								@if ($errors->has('country'))
									<p class="help-block text-danger">{{ $errors->first('country') }}</p>
								@endif
							</div>

							<div class="form-group">
								<select name="state" id="state-dropdown" class="form-box input-box form-control {{ $errors->has('state') ? 'is-invalid' : '' }}">
									<option value="">Select State</option>
								</select>
								@if ($errors->has('state'))
									<p class="help-block text-danger">{{ $errors->first('state') }}</p>
								@endif
							</div>

							<div class="form-group">
								<select name="city" id="city-dropdown" class="form-box input-box form-control {{ $errors->has('city') ? 'is-invalid' : '' }}">
									<option value="">Select City</option>
								</select>
								@if ($errors->has('city'))
									<p class="help-block text-danger">{{ $errors->first('city') }}</p>
								@endif
							</div>

							<div class="form-group">
								<textarea placeholder="Address" class="form-box input-box form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address">{{ old('address') }}</textarea>
								@if ($errors->has('address'))
									<p class="help-block text-danger">{{ $errors->first('address') }}</p>
								@endif
							</div>

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

							<div class="form-group">
								<input type="password" placeholder="Password" class="form-box input-box form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password">
								@if ($errors->has('password'))
									<p class="help-block text-danger">{{ $errors->first('password') }}</p>
								@endif
							</div>

							<div class="form-group">
								<input type="password" placeholder="Confirm Password" class="form-box input-box form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" name="password_confirmation">
								@if ($errors->has('password_confirmation'))
									<p class="help-block text-danger">{{ $errors->first('password_confirmation') }}</p>
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
	
	$(document).ready(function () {
		let oldCountry = "{{ old('country') }}";
		let oldState = "{{ old('state') }}";
		let oldCity = "{{ old('city') }}";

		// Load States based on selected country
		function loadStates(countryId, selectedState = null) {
			if (countryId) {
				$.ajax({
					url: '/states/' + countryId,
					type: 'GET',
					success: function(states) {
						$('#state-dropdown').empty().append('<option value="">Select State</option>');
						$.each(states, function(key, state) {
							$('#state-dropdown').append(
								'<option value="' + state.id + '"' + 
								(selectedState == state.id ? ' selected' : '') + 
								'>' + state.name + '</option>'
							);
						});

						if (selectedState) {
							$('#state-dropdown').val(selectedState).trigger('change');
						}
					}
				});
			}
		}

		// Load Cities based on selected state
		function loadCities(stateId, selectedCity = null) {
			if (stateId) {
				$.ajax({
					url: '/cities/' + stateId,
					type: 'GET',
					success: function(cities) {
						$('#city-dropdown').empty().append('<option value="">Select City</option>');
						$.each(cities, function(key, city) {
							$('#city-dropdown').append(
								'<option value="' + city.id + '"' + 
								(selectedCity == city.id ? ' selected' : '') + 
								'>' + city.name + '</option>'
							);
						});

						if (selectedCity) {
							$('#city-dropdown').val(selectedCity);
						}
					}
				});
			}
		}

		// Trigger on country change
		$('#country-dropdown').on('change', function () {
			var countryId = $(this).val();
			$('#state-dropdown').empty().append('<option value="">Loading...</option>');
			$('#city-dropdown').empty().append('<option value="">Select City</option>');
			loadStates(countryId);
		});

		// Trigger on state change
		$('#state-dropdown').on('change', function () {
			var stateId = $(this).val();
			$('#city-dropdown').empty().append('<option value="">Loading...</option>');
			loadCities(stateId);
		});

		// If old values exist (after form error), load them
		if (oldCountry) {
			loadStates(oldCountry, oldState);
		}
		if (oldState) {
			loadCities(oldState, oldCity);
		}
	});

</script>
@endpush
@stop