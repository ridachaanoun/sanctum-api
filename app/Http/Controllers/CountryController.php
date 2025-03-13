<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function index()
    {
        $countries = Country::all();
        return response()->json($countries);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'capital' => 'required|string|max:255',
            'population' => 'required|integer',
            'region' => 'required|string|max:255',
            'flag_url' => 'nullable|url',
            'currency' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
        ]);

        $country = Country::create($validatedData);

        return response()->json($country, 201);
    }


    public function show($id)
    {
        $country = Country::findOrFail($id);
        return response()->json($country);
    }


    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        $country->update($request->all());

        return response()->json($country);
    }


    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

        return response()->json(null, 204);
    }
}