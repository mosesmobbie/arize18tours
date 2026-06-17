<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;

class FleetController extends Controller
{
    public function index(Request $request)
    {
        try {
            $fleets = Cache::remember('fleet', now()->addDays(30), function () {
                return Fleet::query()
                    ->where('active', true)
                    ->orderBy('name')
                    ->orderBy('model')
                    ->get();
            });
        } catch (Throwable $throwable) {
            $fleets = collect(Cache::get('fleet', []));
        }

        $types = $fleets
            ->pluck('short_description')
            ->reject(fn ($type) => blank($type))
            ->unique()
            ->sort()
            ->values();

        $vehicleOptions = $fleets
            ->sortBy(fn ($vehicle) => [$vehicle->name, $vehicle->model])
            ->values();

        $carOptions = $fleets
            ->pluck('name')
            ->reject(fn ($name) => blank($name))
            ->unique()
            ->sort()
            ->values();

        $modelOptions = $fleets
            ->pluck('model')
            ->reject(fn ($model) => blank($model))
            ->unique()
            ->sort()
            ->values();

        $carModelOptions = $fleets
            ->filter(fn ($vehicle) => ! blank($vehicle->name) && ! blank($vehicle->model))
            ->groupBy('name')
            ->map(fn ($group) => $group
                ->pluck('model')
                ->unique()
                ->sort()
                ->values()
                ->all())
            ->toArray();

        $selectedType = $request->string('type')->toString();
        $selectedCar = $request->string('car')->toString();
        $selectedModel = $request->string('model')->toString();

        $filteredFleets = $fleets
            ->when($selectedType !== '', fn ($collection) => $collection->where('short_description', $selectedType))
            ->when($selectedCar !== '', fn ($collection) => $collection->where('name', $selectedCar))
            ->when($selectedModel !== '', fn ($collection) => $collection->where('model', $selectedModel))
            ->values();

        return view('fleet', [
            'fleets' => $filteredFleets,
            'types' => $types,
            'vehicleOptions' => $vehicleOptions,
            'carOptions' => $carOptions,
            'modelOptions' => $modelOptions,
            'carModelOptions' => $carModelOptions,
        ]);
    }
}
