<x-app-layout meta-title="About Us - Arize18 Travel and Tours" meta-description="Learn about Arize18 Tours, a black-owned shuttle service in Gauteng. Discover our mission, values, and commitment to safe, reliable transportation." meta-keywords="Arize18 Tours, About Us, Shuttle Service, Gauteng, Black-Owned Business, Transportation Services">
    <style>
        #about .section-title {
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            line-height: 1.2;
        }
        .about-page-section {
            background: #ffffff;
        }

        #about .section-desc {
            color: var(--grey);
        }

        .about-page-features {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.25rem;
            margin-top: 2rem;
        }

        .about-page-feature-card {
            background: #ffffff;
            border: 1px solid #e6e8ee;
            border-radius: 14px;
            padding: 1.25rem;
            box-shadow: 0 10px 24px rgba(8, 20, 42, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .about-page-feature-card::after {
            content: "";
            position: absolute;
            left: 0.25rem;
            right: 0.25rem;
            bottom: 0;
            height: 4px;
            background: #d62828;
            border-radius: 4px 4px 0 0;
        }

        .about-page-feature-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 28px rgba(8, 20, 42, 0.12);
        }

        .about-page-feature-icon {
            font-size: 1.8rem;
            line-height: 1;
            flex-shrink: 0;
        }

        .about-page-feature-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0e1f40;
        }

        .about-page-feature-head {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            margin-bottom: 0.65rem;
        }

        .about-page-feature-desc {
            font-size: 0.95rem;
            line-height: 1.55;
            color: #4b5568;
        }

        @media (max-width: 991px) {
            .about-page-features {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .about-page-features {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section id="about" class="about-page-section">
        <div class="section-inner">
            <h2 class="section-title">About <span>Us</span></h2>
            <article class="w-full flex flex-col shadow my-4">
                <img class="w-full" src="/storage/{{ $about->image }}">
            </article>

            <p class="section-desc" style="margin-bottom:36px;">{!! $about->content !!}</p>

            <div class="section-label">Our Values</div>
            <div class="about-page-features">
                <div class="about-page-feature-card">
                    <div class="about-page-feature-head">
                        <div class="about-page-feature-icon">🎯</div>
                        <div class="about-page-feature-title">Integrity &amp; Reliability</div>
                    </div>
                    <div class="about-page-feature-desc">We respect our clients and are committed to being dependable at all times. Your trust is our most valuable asset.</div>
                </div>

                <div class="about-page-feature-card">
                    <div class="about-page-feature-head">
                        <div class="about-page-feature-icon">❤️</div>
                        <div class="about-page-feature-title">Client-First Service</div>
                    </div>
                    <div class="about-page-feature-desc">Ready to serve with kindness at all times. Experienced, passionate drivers who take pride in every journey.</div>
                </div>

                <div class="about-page-feature-card">
                    <div class="about-page-feature-head">
                        <div class="about-page-feature-icon">🛡️</div>
                        <div class="about-page-feature-title">Safety Above All</div>
                    </div>
                    <div class="about-page-feature-desc">Safety is our main priority. All vehicles are maintained to the highest standard for your peace of mind.</div>
                </div>
            </div>
        </div>
    </section>
    <x-arize-services :services="$services" />
    <div class="cta-banner">
  <div class="cta-inner">
    <div>
      <div class="cta-title">Travel in<br>Style</div>

    </div>
    <a href="#booking" class="btn-white">Book Now &rarr;</a>
  </div>
</div>

</x-app-layout>
