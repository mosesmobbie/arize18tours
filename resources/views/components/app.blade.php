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
                        <li><a href="{{ route('fleet') }}" class="{{ request()->routeIs('fleet') ? 'is-active' : '' }}" @if(request()->routeIs('fleet')) aria-current="page" @endif>Fleet</a></li>
                        <li><a href="{{ route('booking') }}" class="{{ request()->routeIs('booking') ? 'is-active' : '' }}" @if(request()->routeIs('booking')) aria-current="page" @endif>Booking</a></li>
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


        </div>
    </body>
</html>
