<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Property;
use App\Models\Stay;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'properties' => Property::ordered()->take(3)->get(),
            'project' => Project::ordered()->first(),
            'projects' => Project::ordered()->skip(1)->take(2)->get(),
            'stays' => Stay::ordered()->take(3)->get(),
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact', ['topic' => request('topic')]);
    }

    public function book()
    {
        $for = in_array(request('for'), ['call', 'consult', 'list'], true) ? request('for') : 'call';

        return view('pages.book', ['for' => $for]);
    }
}
