<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;

class BookingController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $user = Auth::id();
            $query = "SELECT * FROM bookings WHERE user_id = '$user' AND deleted_at IS NULL ORDER BY created_at DESC";
            $data = DB::select($query);
            return view('booking.list', compact('data'));
        } else {
            return redirect()->route('login');
        }
    }

    public function create()
    {
        return view('booking.add');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            Booking::validateData($data);
            $user = Auth::id();
            // Proceed with saving
            $booking = new Booking();
            $booking->id = Str::uuid(); 
            $booking->name = $data['name'];
            $booking->email = $data['email'] ?? null;
            $booking->booking_date = $data['date'];
            $booking->type = $data['type'];
            $booking->slot = $data['slot'] ?? null;
            $booking->booking_from = $data['booking_from'] ?? null;
            $booking->booking_to = $data['booking_to'] ?? null;
            $booking->user_id = $user;
            $booking->save();
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }
    }
}
