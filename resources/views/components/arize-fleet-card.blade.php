@props([
    'image' => 'images/car.png',
    'name' => 'Minibus',
    'type' => 'Group Transfer',
    'transmission' => 'Manual',
    'seats' => 'Up to 22 seats',
    'short_description' => 'Group Friendly',
])
<div class="fleet-card">
    <div class="fleet-img">
        <img src="storage/{{ $image }}" alt="{{ $name }}">
    </div>
    <div class="fleet-info">
        <div class="fleet-name">{{ $name }}</div>
        <div class="fleet-type">{{ $type }}</div>
        <div class="fleet-specs">
        <div class="fleet-spec">{{ $transmission }}</div>
        <div class="fleet-spec">{{ $seats }} Passengers</div>
        <div class="fleet-spec">AC</div>
        </div>
    </div>
</div>
