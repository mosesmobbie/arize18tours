@props([
    'services' => collect(),
    'selectedService' => 'shuttle',
    'wide' => false,
])

@php
    $pickupDateValue = '';
    $pickupTimeValue = '10:00';
    $pickupDateTime = old('pickup_time');
    $dropoffDateValue = '';
    $dropoffTimeValue = '10:00';
    $dropoffDateTime = old('dropoff_time');
    $pickupTimeOptions = [];

    if (filled($pickupDateTime)) {
        $pickupDateParts = preg_split('/[T ]/', $pickupDateTime);
        $pickupDateValue = $pickupDateParts[0] ?? '';
        $pickupTimeValue = isset($pickupDateParts[1]) ? substr($pickupDateParts[1], 0, 5) : '';
    }

    if (filled($dropoffDateTime)) {
        $dropoffDateParts = preg_split('/[T ]/', $dropoffDateTime);
        $dropoffDateValue = $dropoffDateParts[0] ?? '';
        $dropoffTimeValue = isset($dropoffDateParts[1]) ? substr($dropoffDateParts[1], 0, 5) : '';
    }

    for ($hour = 0; $hour < 24; $hour++) {
        foreach ([0, 15, 30, 45] as $minute) {
            $pickupTimeOptions[] = sprintf('%02d:%02d', $hour, $minute);
        }
    }
@endphp

<style>
    #booking.booking-card {
        width: min(1240px, calc(100% - 20px));
        max-width: 1216px;
        margin: 24px auto;
        padding: 0;
        box-sizing: border-box;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
    }

    #booking.booking-card.booking-card--wide {
        width: min(1500px, calc(100% - 20px));
        max-width: 1460px;
    }

    #booking .booking-card-header {
        margin-bottom: 0;
        background: #111d32;
        padding: 16px 22px;
    }

    #booking .booking-card-header h3 {
        margin: 0;
        font-size: 17px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #fff;
    }

    #booking .booking-tabs {
        margin-bottom: 0;
        display: flex;
        border-bottom: 2px solid #e8eaed;
        background: #f5f5f7;
    }

    #booking .booking-tab {
        flex: 1;
        padding: 12px;
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;

        color: #8a8f9a;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        transition: all 0.2s ease;
    }

    #booking .booking-tab.active {
        color: #c8202f;
        border-bottom-color: #c8202f;
        background: #fff;
    }

    #booking form {
        padding: 18px 22px 22px;
    }

    #booking .booking-two-column {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    #booking .booking-two-column > .form-row,
    #booking .booking-two-column > .form-group.full {
        flex: 0 0 calc(50% - 5px);
        max-width: calc(50% - 5px);
    }

    #booking .booking-two-column > .booking-submit-row,
    #booking .booking-two-column > .booking-success-row {
        flex: 0 0 100%;
        max-width: 100%;
    }

    #booking .booking-two-column .form-row .form-group {
        width: 100%;
        margin: 0;
    }

    #booking .pickup-date-row,
    #booking .pickup-time-row,
    #booking .dropoff-date-row,
    #booking .dropoff-time-select-row {
        flex: 0 0 calc(50% - 5px);
        max-width: calc(50% - 5px);
    }

    #booking .form-group {
        gap: 5px;
    }

    #booking label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        color: #1b2b4b;
    }

    #booking .form-control {
        padding: 10px 12px;
        border: 1px solid #e8eaed;
        border-radius: 6px;
        font-size: 13px;
    }

    #booking .form-control:focus {
        border-color: #c8202f;
        box-shadow: 0 0 0 3px rgba(200, 32, 47, 0.1);
        outline: none;
    }

    #booking .text-danger {
        font-size: 12px;
    }

    #booking .booking-two-column .booking-submit-row {
        flex: 0 0 100%;
        max-width: 100%;
        margin-top: 4px;
    }

    #booking .booking-submit-row .btn-primary {
        width: 100%;
        padding: 12px 14px;
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    #booking .booking-two-column .notes-row {
        flex: 0 0 100%;
        max-width: 100%;
    }

    @media (max-width: 768px) {
        #booking.booking-card {
            width: calc(100% - 8px);
            margin: 12px auto;
        }

        #booking.booking-card.booking-card--wide {
            width: calc(100% - 6px);
        }

        #booking form {
            padding: 16px;
        }

        #booking .booking-two-column > .form-row,
        #booking .booking-two-column > .form-group.full {
            flex: 0 0 100%;
            max-width: 100%;
        }

         input,
        select {
            color: #1f2937!important;
        }
    }
</style>

