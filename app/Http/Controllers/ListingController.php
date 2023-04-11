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

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message','Listing created successfully!');
    }

    // Show Edit Form
    public function edit(Listing $listing) {
        // dd($listing);
        // dd($listing->title);
        return view('listings.edit',['listing' => $listing]);
    }

    //Store New Listing
    public function update(Request $request, Listing $listing) {
        // dd($request->all());
        // dd($request->file('logo')->store());
        //Make sure logged in user is ownwer
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
 
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $listing->update($formFields);

        return redirect('/listings/'.$listing->id)->with('message','Listing updated successfully!');
    }

    // Delete Listing
    public function destroy(Listing $listing) {
        //Make sure logged in user is ownwer
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    // Manage Lisitngs
    public function manage() {
        return view('listings.manage',['listings' => auth()->user()->listings()->get()]);
    }
}
