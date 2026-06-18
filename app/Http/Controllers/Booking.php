<?php

namespace App\Http\Controllers;

use App\Helpers\ContactHelper;
use App\Mail\NewBookingNotification;
use App\Models\Booking as BookingModel;
use App\Models\Service;
use App\Models\Fleet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class Booking extends Controller
{
    //
    public function index(Request $request)
    {
        $contact = ContactHelper::getActive();
        $services = Service::query('slug','title')->where('status', true)->get();
        $selectedService = $request->query('service');

        $fleet = $this->getAllFleet();

        return view('booking', [
            'services' => $services,
            'selectedService' => $selectedService,
            'fleet' => $fleet,
            'contact' => $contact
        ]);
    }

    public function getAllFleet()
    {
        return Fleet::query()->where('active', true)->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_type' => 'required',
            'vehicle_type' => 'required',
            'name' => 'required|min:5|max:75',
            'email' => 'required|email',
            'phone' => 'required|regex:/^0[6-8][0-9]{8}$/',
            'pickup_address' => 'required',
            'pickup_time' => 'required',
            'dropoff_address' => 'required_if:service_type,airport-transfers,hotel-transfers',
            'dropoff_time' => 'required_if:service_type,car-hire',
            'transmission' => 'required_if:service_type,car-hire',
            'flight_number' => 'nullable|string|max:255',
            'reservation_number' => 'nullable|string|max:255',
            'id_number' => 'required_if:service_type,car-hire',
            'passengers' => [
                'nullable',
                'integer',
                Rule::requiredIf(fn () => in_array($request->input('service_type'), ['tours_safaris', 'trips'], true)),
            ],
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Persist only validated fields.
        $booking = BookingModel::create($validator->validated());

        try {
            Mail::to(config('mail.booking_notification_email'))->send(new NewBookingNotification($booking));
        } catch (Throwable $throwable) {
            Log::error('Booking notification email failed to send.', [
                'booking_id' => $booking->id,
                'message' => $throwable->getMessage(),
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Your booking request has been submitted successfully. We will contact you shortly.');
    }
}
