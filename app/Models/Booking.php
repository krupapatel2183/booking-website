<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Validator;
use DB;
use Illuminate\Support\Facades\Auth;

class Booking  extends Model
{
    public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'email', 'booking_date', 'type', 'slot', 'booking_from', 'booking_to','user_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    public static function validateData(array $data)
    {
        $rules = [];

        $rules['name'] = [
            function ($attribute, $value, $fail) {
                if (empty($value)) {
                    $fail("Name is required.");
                }
            }
        ];

        $rules['email'] = [
            function ($attribute, $value, $fail) {
                if (empty($value)) {
                    $fail("Email is required.");
                } else if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $fail("Invalid email format.");
                }
            }
        ];

        $rules['date'] = [
            function ($attribute, $value, $fail) use ($data) {
                if (empty($value)) {
                    $fail("Date is required.");
                    return;
                }
        
                $type = $data['type'] ?? null;
                $slot = $data['slot'] ?? null;
                $from = $data['booking_from'] ?? null;
                $to   = $data['booking_to'] ?? null;
        
                if ($type == 'Full Day') {
                    $exists = DB::table('bookings')
                        ->where('user_id', Auth::user()->id)
                        ->whereNull('deleted_at')
                        ->whereDate('booking_date', $value)
                        ->whereIn('type', ['Full Day', 'Half Day', 'Custom'])
                        ->exists();
        
                    if ($exists) {
                        $fail("This date already has bookings and cannot be booked.");
                    }
        
                } elseif ($type == 'Half Day') {
                    if (empty($slot)) {
                        $fail("Slot is required for Half Day booking.");
                        return;
                    }
                
                    $exists = DB::table('bookings')
                        ->where('user_id', Auth::user()->id)
                        ->whereNull('deleted_at')
                        ->whereDate('booking_date', $value)
                        ->where('type', 'Full Day')
                        ->exists();
                
                    if ($exists) {
                        $fail("This date already has a full day booking.");
                        return;
                    }
                
                    $halfSlotExists = DB::table('bookings')
                        ->where('user_id', Auth::user()->id)
                        ->whereNull('deleted_at')
                        ->whereDate('booking_date', $value)
                        ->where('type', 'Half Day')
                        ->where('slot', $slot)
                        ->exists();
                
                    if ($halfSlotExists) {
                        $fail("This half slot is already booked.");
                        return;
                    }
                
                    $firstHalfStart = '06:00:00';
                    $firstHalfEnd   = '14:00:00';
                    $secondHalfStart = '14:00:00';
                    $secondHalfEnd   = '22:00:00';
                
                    if ($slot === 'First Half') {
                        $customConflict = DB::table('bookings')
                            ->where('user_id', Auth::user()->id)
                            ->whereNull('deleted_at')
                            ->whereDate('booking_date', $value)
                            ->where('type', 'Custom')
                            ->where(function ($q) use ($firstHalfStart, $firstHalfEnd) {
                                $q->where('booking_from', '<', $firstHalfEnd)
                                  ->where('booking_to', '>', $firstHalfStart);
                            })
                            ->exists();
                
                        if ($customConflict) {
                            $fail("Cannot book First Half — Custom booking overlaps this slot.");
                            return;
                        }
                    }
                
                    if ($slot === 'Second Half') {
                        $customConflict = DB::table('bookings')
                            ->where('user_id', Auth::user()->id)
                            ->whereNull('deleted_at')
                            ->whereDate('booking_date', $value)
                            ->where('type', 'Custom')
                            ->where(function ($q) use ($secondHalfStart, $secondHalfEnd) {
                                $q->where('booking_from', '<', $secondHalfEnd)
                                  ->where('booking_to', '>', $secondHalfStart);
                            })
                            ->exists();
                
                        if ($customConflict) {
                            $fail("Cannot book Second Half — Custom booking overlaps this slot.");
                            return;
                        }
                    }
                    
                } elseif ($type == 'Custom') {
                    $from = $data['booking_from'] ?? null;
                    $to = $data['booking_to'] ?? null;
                    $date = $value; // already validated as booking_date

                    if (!$from || !$to) {
                        $fail("Start and end time are required for Custom booking.");
                        return;
                    }

                    $firstHalfStart = '06:00:00';
                    $firstHalfEnd = '14:00:00';
                    $secondHalfStart = '14:00:00';
                    $secondHalfEnd = '22:00:00';

                    if (
                        !(($from >= $firstHalfStart && $to <= $firstHalfEnd) ||
                        ($from >= $secondHalfStart && $to <= $secondHalfEnd)
                        )
                    ) {
                        $fail("Custom booking time must be fully within First Half (06:00–14:00) or Second Half (14:00–22:00).");
                        return;
                    }

                    $fullDayExists = DB::table('bookings')
                        ->where('user_id', Auth::user()->id)
                        ->whereNull('deleted_at')
                        ->whereDate('booking_date', $date)
                        ->where('type', 'Full Day')
                        ->exists();

                    if ($fullDayExists) {
                        $fail("This date is already fully booked (Full Day).");
                        return;
                    }

                    $halfDayConflict = DB::table('bookings')
                                ->where('user_id', Auth::user()->id)
                                ->whereNull('deleted_at')
                                ->whereDate('booking_date', $date)
                                ->where('type', 'Half Day')
                                ->where(function ($q) use ($from, $to, $firstHalfStart, $firstHalfEnd, $secondHalfStart, $secondHalfEnd) {
                                    $q->where(function ($q1) use ($from, $to, $firstHalfStart, $firstHalfEnd) {
                                        // Custom time overlaps First Half slot (06:00–14:00)
                                        $q1->where('slot', 'First Half')
                                        ->whereRaw('? < ? AND ? > ?', [$from, $firstHalfEnd, $to, $firstHalfStart]);
                                    })->orWhere(function ($q2) use ($from, $to, $secondHalfStart, $secondHalfEnd) {
                                        // Custom time overlaps Second Half slot (14:00–22:00)
                                        $q2->where('slot', 'Second Half')
                                        ->whereRaw('? < ? AND ? > ?', [$from, $secondHalfEnd, $to, $secondHalfStart]);
                                    });
                                })
                                ->exists();

                    if ($halfDayConflict) {
                        $fail("This time range conflicts with a Half Day booking.");
                        return;
                    }

                    $customOverlap = DB::table('bookings')
                        ->where('user_id', Auth::user()->id)
                        ->whereNull('deleted_at')
                        ->whereDate('booking_date', $date)
                        ->where('type', 'Custom')
                        ->where(function ($q) use ($from, $to) {
                            $q->where('booking_from', '<', $to)
                            ->where('booking_to', '>', $from);
                        })
                        ->exists();

                    if ($customOverlap) {
                        $fail("This time overlaps with another Custom booking.");
                        return;
                    }
                }
            }
        ];
        
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return true;
        
    }
}
