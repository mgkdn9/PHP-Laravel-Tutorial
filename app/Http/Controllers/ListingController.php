<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Show All Listings
    public function index() {
        // dd(Listing::latest()->filter(request(['tag','search']))->paginate(4));
        return view('listings.index', [
            // 'listings' => Listing::latest()->filter(request(['tag','search']))->simplePaginate(4)
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(4)
        ]);
    }

    //Show Single Listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //Show Create Form
    public function create() {
        return view('listings.create');
    }

    //Store New Listing
    public function store(Request $request) {
        // dd($request->all());
        // dd($request->file('logo')->store());
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        Listing::create($formFields);

        return redirect('/')->with('message','Listing created successfully!');
    }
}
