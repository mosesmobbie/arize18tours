<x-app-layout
    :meta-title="$service->title . ' - Arize18'"
    :meta-description="\Illuminate\Support\Str::limit(strip_tags($service->description), 160)"
    :meta-keywords="$service->meta_keywords ?: ($service->title . ', Arize18 Tours, Shuttle Service, Gauteng')"
>
    <style>
        #about .section-title {
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            line-height: 1.2;
        }

        #about .section-desc {
            max-width: 800px;
        }

        .services-sidebar-card {
            position: relative;
            overflow: hidden;
        }

        .services-sidebar-card::after {
            content: "";
            position: absolute;
            left: 0.25rem;
            right: 0.25rem;
            bottom: 0;
            height: 4px;
            background: #d62828;
            border-radius: 4px 4px 0 0;
        }

        .service-rich-text ul {
            margin: 1rem 0;
            padding-left: 0;
            list-style: none;
        }

        .service-rich-text ul li {
            position: relative;
            margin-bottom: 0.5rem;
            padding-left: 1rem;
        }

        .service-rich-text ul li::before {
            content: "";
            position: absolute;
            top: 0.55em;
            left: 0;
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 9999px;
            background-color: var(--red);
        }
    </style>
    <section id="about" class="about-page-section bg-white" style="background-color: #fff;">
        <div class="section-inner">
            <h3 class="section-title">Services: <span>{{ $service->title }}</span></h3>

            <div class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1fr)_240px] lg:items-start xl:grid-cols-[minmax(0,3fr)_260px]">
                <div class="order-1 w-full lg:col-start-1">
                    <article class="my-4 w-full max-w-3xl flex flex-col shadow">
                        <img class="w-full h-auto object-cover" src="/storage/{{ $service->image }}">
                    </article>

                    <div class="section-desc service-rich-text">{!! $service->description !!}
                        <p class="font-bold italic">All services subject to availability. Terms and conditions apply. Requirements may vary; our team will confirm specifics upon booking.</p>
                    </div>

                    <p class="mt-3"><a href="{{ route('booking', ['service' => $service->slug]) }}" class="btn-primary">Book {{ $service->title }}</a></p>
                </div>

                <aside class="order-2 max-w-2xl lg:col-start-2 lg:w-[240px] lg:max-w-[240px] lg:shrink-0 lg:justify-self-end lg:sticky lg:top-6 xl:w-[260px] xl:max-w-[260px]">
                    @php($activeSlug = request()->route('slug'))
                    <div class="services-sidebar-card rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                        <div class="section-label">Our Services</div>
                        <ul class="mt-2 space-y-1 text-sm font-bold">
                            @foreach($options as $slug => $title)
                                @php($isActive = $activeSlug === $slug)
                                <li>
                                    <a
                                        href="{{ route('services', ['slug' => $slug]) }}"
                                        class="group flex items-center gap-2 rounded-lg border px-3 py-2 transition {{ $isActive ? 'border-[var(--red)] bg-[var(--red)] text-white shadow-sm' : 'border-transparent bg-white/70 text-gray-800 hover:border-gray-300 hover:bg-gray-100' }}"
                                        aria-current="{{ $isActive ? 'page' : 'false' }}"
                                    >
                                        <span class="inline-block h-2 w-2 rounded-full {{ $isActive ? 'bg-white' : 'bg-gray-400 group-hover:bg-gray-700' }}"></span>
                                        <span>{{ $title }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>

            </div>
        </div>
    </section>

    <div class="cta-banner">
        <div class="cta-inner">
            <div>
                <div class="cta-title">Travel in<br>Style</div>
            </div>
            <a href="{{ route('booking', ['service' => $service->slug]) }}" class="btn-white">Book Now &rarr;</a>
        </div>
    </div>


</x-app-layout>
