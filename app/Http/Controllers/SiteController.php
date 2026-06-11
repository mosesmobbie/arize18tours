<?php

namespace App\Http\Controllers;

use App\Models\ContactDetails;
use App\Models\Service;
use App\Models\TextWidget;
use App\Models\Fleet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use stdClass;

class SiteController extends Controller
{
    //
    public function index()
    {
        $contactDetails = Cache::remember('contact_details.active', now()->addMinutes(30), function () {
            return ContactDetails::query()->where('active', true)->get();
        });
        $contact = new stdClass();

        foreach ($contactDetails as $contactDetail) {
            $contact->{$contactDetail->key} = $contactDetail->value;
        }

        $services = $this->getAllServices();

        $fleet = $this->getAllFleet();

        return view('welcome', ['contact' => $contact, 'services' => $services, 'fleet' => $fleet]);
    }

    public function about()
    {
        $about = Cache::remember('about', now()->addMinutes(30), function () {
            return TextWidget::query()->where('key', 'about-page')->where('active', true)->first();
        });


        if(!$about){
            throw new ModelNotFoundException();
        }

        $services = $this->getAllServices();

        return view('about', ['about' => $about, 'services' => $services]);
    }

    public function services( $slug)
    {

        $byService = $this->byService($slug);

        if(!$byService){
            throw new ModelNotFoundException();
        }

        $service_options =  Service::query('slug, title')->where('status', true)->get();


        if(!$service_options){
            throw new ModelNotFoundException();
        }

        $options = array();

        foreach ($service_options as $service) {
            $options[$service->slug] = $service->title;
        }

        return view('services', ['service' => $byService, 'options' => $options]);
    }

    public function byService($slug)
    {
        return Service::query()->where('slug', $slug)->where('status', true)->first();
    }

    public function  getAllServices()
    {
        return Service::query()->where('status', true)->get();
    }

    public function fleet()
    {
        $fleet = Cache::remember('fleet', now()->addDays(30), function () {
            return $this->getAllFleet();
        });

        if(!$fleet){
            throw new ModelNotFoundException();
        }

        return view('fleet', ['fleet' => $fleet]);
    }

    public function getAllFleet()
    {
        return Fleet::query()->where('active', true)->get();
    }

}