<div class="booking-card {{ $wide ? 'booking-card--wide' : '' }}" id="booking">
    <div class="booking-card-header">
        <h3>Request a Quote</h3>
    </div>
    <div class="booking-tabs">
        <div class="booking-tab active" data-service-type="shuttle">Shuttle</div>
        <div class="booking-tab" data-service-type="airport-transfers">Airport Transfer</div>
        <div class="booking-tab" data-service-type="car-hire">Self-Drive</div>
    </div>
    <form action="{{ route('booking.store') }}" method="POST" novalidate>
        @csrf
        <div class="row justify-content-center booking-two-column">
            <div class="form-row">
                <div class="form-group">
                    <label>Service Type</label>
                    <select name="service_type" class="form-control">
                        <option value="">Select service type</option>
                        @foreach($services as $service)
                            <option value="{{ $service->slug }}" @selected(old('service_type', $selectedService) === $service->slug)>
                                {{ $service->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Vehicle Type</label>
                    <select name="vehicle_type" class="form-control">
                        <option value="">Select vehicle type</option>
                        <option value="standard" @selected(old('vehicle_type') === 'standard')>Standard</option>
                        <option value="executive" @selected(old('vehicle_type') === 'executive')>Executive</option>
                        <option value="suv" @selected(old('vehicle_type') === 'suv')>SUV</option>
                        <option value="minivan" @selected(old('vehicle_type') === 'minivan')>Mini-Van</option>
                        <option value="minibus" @selected(old('vehicle_type') === 'minibus')>Minibus/Shuttle</option>
                        <option value="bus" @selected(old('vehicle_type') === 'bus')>Coach/Bus</option>
                    </select>
                    @error('vehicle_type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>FullName</label>
                    <input type="text" name="name" class="form-control" placeholder="Name and Surname"/>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"/>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="e.g.07123456789"/>
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Pickup Address</label>
                    <input type="text" name="pickup_address" class="form-control"/>
                    @error('pickup_address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row" id="field-dropoff-address-row">
                <div class="form-group">
                    <label id="dropoff-address-label">Drop Off Address</label>
                    <input type="text" name="dropoff_address" class="form-control"/>
                    @error('dropoff_address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row pickup-date-row">
                <div class="form-group">
                    <label>Pickup Date</label>
                    <input type="date" name="pickup_date" class="form-control" value="{{ $pickupDateValue }}"/>
                </div>
            </div>
            <div class="form-row pickup-time-row">
                <div class="form-group">
                    <label>Pickup Time</label>
                    <select name="pickup_time_display" class="form-control">
                        <option value="">Select pickup time</option>
                        @foreach ($pickupTimeOptions as $pickupTimeOption)
                            <option value="{{ $pickupTimeOption }}" @selected($pickupTimeValue === $pickupTimeOption)>{{ $pickupTimeOption }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="pickup_time" value="{{ old('pickup_time') }}"/>
                    @error('pickup_time') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row dropoff-date-row" id="field-dropoff-date-row">
                <div class="form-group">
                    <label id="dropoff-date-label">Drop Off Date</label>
                    <input type="date" name="dropoff_date" class="form-control" value="{{ $dropoffDateValue }}"/>
                </div>
            </div>
            <div class="form-row dropoff-time-select-row" id="field-dropoff-time-row">
                <div class="form-group">
                    <label id="dropoff-time-label">Drop Off Time</label>
                    <select name="dropoff_time_display" class="form-control">
                        <option value="">Select drop off time</option>
                        @foreach ($pickupTimeOptions as $pickupTimeOption)
                            <option value="{{ $pickupTimeOption }}" @selected($dropoffTimeValue === $pickupTimeOption)>{{ $pickupTimeOption }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="dropoff_time" value="{{ old('dropoff_time') }}"/>
                    @error('dropoff_time') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row" id="field-passengers-row">
                <div class="form-group">
                    <label>Passengers</label>
                    <input type="text" name="passengers" class="form-control"/>
                    @error('passengers') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row" id="field-transmission-row">
                <div class="form-group">
                    <label>Transmission</label>
                    <select name="transmission" class="form-control">
                        <option value="">Select transmission</option>
                        <option value="manual" @selected(old('transmission') === 'manual')>Manual</option>
                        <option value="auto" @selected(old('transmission') === 'auto')>Auto</option>
                    </select>
                    @error('transmission') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row" id="field-flight-number-row">
                <div class="form-group">
                    <label>Flight Number</label>
                    <input type="text" name="flight_number" class="form-control"/>
                    @error('flight_number') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row" id="field-reservation-number-row">
                <div class="form-group">
                    <label>Reservation Ref</label>
                    <input type="text" name="reservation_number" class="form-control"/>
                    @error('reservation_number') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row" id="field-id-number-row">
                <div class="form-group">
                    <label>ID/Passport</label>
                    <input type="text" name="id_number" class="form-control"/>
                    @error('id_number') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row notes-row">
                <div class="form-group">
                    <label>Additional Info</label>
                    <input type="text" name="notes" class="form-control" placeholder="Car Seat, Wheel Chair, Luggage, etc"/>
                    @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            @if (session('success'))
            <div class="form-row notes-row">
                <div class="form-group full booking-success-row">
                        <div class="rounded-lg border border-green-300 bg-green-100 px-3 py-2 text-sm font-semibold text-green-800">
                            {{ session('success') }}
                        </div>
                </div>
            </div>
            @endif
             <div class="form-row">
                <div class="form-group full booking-submit-row">
                    <button type="submit" class="button btn-primary">Submit</button>
                </div>
             </div>
        </div>
    </form>
</div>
