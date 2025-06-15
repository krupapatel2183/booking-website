@extends('includes.layout')
@section('content')

	<div class="page-wrapper">
		<div class="content container-fluid">
			<div class="page-header">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="page-title mt-5">Add Booking</h3> </div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					{{-- <form method="post" action="{{ route('store.booking') }}"> --}}
					<div id="successMessage" class="alert alert-success d-none"></div>
					<form id="bookingForm">
					{{ csrf_field() }}
						<div class="row formtype">
							<div class="col-md-4">
								<div class="form-group">
									<label>Name</label>
									<input type="name" placeholder="Name" class="form-box input-box form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}">
									<span class="text-danger error-text name_error"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Email</label>
									<input type="email" placeholder="Email" class="form-box input-box form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}">
									<span class="text-danger error-text email_error"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Date</label>
									<div class="cal-icon">
										<input type="text" class="form-box input-box form-control datetimepicker {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date" value="{{ old('date') }}">
										<span class="text-danger error-text date_error"></span>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Booking Type</label>
									<select class="form-control" id="type" name="type">
										<option value="">Select</option>
										<option value="Full Day">Full Day</option>
										<option value="Half Day">Half Day</option>
										<option value="Custom">Custom</option>
									</select>
									<span class="text-danger error-text type_error"></span>
								</div>
							</div>
							<div class="col-md-4 booking-slot d-none">
								<div class="form-group">
									<label>Booking Slot</label>
									<select class="form-control" id="slot" name="slot">
										<option value="">Select</option>
										<option value="First Half">First Half</option>
										<option value="Second Half">Second Half</option>
									</select>
									<span class="text-danger error-text slot_error"></span>
								</div>
							</div>
							<div class="col-md-4 booking-time d-none">
								<div class="form-group">
									<label>Booking From</label>
									<div class="cal-icon">
										<input type="text" name="booking_from" class="form-box input-box form-control timepicker {{ $errors->has('booking_from') ? 'is-invalid' : '' }}" value="{{ old('booking_from') }}">
										<span class="text-danger error-text booking_from_error"></span>
									</div>
								</div>
							</div>

							<div class="col-md-4 booking-time d-none">
								<div class="form-group">
									<label>Booking To</label>
									<div class="cal-icon">
										<input type="text" name="booking_to" class="form-box input-box form-control timepicker {{ $errors->has('booking_to') ? 'is-invalid' : '' }}" value="{{ old('booking_to') }}">
										<span class="text-danger error-text booking_to_error"></span>
									</div>
								</div>
							</div>
	
						</div>
						<button type="submit" class="btn btn-primary">Create Booking</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@push('custom-scripts')
<script type="text/javascript">

	$(function () {

		$('.datetimepicker').datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		$('.timepicker').datetimepicker({
			format: 'HH:mm:ss',  // 24-hour format
			icons: {
				up: "fa fa-angle-up",
				down: "fa fa-angle-down"
			}
		});

		$('body').on('change', '#type', function(e) {
			let tmpVal = $(this).val();
			if(tmpVal == 'Half Day'){
				$('.booking-slot').removeClass('d-none');
				$('.booking-time').addClass('d-none');
			}else if(tmpVal == 'Custom'){
				$('.booking-time').removeClass('d-none');
				$('.booking-slot').addClass('d-none');
			} else {
				$('.booking-slot').addClass('d-none');
				$('.booking-time').addClass('d-none');
			}
		});

		$('#bookingForm').on('submit', function (e) {
			e.preventDefault();

			let formData = $(this).serialize();

			$.ajax({
				url: "{{ route('booking.store') }}",
				type: "POST",
				data: formData,
				success: function (response) {
					$('#bookingForm')[0].reset();
					$('.error-text').text('');
					$('#successMessage').removeClass('d-none').text('Booking successful!');
					window.location.href = "{{ route('booking.index') }}"
				},
				error: function (xhr) {
					$('.error-text').text(''); // clear all old errors
					if (xhr.responseJSON && xhr.responseJSON.errors) {
						$.each(xhr.responseJSON.errors, function (key, messages) {
							$('.' + key + '_error').text(messages[0]);
						});
					}
				}
			});
		});
	});
</script>
@endpush
@stop