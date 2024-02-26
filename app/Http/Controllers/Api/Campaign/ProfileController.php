<?php

namespace App\Http\Controllers\Api\Campaign;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\Campaign\CampaignProfileResource;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $profile = $request->user()->load(['companyProfile']);

        return new CampaignProfileResource($profile);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'company_name' => ['required', 'string'],
            'company_email' => ['required', 'email'],
            'contact_person' => ['required', 'string'],
            'street_address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'zip_code' => ['required', 'numeric'],
            'profile_id' => ['nullable', 'integer'],
            'company_logo' => ['nullable', 'image'],
            'political_group' => ['required', 'string', Rule::in(['democrat', 'republican', 'nonpartisan'])],
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

        $profile = $request->user()->load(['companyProfile']);

        return new CampaignProfileResource($profile);
    }
}
