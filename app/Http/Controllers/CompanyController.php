<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'facility_value' => 'array',
            'facility_value.*' => 'string|nullable',
        ]);

        $company = Company::create($request->only('name', 'address'));

        if ($request->has('facility_value')) {
            foreach ($request->facility_value as $key => $value) {
                if (!empty($value)) {
                    $company->facilities()->create([
                        'facility_value' => $value,
                        'facility_type' => $request->facility_type[$key],
                    ]);
                }
            }
        }

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'facility_value' => 'array',
            'facility_value.*' => 'string|nullable',
            'facility_type' => 'array',
            'facility_type.*' => 'string|nullable',
        ]);

        $company->update($request->only('name', 'address'));

        // Clear existing facilities and add the new ones
        $company->facilities()->delete();

        if ($request->has('facility_value')) {
            foreach ($request->facility_value as $key => $value) {
                if (!empty($value)) {
                    $company->facilities()->create([
                        'facility_value' => $value,
                        'facility_type' => $request->facility_type[$key],
                    ]);
                }
            }
        }

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }


    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
