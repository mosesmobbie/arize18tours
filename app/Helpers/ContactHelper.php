<?php

namespace App\Helpers;

use App\Models\ContactDetails;
use Illuminate\Support\Facades\Cache;

class ContactHelper
{
    public static function getActive(): \stdClass
    {
        $details = Cache::remember('contact_details.active', now()->addMinutes(30), function () {
            return ContactDetails::query()->where('active', true)->get();
        });

        $contact = new \stdClass();

        foreach ($details as $detail) {
            $contact->{$detail->key} = $detail->value;
        }

        return $contact;
    }
}
