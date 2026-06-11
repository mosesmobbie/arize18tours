<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{  $metaTitle ?: 'Arize18 Travel & Tours'}}</title>
    <meta name="author" content="Arize18">
    <meta name="description" content="{{ $metaDescription ?: 'Shuttle Services, Airport Transfers, Hotel Transfers,
    Tours & Safaris, Chauffer Drive, Self-Drive Hire, Door-to-Door, Social Events' }}">
    <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <nav>
            <a href="#" class="nav-logo">
                <img src="{{ asset('images/logo-white.png') }}" alt="Arize18 Logo" style="height: 50px; width: auto;">
            </a>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#fleet">Fleet</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li id="navAuthItem"><a href="{{ route('client.login') }}" class="nav-cta" id="navAuthLink">WhatsApp</a></li>
            </ul>
        </nav>
    </header>

    {{ $slot }}

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
                    <li><a href="#">Shuttle Services</a></li>
                    <li><a href="#">Airport Transfers</a></li>
                    <li><a href="#">Hotel Transfers</a></li>
                    <li><a href="#">Tours &amp; Safaris</a></li>
                    <li><a href="#">Chauffer Drive</a></li>
                    <li><a href="#">Self-Drive</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul class="footer-links">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Our Fleet</a></li>
                    <li><a href="#">Testimonials</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Client Portal</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('client.login') }}">Client Login</a></li>
                    <li><a href="#booking">Guest Booking</a></li>
                    <li><a href="{{ route('client.login') }}">View Invoices</a></li>
                    <li><a href="{{ route('client.login') }}">Upload Documents</a></li>
                    <li><a href="{{ route('admin.login') }}">Admin Login</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-inner">
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} <a href="#">Arize18 (PTY) LTD</a>. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
