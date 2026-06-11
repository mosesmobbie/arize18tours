<x-app-layout>
<section class="hero" id="home">
  <div class="hero-diagonal"></div>
  <div class="hero-red-accent"></div>
  <div class="hero-content">
    <div class="hero-left">
      <div class="hero-tag">Gauteng's Premier Shuttle Service</div>
      <h1 class="hero-title">
        Travel<br>in <span class="accent">Style,</span><br>Arrive<br>in Safety.
      </h1>
      <p class="hero-subtitle">
        Professional shuttle services, airport transfers, hotel transfers, and tours across Johannesburg and surrounding provinces.
      </p>
      <div class="hero-actions">
        <a href="#booking" class="btn-primary">Get a Quote</a>
        <a href="#services" class="btn-outline">Our Services</a>
        <a href="#" class="btn-primary" id="heroDashboardButton" style="display:none;">Client Dashboard</a>
      </div>
      <div class="hero-stats">
        <div class="stat-item">
          <div class="stat-num">{{ date('Y') - 2022 }}<span>+</span></div>
          <div class="stat-label">Years Operating</div>
        </div>
        <div class="stat-item">
          <div class="stat-num">100<span>%</span></div>
          <div class="stat-label">Black Owned</div>
        </div>
        <div class="stat-item">
          <div class="stat-num">24<span>/7</span></div>
          <div class="stat-label">Available</div>
        </div>
      </div>
    </div>

    <x-booking-form :services="$services" :wide="true"/>
  </div>
</section>
<div class="trust-bar">
  <div class="trust-inner">
    <div class="trust-item">
      <div class="trust-icon">✓</div>
      Registered &amp; Insured
    </div>
    <div class="trust-item">
      <div class="trust-icon">🛡</div>
      Verified Professional Drivers
    </div>
    <div class="trust-item">
      <div class="trust-icon">⭐</div>
      Safety is Our Priority
    </div>
    <div class="trust-item">
      <div class="trust-icon">📝</div>
      Online Booking
    </div>
  </div>
</div>
<x-arize-services :services="$services" />
<section id="about">
  <div class="section-inner">
    <div class="why-grid">
      <div class="why-image-stack">
        <div class="why-img-main">
          <img src="{{ asset('images/car_about.png') }}" alt="Professional Shuttle Vehicle">
        </div>
        <div class="why-img-accent">
          <div>
            <div class="accent-text"> - Integrity<br> - Kindness<br> - Focus</div>
          </div>
        </div>
      </div>
      <div>
        <div class="section-label">Why Choose Us</div>
        <h2 class="section-title">Arize18 <span>Difference</span></h2>
        <p class="section-desc" style="margin-bottom:36px;">We are committed to providing the best service in town and being dependable at all times — safety, comfort and affordability combined.</p>
        <div class="why-features">
          <div class="why-feature">
            <div class="why-feat-icon">🎯</div>
            <div>
              <div class="why-feat-title">Integrity &amp; Reliability</div>
              <div class="why-feat-desc">We respect our clients and are committed to being dependable at all times. Your trust is our most valuable asset.</div>
            </div>
          </div>
          <div class="why-feature">
            <div class="why-feat-icon">❤️</div>
            <div>
              <div class="why-feat-title">Client-First Service</div>
              <div class="why-feat-desc">Ready to serve with kindness at all times. Experienced, passionate drivers who take pride in every journey.</div>
            </div>
          </div>
          <div class="why-feature">
            <div class="why-feat-icon">🛡️</div>
            <div>
              <div class="why-feat-title">Safety Above All</div>
              <div class="why-feat-desc">Safety is our main priority. All vehicles are maintained to the highest standard for your peace of mind.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<x-arize-fleet :fleet="$fleet" />
<div class="cta-banner">
  <div class="cta-inner">
    <div>
      <div class="cta-title">Ready to Book<br>Your Ride?</div>
      @php
        $whatsappNumber = preg_replace('/\D+/', '', $contact->whatsapp ?? '');
        $whatsappDisplay = preg_replace('/^27/', '0', $whatsappNumber);
        $whatsappDisplay = preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '$1-$2-$3', $whatsappDisplay);
        $phoneNumber = preg_replace('/\D+/', '', $contact->phone ?? '');
        $phoneDisplay = preg_replace('/^27/', '0', $phoneNumber);
        $phoneDisplay = preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '$1-$2-$3', $phoneDisplay);
      @endphp
      <div class="cta-sub"><a href="https://wa.me/{{ $whatsappNumber }}" title="WhatsApp" target="_blank" rel="noopener noreferrer"><span class="cta-icon cta-icon--whatsapp" aria-hidden="true"></span><span>{{ $whatsappDisplay }}</span></a> <a href="tel:+{{ $phoneNumber }}" title="Call" class="cta-contact-phone"><span class="cta-icon cta-icon--phone" aria-hidden="true"></span><span>{{ $phoneDisplay }}</span></a>  <a href="mailto:{{$contact->email}}" title="Email"><span class="cta-icon cta-icon--email" aria-hidden="true"></span><span>{{$contact->email}}</span></a></div>
    </div>
    <a href="#booking" class="btn-white">Get Your Quote &rarr;</a>
  </div>
</div>
</x-app-layout>
