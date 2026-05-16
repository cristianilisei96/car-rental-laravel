<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountDetailsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $profile = $user->customerProfile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        return view('customer.account-details.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->merge([
            'phone' => preg_replace('/[\s\-]/', '', $request->input('phone')),
        ]);

        $validated = $request->validate([
            'phone' => [
                'required',
                'string',
                'regex:/^(?:\+40|0040|0)7\d{8}$/',
            ],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'driver_license_number' => ['required', 'string', 'max:100'],
        ], [
            'phone.regex' => 'Please enter a valid Romanian mobile phone number, for example 0752420138 or +40752420138.',
        ]);

        $user->customerProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return back()->with('success', 'Account details updated successfully.');
    }
}
