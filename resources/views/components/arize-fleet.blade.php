<section class="fleet-bg" id="fleet">
  <div class="section-inner">
    <div class="fleet-header">
      <div>
        <div class="section-label">Our Vehicles</div>
        <h2 class="section-title">The <span>Fleet</span></h2>
      </div>

        <p class="section-desc">From airport pickups to cross-provincial tours, we provide safe and comfortable transport across South Africa.</p>
    </div>
    <div class="fleet-grid" id="fleetGrid">
      @foreach ($fleet as $vehicle)
        <x-arize-fleet-card :image="$vehicle->image" :name="$vehicle->name . ' ' . $vehicle->model"
            :type="$vehicle->short_description" :transmission="$vehicle->transmission"
            :seats="$vehicle->passengers" />
      @endforeach
    </div>
    <div class="fleet-controls-bottom">
      <div class="fleet-controls">
        <button type="button" class="fleet-nav" id="fleetPrev" aria-label="Previous fleet cards">&#8249;</button>
        <button type="button" class="fleet-nav" id="fleetNext" aria-label="Next fleet cards">&#8250;</button>
      </div>
    </div>
  </div>
</section>
