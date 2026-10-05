<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Rate;
use App\Models\Service;
use App\Models\TeamMember;

class PageController extends Controller
{
    public function home()
    {
        return view('site.home', [
            'services' => Service::active()->get(),
            'clients' => Client::active()->get(),
        ]);
    }

    public function about()
    {
        return view('site.about', [
            'team' => TeamMember::active()->get(),
            'clients' => Client::active()->get(),
        ]);
    }

    public function rates()
    {
        return view('site.rates', [
            'groups' => Rate::active()->get()->groupBy('category'),
        ]);
    }

    public function contact()
    {
        return view('site.contact');
    }
}
