<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{

    //show all listings
    public function index(){           //can also get request by index(Request $request) 
        //dd(request('tag'));
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag','search','user_id']))->paginate(6),   //calling static method from Listing model
        ]                                                      
    );
    }
    //show single listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing,   //calling static method from Listing model
        ]
    );
    }

    //show create form
    public function create(){
        return view('listings.create');
    }

    // store listing data (with validation)
    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required',Rule::unique('listings','company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);
        //dd($formFields);
        
        return redirect('/')->with('message','Listing created successfully');
    }

    //show edit form
    public function edit(Listing $listing){
        //dd($listing);
        return view('listings.edit',['listing'=>$listing]);
    }

    // update listing data (with validation)
    public function update(Request $request, Listing $listing){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $listing->update($formFields);
        //dd($formFields);
        
        return back()->with('message','Listing changed successfully');
    }

    //delete a listing
    public function destroy(Listing $listing){
        $listing->delete();
        return redirect('/')->with('message','Listing deleted successfully');
    }

    //manage listings
    public function manage(){
        //dd(get_class(auth()->user()));
        return view('listings.manage',[
            'listing' => Listing::latest(), //calling static method from Listing model
        ]
    );
    }
}
