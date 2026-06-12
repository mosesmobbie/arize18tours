<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{  isset($metaTitle) ? $metaTitle: 'Arize18 Travel & Tours'}}</title>
        <meta name="author" content="Tiyisani Mchavi">
        <meta name="description" content="{{ isset($metaDescription) ? $metaDescription : 'Shuttle Services, Airport Transfers, Hotel Transfers, Tours & Safaris, Chauffer Drive, reservation_number, Doot to Door, Social Events' }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <header>
                <nav>
                    <a href="{{ route('home') }}" class="nav-logo" aria-label="Arize18 home">
                        <img src="{{ asset('images/logo-white.png') }}" alt="Arize18 Logo" style="height: 50px; width: auto;">
                    </a>
                    <ul class="nav-links" id="primaryNav">
                        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}" @if(request()->routeIs('home')) aria-current="page" @endif>Home</a></li>
                        <li><a href="{{ route('about-us') }}" class="{{ request()->routeIs('about-us') ? 'is-active' : '' }}" @if(request()->routeIs('about-us')) aria-current="page" @endif>About</a></li>
                        <li><a href="{{ route('services', ['slug' => 'shuttle']) }}" class="{{ request()->routeIs('services') ? 'is-active' : '' }}" @if(request()->routeIs('services')) aria-current="page" @endif>Services</a></li>
                        <li><a href="{{ route('home') }}#fleet">Fleet</a></li>
                        <li><a href="{{ route('booking') }}" class="{{ request()->routeIs('booking') ? 'is-active' : '' }}" @if(request()->routeIs('booking')) aria-current="page" @endif>Booking</a></li>
                        <li class="nav-mobile-cta"><a href="#" class="nav-cta nav-cta-whatsapp"><span class="nav-whatsapp-icon" aria-hidden="true"></span><span>WhatsApp</span></a></li>
                    </ul>
                    <div class="nav-right">
                        <a href="#" class="nav-cta nav-cta-desktop nav-cta-whatsapp" id="navAuthLink"><span class="nav-whatsapp-icon" aria-hidden="true"></span><span>WhatsApp</span></a>
                        <button type="button" class="nav-toggle" id="mobileNavToggle" aria-expanded="false" aria-controls="primaryNav" aria-label="Toggle navigation menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </nav>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <footer id="contact">
                <div class="footer-inner">
                    <div class="footer-brand">
                        <img src="{{ asset('images/logo-white.png') }}" alt="Arize18 Logo" style="height: 50px; width: auto; margin-bottom: 12px; filter: saturate(0.9);">
                        <div class="logo-text" style="color:white; margin-top: 6px;">Travel &amp; Tours</div>
                        <p class="footer-tagline">Arize18 Tours is a black-owned business based in the Gauteng province, providing professional shuttle services in and around Johannesburg and surrounding provinces since 2022.</p>
                        <div class="footer-contact-item"><span>📍</span><span>06 Broadwalk, Cussonia Central, Grand Central, Midrand, 1685</span></div>
                        <div class="footer-contact-item"><span>📞</span><span>066 129 8293 / 083 551 9941</span></div>
                        <div class="footer-contact-item"><span>✉️</span><span><a href="mailto:info@arize18tours.co.za">info@arize18tours.co.za</a></span></div>
                        <div class="footer-contact-item"><span>🌐</span><span>www.arize18tours.co.za</span></div>
                    </div>
                    <div class="footer-col">
                        <h4>Services</h4>
                        <ul class="footer-links">
                            <li><a href="{{ route('services', ['slug' => 'shuttle']) }}">Shuttle Services</a></li>
                            <li><a href="{{ route('services', ['slug' => 'airport-transfers']) }}">Airport Transfers</a></li>
                            <li><a href="{{ route('services', ['slug' => 'hotel-transfers']) }}">Hotel Transfers</a></li>
                            <li><a href="{{ route('services', ['slug' => 'tours-safaris']) }}">Tours &amp; Safaris</a></li>
                            <li><a href="{{ route('services', ['slug' => 'chauffer']) }}">Chauffer Drive</a></li>
                            <li><a href="{{ route('services', ['slug' => 'car-hire']) }}">reservation_number</a></li>
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
                        <h4>Client Portal</h4>
                        <ul class="footer-links">
                            <li><a href="#">Client Login</a></li>
                            <li><a href="#booking">Guest Booking</a></li>
                            <li><a href="#">View Invoices</a></li>
                            <li><a href="#">Upload Documents</a></li>
                            <li><a href="#">Admin Login</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-inner">
                    <div class="footer-bottom">
                        <p>&copy; {{ date('Y') }} <a href="#">Arize18 (PTY) LTD</a>. All rights reserved.</p>
                    </div>
                </div>
            </footer>

        </div>
    </body>
</html>
