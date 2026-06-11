<x-app-layout>
    <style>
        body,
        .min-h-screen,
        main {
            background-color: #ffffff !important;
        }

        .section-title {
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            line-height: 1.2;
        }

        .booking-page-shell {
            background: #ffffff;
            padding: 24px 0 40px;
        }

        .booking-page-top,
        .booking-page-bottom {
            max-width: 980px;
            margin: 0 auto;
            min-height: 24px;
        }

        #booking.booking-card {
            margin-left: 0 !important;
        }

        input,
        select {
            width: 160% !important;
            color: #1f2937!important;
        }
    </style>

    <section id="about" class="about-page-section bg-white" style="background-color: #fff;">
        <div class="section-inner">
            <h3 class="section-title">Booking: <span>Quotation</span></h3>

            <div class="mt-6 flex flex-col gap-6 lg:flex-row lg:items-start">
                <div class="w-full lg:w-3/4">
                    <p class="mb-4 text-gray-700">We pride ourselves on professionalism, safety, and creating memorable
                        experiences. Whether local or cross-border, our team ensures compliance with South African
                        transport regulations, including valid operating permits. Contact us today for quotes, custom
                        packages, or bookings. Let us serve you with pride!
                    </p>
                    <div class="booking-page-top"></div>
                    <x-booking-form :services="$services" :selected-service="$selectedService ?? 'shuttle'" />
                    <div class="booking-page-bottom"></div>
                </div>

                <div class="hidden lg:block lg:w-1/4 lg:max-w-none space-y-6">
                    <aside>
                        <div
                            class="services-sidebar-card rounded-2xl border border-gray-200 bg-white p-4 shadow-sm lg:sticky ">
                            <div class="section-label">Service Types</div>
                            <ul class="mt-2 space-y-1 text-sm font-bold">
                                @foreach ($services as $service)
                                    <li>
                                        <div
                                            class="group flex items-center gap-2 rounded-lg border border-transparent bg-white/70 px-3 py-2 text-gray-800 transition">
                                            <span class="inline-block h-2 w-2 rounded-full bg-gray-400"></span>
                                            <span>{{ $service->title }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>

                    <aside>
                        <div
                            class="services-sidebar-card rounded-2xl border border-gray-200 bg-white p-4 shadow-sm lg:sticky ">
                            <div class="section-label">Vehicle Types</div>
                            <ul class="mt-2 space-y-1 text-sm font-bold">

                                <li>
                                    <div
                                        class="group flex items-center gap-2  px-3 py-2 transitionborder-transparent bg-white/70 text-gray-800 }}">
                                        <span class="inline-block h-2 w-2 rounded-full bg-gray-400 }}"></span>
                                        <span>Standard Sedan</span>
                                    </div>
                                </li>
                                <li>
                                    <div
                                        class="group flex items-center gap-2  px-3 py-2 transitionborder-transparent bg-white/70 text-gray-800 }}">
                                        <span class="inline-block h-2 w-2 rounded-full bg-gray-400 }}"></span>
                                        <span>Executive Sedan</span>
                                    </div>
                                </li>
                                <li>
                                    <div
                                        class="group flex items-center gap-2  px-3 py-2 transitionborder-transparent bg-white/70 text-gray-800 }}">
                                        <span class="inline-block h-2 w-2 rounded-full bg-gray-400 }}"></span>
                                        <span>SUV</span>
                                    </div>
                                </li>
                                <li>
                                    <div
                                        class="group flex items-center gap-2  px-3 py-2 transitionborder-transparent bg-white/70 text-gray-800 }}">
                                        <span class="inline-block h-2 w-2 rounded-full bg-gray-400 }}"></span>
                                        <span>Mini Van</span>
                                    </div>
                                </li>
                                <li>
                                    <div
                                        class="group flex items-center gap-2  px-3 py-2 transitionborder-transparent bg-white/70 text-gray-800 }}">
                                        <span class="inline-block h-2 w-2 rounded-full bg-gray-400 }}"></span>
                                        <span>MiniBus / Shuttle</span>
                                    </div>
                                </li>

                                <li>
                                    <div
                                        class="group flex items-center gap-2  px-3 py-2 transitionborder-transparent bg-white/70 text-gray-800 }}">
                                        <span class="inline-block h-2 w-2 rounded-full bg-gray-400 }}"></span>
                                        <span>Coach / Bus</span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </aside>
                </div>

            </div>



        </div>
    </section>

    <x-arize-fleet :fleet="$fleet" />
</x-app-layout>
