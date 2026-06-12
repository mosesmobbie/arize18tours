<footer id="contact">
    <div class="footer-inner">
        <div class="footer-brand">
            <img src="{{ asset('images/logo-white.png') }}" alt="Arize18 Logo" style="height: 50px; width: auto; margin-bottom: 12px; filter: saturate(0.9);">
            <div class="logo-text" style="color:white; margin-top: 6px;">ARIZE18 Travel &amp; Tours</div>
            <p class="footer-tagline">Arize18 Tours is a black-owned business based in the Gauteng province, providing professional shuttle services in and around Johannesburg and surrounding provinces since 2022.</p>
            <ul class="footer-icons" style="display: flex; gap: 16px; align-items: center; padding: 12px; border-radius: 4px; margin-top: 16px; list-style: none;">
                @if(isset($contact->address) && !empty($contact->address))
                <li style="display: inline;"><a title="view map" href="https://www.google.com/maps/place/{{ urlencode($contact->address) }}" target="_blank" rel="noopener noreferrer"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" aria-hidden="true" width="24" height="24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg><span class="sr-only">Address</span></a></li>
                @endif
                @if(isset($contact->whatsapp) && !empty($contact->whatsapp))
                <li style="display: inline;"><a title="WhatsApp" href="https://wa.me/{{ preg_replace('/\D/', '', $contact->whatsapp) }}" target="_blank" rel="noopener noreferrer"><span class="cta-icon cta-icon--whatsapp" style="width:24px;height:24px;flex:0 0 24px;"></span><span class="sr-only">WhatsApp</span></a></li>
                @endif
                @if(isset($contact->phone) && !empty($contact->phone))
                <li style="display: inline;"><a title="Phone" href="tel:{{ preg_replace('/\D/', '', $contact->phone) }}"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" aria-hidden="true" width="24" height="24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg><span class="sr-only">Phone</span></a></li>
                @endif
                @if(isset($contact->email) && !empty($contact->email))
                <li style="display: inline;"><a title="Email" href="mailto:{{ $contact->email }}"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" aria-hidden="true" width="24" height="24"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg><span class="sr-only">Email</span></a></li>
                @endif
                @if(isset($contact->facebook) && !empty($contact->facebook))
                <li style="display: inline;"><a title="Facebook" href="{{ $contact->facebook }}" target="_blank" rel="noopener noreferrer"><svg class="icon" viewBox="0 0 24 24" fill="white" aria-hidden="true" width="24" height="24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg><span class="sr-only">Facebook</span></a></li>
                @endif
            </ul>
        </div>
        <div class="footer-col">
            <h4>Services</h4>
            <ul class="footer-links">
                <li><a href="{{ route('services', ['slug' => 'shuttle']) }}">Shuttle Services</a></li>
                <li><a href="{{ route('services', ['slug' => 'car-hire']) }}">Self-Drive</a></li>
                <li><a href="{{ route('services', ['slug' => 'airport-transfers']) }}">Airport Transfers</a></li>
                <li><a href="{{ route('services', ['slug' => 'tours-safaris']) }}">Tours &amp; Safaris</a></li>
                <li><a href="{{ route('services', ['slug' => 'chauffer']) }}">Chauffer Drive</a></li>
                <li><a href="{{ route('services', ['slug' => 'hotel-transfers']) }}">Hotel Transfers</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Company</h4>
            <ul class="footer-links">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about-us') }}">About Us</a></li>
                <li><a href="{{ route('services', ['slug' => 'shuttle']) }}">Services</a></li>
                <li><a href="{{ route('home') }}#fleet">Fleet</a></li>
                <li><a href="{{ route('booking') }}">Booking</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Contacts</h4>
            @php
                $formatSaNumber = static function (?string $value): string {
                    $digits = preg_replace('/\D+/', '', $value ?? '');

                    if ($digits === '') {
                        return '';
                    }

                    if (str_starts_with($digits, '0')) {
                        $digits = '27' . substr($digits, 1);
                    } elseif (!str_starts_with($digits, '27') && strlen($digits) === 9) {
                        $digits = '27' . $digits;
                    }

                    if (strlen($digits) < 11) {
                        return '+' . $digits;
                    }

                    return '+' . substr($digits, 0, 2) . ' ' . substr($digits, 2, 2) . ' ' . substr($digits, 4, 3) . ' ' . substr($digits, 7, 4);
                };

                $whatsappDisplay = $formatSaNumber($contact->whatsapp ?? null);
                $phoneDisplay = $formatSaNumber($contact->phone ?? null);
            @endphp
            <ul class="footer-links">
                @if(isset($contact->address) && !empty($contact->address))
                <li><a href="https://www.google.com/maps/place/{{ urlencode($contact->address) }}" target="_blank" rel="noopener noreferrer">{{ $contact->address }}</a></li>
                @endif
                @if(isset($contact->whatsapp) && !empty($contact->whatsapp))
                <li><a href="https://wa.me/{{ preg_replace('/\D/', '', $contact->whatsapp) }}" target="_blank" rel="noopener noreferrer">{{ $whatsappDisplay ?: $contact->whatsapp }}</a></li>
                @endif
                @if(isset($contact->phone) && !empty($contact->phone))
                <li><a href="tel:{{ preg_replace('/\D/', '', $contact->phone) }}">{{ $phoneDisplay ?: $contact->phone }}</a></li>
                @endif
                @if(isset($contact->email) && !empty($contact->email))
                <li><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></li>
                @endif
            </ul>
        </div>
    </div>
    <div class="footer-inner">
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} <a href="#">Arize18 (PTY) LTD</a>. All rights reserved.</p>
        </div>
    </div>
</footer>
