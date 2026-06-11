@props([
    'image' => 'images/car.png',
    'title' => 'Shuttle Services',
    'slug' => 'shuttle',
    'short_description' => 'Short and long-distance trips within Gauteng and surrounding provinces.',
])

<a href="{{ route('services', ['slug' => $slug]) }}" class="service-card">
    <span class="service-arrow">↗</span>
    <img src="/storage/{{ $image }}" alt="{{ $title }}" class="service-icon-img">
    <div class="service-name">{{ $title }}</div>
    <div class="service-desc">{{ $short_description }}</div>
</a>
