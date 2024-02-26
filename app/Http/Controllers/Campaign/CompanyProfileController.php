<?php

namespace App\Http\Controllers\Campaign;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyProfileController extends Controller
{
    public function index(Request $request)
    {
        if (!is_null($request->user()->companyProfile) && $request->user()->companyProfile->logo_img) {
            $logo_img = asset('storage/'.$request->user()->companyProfile->logo_img);;
        } else {
            $logo_img = asset('images/profile.png');
        }
        return view('campaign.company_profile', compact('logo_img'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'company_name' => ['required', 'string'],
            'company_email' => ['required', 'email'],
            'contact_person' => ['nullable', 'string'],
            'street_address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'zip_code' => ['required', 'numeric'],
            'profile_id' => ['nullable', 'integer'],
            'company_logo' => ['nullable', 'image']
        ], [
            'city.required' => 'City is required',
            'state.required' => 'State is required',
            'zip_code.required' => 'ZIP is required',
        ]);

        $filePath = null;

        if (!is_null($request->user()->companyProfile) && $request->user()->companyProfile->logo_img) {
            $filePath = $request->user()->companyProfile->logo_img;
        }

        if ($request->has('company_logo')) {
            if (!is_null($request->user()->companyProfile) && $request->user()->companyProfile->logo_img) {
                unlink(storage_path('app/public/'.$request->user()->companyProfile->logo_img));
            }
            $filePath = $request->file('company_logo')->store('uploads/company_logo', 'public');
        }

        $request->user()->update([
            'political_group' => $request->input('political_group'),
        ]);

        $request->user()->companyProfile()->updateOrCreate([
            'id' => $request->input('profile_id')
        ], [
            'company_name' => $request->input('company_name'),
            'company_email' => $request->input('company_email'),
            'contact_person' => $request->input('contact_person'),
            'street_address' => $request->input('street_address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip_code' => $request->input('zip_code'),
            'logo_img' => $filePath
        ]);

        return redirect()->route('campaign.view.profile')->with('success', 'Company profile saved successfully');
    }
}
