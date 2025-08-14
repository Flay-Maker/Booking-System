<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // Show form
    public function create()
    {
        return view('homepage.landing');
    }

    // Admin page view
    public function index()
    {
        
        $bookings = Booking::orderBy('date', 'asc')
        ->orderBy('time', 'asc')
        ->get();
        return view('homepage.admin', compact('bookings'));
    }

    // Store new booking
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'number' => ['required', 'regex:/^09\d{9}$/'], // Valid PH number
            'date' => [
              'required',
              'date',
              'after_or_equal:' . now()->toDateString(),
              'before_or_equal:' . now()->addDays(2)->toDateString(),
            ],
            'time' => [
              'required',
              'date_format:H:i',
              function ($attribute, $value, $fail) {
                if ($value < '08:00' || $value > '23:59') {
                  $fail('Booking time must be between 08:00 AM and 11:59 PM.');
                }
              },
            ],
          ]);
          
        
        Booking::create([
            'fullname' => $request->fullname,
            'number'   => $request->number,
            'date'     => $request->date,
            'time'     => $request->time,
            'status'   => 'Pending',
        ]);

        return redirect()->route('appointment.form')->with('success', 'Appointment booked!');
    }

    public function adminStore(Request $request)
{
    $request->validate([
        'fullname' => 'required|string',
        'number' => ['required', 'regex:/^09\d{9}$/'], // Valid PH number
        'date' => [
          'required',
          'date',
          'after_or_equal:' . now()->toDateString(),
          'before_or_equal:' . now()->addDays(2)->toDateString(),
        ],
        'time' => [
          'required',
          'date_format:H:i',
          function ($attribute, $value, $fail) {
            if ($value < '08:00' || $value > '23:59') {
              $fail('Booking time must be between 08:00 AM and 11:59 PM.');
            }
          },
        ],
      ]);
      

    Booking::create([
        'fullname' => $request->fullname,
        'number' => $request->number,
        'date' => $request->date,
        'time' => $request->time,
        'status' => 'Pending',
    ]);

    return redirect()->route('admin.page')->with('success', 'Booking added successfully!');
}


    // Show edit form (not used if using modal)
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('homepage.edit', compact('booking'));
    }

    // Update booking from modal
    public function update(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required|string',
            'number' => ['required', 'regex:/^09\d{9}$/'], // Valid PH number
            'date' => [
              'required',
              'date',
              'after_or_equal:' . now()->toDateString(),
              'before_or_equal:' . now()->addDays(2)->toDateString(),
            ],
            'time' => [
              'required',
              'date_format:H:i',
              function ($attribute, $value, $fail) {
                if ($value < '08:00' || $value > '23:59') {
                  $fail('Booking time must be between 08:00 AM and 11:59 PM.');
                }
              },
            ],
          ]);
          

        $booking = Booking::findOrFail($id);

        $booking->update([
            'fullname' => $request->fullname,
            'number'   => $request->number,
            'date'     => $request->date,
            'time'     => $request->time,
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.page')->with('success', 'Booking updated.');
    }

    // Delete booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'Deleted';
        $booking->save();

        return redirect()->route('admin.page')->with('success', 'Booking deleted.');
    }

    
}
