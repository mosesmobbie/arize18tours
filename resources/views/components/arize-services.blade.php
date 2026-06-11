<section class="services-bg" id="services">
  <div class="section-inner">
    <div class="services-header">
      <div>
        <div class="section-label">What We Offer</div>
        <h2 class="section-title">Our <span>Services</span></h2>
      </div>
      <p class="section-desc" style="color:rgba(255,255,255,0.5);">From airport pickups to cross-provincial tours, we provide safe and comfortable transport across South Africa.</p>
    </div>
    <div class="services-grid">
        @foreach ($services as $service)
            <x-arize-service-card :image="$service->image" :title="$service->title" :slug="$service->slug" :short_description="$service->short_description"/>
        @endforeach
       </div>
    </div>
  </div>
</section>
