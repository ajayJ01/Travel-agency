<?php
// app/Http/Controllers/BookingController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factories\BookingFactory;
use App\Models\Booking\Booking;
use App\Models\Booking\PassengerDetails;
use App\Models\Vendor\Vendor;

class BookingController extends Controller
{
    public function bookFlight(Request $request)
    {
        // Example booking details
        $bookingDetails = [
            'user_id' => $request->user()->id,
            'flight_number' => $request->input('flight_number'),
            'seat' => $request->input('seat'),
        ];

        $booking = BookingFactory::create($bookingDetails);

        // Handle booking process (e.g., save to database)

        return redirect()->route('booking.success');
    }

    public function ShowBooking(){
        $bookings = Booking::orderBy('id', 'ASC')->paginate(10);
        return view('admin.booking.index')->with('bookings', $bookings);
    
    }
    public function Detail($id){
        $details = Booking::where('id',$id)->get();
        
        $passengers = PassengerDetails::where('booking_id',$id)->get();
        return view('admin.booking.detail')->with([
            'details'=> $details,
            
            'passengers' => $passengers
        ]);

    }
   
}