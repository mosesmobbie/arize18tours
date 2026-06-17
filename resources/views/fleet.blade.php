<x-app-layout>
    @php
        $vehicles = $fleets ?? $fleet ?? collect();
    @endphp

    <style>
        input, select {
            width: 100% !important;
        }
        .fleet-page {
            background:
                radial-gradient(circle at top left, rgba(200, 32, 47, 0.10), transparent 34%),
                linear-gradient(180deg, #f7f7fb 0%, #ebebf3 100%);
            padding: 120px 0 80px;
        }

        .fleet-page .section-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .fleet-page .fleet-header {
            margin-bottom: 30px;
        }

        .fleet-page__layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            align-items: start;
        }

        .fleet-page__empty {
            background: white;
            border: 1px dashed rgba(27, 43, 75, 0.2);
            border-radius: 18px;
            padding: 28px;
            color: var(--grey);
            text-align: center;
        }

        .fleet-page .fleet-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
            overflow: visible;
            scroll-snap-type: none;
            padding: 0;
        }

        .fleet-page .fleet-card {
            flex: initial;
            scroll-snap-align: unset;
            border-radius: 14px;
            background: #ffffff;
            border: 1px solid rgba(27, 43, 75, 0.08);
            overflow: hidden;
            min-height: 100%;
            box-shadow: 0 10px 28px rgba(27, 43, 75, 0.08);
        }

        .fleet-page .fleet-img {
            background: #ffffff;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            overflow: hidden;
        }

        .fleet-page .fleet-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .fleet-page .fleet-info {
            padding: 22px 22px 24px;
        }

        .fleet-page .fleet-name {
            font-size: 24px;
        }

        .fleet-page .fleet-type {
            margin-bottom: 16px;
        }

        .fleet-page__sidebar {
            position: static;
            background: rgba(255, 255, 255, 0.94);
            border-left: 0;
            border-right: 0;
            border-top: 1px solid rgba(27, 43, 75, 0.14);
            border-bottom: 1px solid rgba(27, 43, 75, 0.14);
            border-radius: 20px;
            box-shadow: 0 16px 36px rgba(27, 43, 75, 0.10);
            padding: 22px;
        }

        .fleet-page__sidebar form {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            align-items: end;
        }

        .fleet-page__filter {
            display: grid;
            gap: 8px;
            margin-bottom: 0;
        }

        .fleet-page__filter:last-of-type {
            margin-bottom: 0;
        }

        .fleet-page__filter select {
            width: 80% !important;
            justify-self: center;
            height: 48px;
            border-radius: 12px;
            border: 1px solid rgba(27, 43, 75, 0.16);
            background: #fff;
            color: var(--navy);
            padding: 0 14px;
            font: inherit;
            outline: none;
        }

        .fleet-page__filter select:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(200, 32, 47, 0.12);
        }

        .fleet-page__filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 0;
            width: 80%;
            justify-self: center;
        }

        .fleet-page__filter-button,
        .fleet-page__filter-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            height: 46px;
            padding: 0 16px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
        }

        .fleet-page__filter-button {
            border: 0;
            background: var(--red);
            color: white;
            cursor: pointer;
        }

        .fleet-page__filter-link {
            border: 1px solid rgba(27, 43, 75, 0.12);
            color: var(--navy);
            background: white;
        }

        @media (max-width: 1024px) {
            .fleet-page .fleet-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .fleet-page__sidebar form {
                grid-template-columns: 1fr 1fr;
            }

            .fleet-page__filter-actions {
                grid-column: 1 / -1;
                width: 100%;
                justify-self: stretch;
            }

            .fleet-page__filter select {
                width: 100% !important;
                justify-self: stretch;
            }
        }

        @media (max-width: 640px) {
            .fleet-page {
                padding: 100px 0 64px;
            }

            .fleet-page .section-inner {
                padding: 0 20px;
            }

            .fleet-page__sidebar {
                margin-top: 10px;
            }

            .fleet-page .fleet-grid {
                grid-template-columns: 1fr;
            }

            .fleet-page__sidebar form {
                grid-template-columns: 1fr;
            }

            .fleet-page__filter-button,
            .fleet-page__filter-link {
                width: 100%;
                height: 46px;
            }

            .section-desc{
                margin-top:-30px !important;
            }
        }
    </style>

    <section class="fleet-page fleet-bg" id="fleet">
        <div class="section-inner">
            <div class="fleet-header">
                <div>
                    <h1 class="section-title">Our <span>Fleet</span></h1>
                </div>
            </div>

            <div class="fleet-page__layout">
                <aside class="fleet-page__sidebar" aria-label="Fleet filters">
                    <form method="GET" action="{{ route('fleet') }}">
                        <div class="fleet-page__filter">
                            <select id="type" name="type">
                                <option value="">All Vehicles</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="fleet-page__filter">
                            <select id="car" name="car">
                                <option value="">All cars</option>
                                @foreach (($carOptions ?? collect()) as $carOption)
                                    <option value="{{ $carOption }}" @selected(request('car') === $carOption)>{{ $carOption }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="fleet-page__filter">
                            <select id="model" name="model">
                                <option value="">All models</option>
                                @foreach (($modelOptions ?? collect()) as $modelOption)
                                    <option value="{{ $modelOption }}" @selected(request('model') === $modelOption)>{{ $modelOption }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="fleet-page__filter-actions">
                            <button type="submit" class="fleet-page__filter-button">Apply</button>
                            <a href="{{ route('fleet') }}" class="fleet-page__filter-link">Reset</a>
                        </div>
                    </form>
                </aside>

                <div>
                    @if ($vehicles->isEmpty())
                        <div class="fleet-page__empty">No vehicles are available at the moment.</div>
                    @else
                        <div class="fleet-grid">
                            @foreach ($vehicles as $vehicle)
                                <article class="fleet-card">
                                    <div class="fleet-img">
                                        <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }} {{ $vehicle->model }}">
                                    </div>
                                    <div class="fleet-info">
                                        <div class="fleet-name">{{ $vehicle->name }} {{ $vehicle->model }}</div>
                                        <div class="fleet-type">{{ $vehicle->short_description }}</div>
                                        <div class="fleet-specs">
                                            <div class="fleet-spec">{{ $vehicle->transmission }}</div>
                                            <div class="fleet-spec">{{ $vehicle->passengers }} Passengers</div>
                                            <div class="fleet-spec">AC</div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>


    </section>
        <div class="cta-banner">
  <div class="cta-inner">
    <div>
      <div class="cta-title">Travel in<br>Style</div>

    </div>
    <a href="{{ route('booking') }}" class="btn-white">Book Now &rarr;</a>
  </div>
</div>

<script>
    (function () {
        const carSelect = document.getElementById('car');
        const modelSelect = document.getElementById('model');

        if (!carSelect || !modelSelect) {
            return;
        }

        const carModelOptions = @json($carModelOptions ?? []);
        const allModels = @json(($modelOptions ?? collect())->values()->all());
        const selectedModel = @json(request('model'));

        const fillModels = (carValue, preserveSelected = false) => {
            const models = carValue && carModelOptions[carValue] ? carModelOptions[carValue] : allModels;
            const preferredModel = preserveSelected ? selectedModel : '';
            const keepModel = models.includes(preferredModel) ? preferredModel : '';

            modelSelect.innerHTML = '';

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'All models';
            modelSelect.appendChild(defaultOption);

            models.forEach((model) => {
                const option = document.createElement('option');
                option.value = model;
                option.textContent = model;
                if (keepModel !== '' && model === keepModel) {
                    option.selected = true;
                }
                modelSelect.appendChild(option);
            });

            modelSelect.value = keepModel;
        };

        fillModels(carSelect.value, true);

        carSelect.addEventListener('change', function () {
            fillModels(this.value, false);
        });
    })();
</script>
</x-app-layout>
