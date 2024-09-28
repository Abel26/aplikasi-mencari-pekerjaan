<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // mengambil data pengguna yang sedang login,mencari perusahaan yang dimiliki oleh pengguna
        $user = Auth::user();

        // mencari data perusahaan yang terhubung dengan employeer, yang idnya sesuai dengan id yg login
        $company = Company::with(['employeer'])->where('employer_id', $user->id)->first();

        // cek apakah perusahaan ada, maka diarahkan ke halaman create
        if (!$company) {
            return redirect()->route('admin.company.create');
        }

        return view('admin.company.index', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        // mengecek apakah user sebelumnya sudah pernah membuat perusahaan atau belum
        $user = Auth::user();
        $company = Company::where('employer_id', $user->id)->first();
        if ($company) {
            return redirect()->back()->withErrors(['company' => 'Failed! Anda sudah membuat company']);
        }

        DB::transaction(function () use ($request, $user) {
            $validated = $request->validated();
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $validated['logo'] = $logoPath;
            }
            $validated['slug'] = Str::slug($validated['name']);
            $validated['employer_id'] = $user->id;

            $newData = Company::create($validated);
        });

        return redirect()->route('admin.company.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $this->authorize('edit', $company);

        return view('admin.company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        DB::transaction(function () use ($request, $company) {
            $validated = $request->validated();
            if ($request->hasFile('logo')) {
                $logoPath =
                $request->file('logo')->store('logos', 'public');
                $validated['logo'] = $logoPath;
            }

            $validated['slug'] = Str::slug($validated['name']);

            $company->update($validated);
        });

        return redirect()->route('admin.company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
    }
}
