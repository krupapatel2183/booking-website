@extends('includes.layout')
@section('content')

	<div class="page-wrapper">
		<div class="content container-fluid">
			<div class="page-header">
				<div class="row align-items-center">
					<div class="col">
						<div class="mt-5">
							<h4 class="card-title float-left mt-2">Booking List</h4>
							<a href="{{ route('booking.create') }}" class="btn btn-primary float-right veiwbutton ">Add Booking</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="card card-table">
						<div class="card-body booking_card">
							<div class="table-responsive">
								<table class="datatable table table-stripped table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Name</th>
											<th>Email</th>
											<th>Date</th>
											<th>Type</th>
											<th>Slot</th>
											<th>Date From</th>
											<th>Date To</th>
										</tr>
									</thead>
									<tbody>
										@foreach($data as $index => $booking)
											<tr>
												
												<td>{{ $booking->name ?? '-' }}</td>
												<td>{{ $booking->email ?? '-' }}</td>
												<td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}</td>
												<td>{{ $booking->type ?? '-' }}</td>
												<td>{{ $booking->slot ?? '-' }}</td>
												<td>{{ $booking->booking_from ?? '-' }}</td>
												<td>{{ $booking->booking_to ?? '-' }}</td>
											</tr>
											@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="delete_asset" class="modal fade delete-modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body text-center"> <img src="assets/img/sent.png" alt="" width="50" height="46">
						<h3 class="delete_class">Are you sure want to delete this Asset?</h3>
						<div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
							<button type="submit" class="btn btn-danger">Delete</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop