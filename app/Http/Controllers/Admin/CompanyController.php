<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Company::first();
        return view('backend.company.index', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $data = $request->all();
        $company->update($data);

        return redirect()->back()->with('update', 'Profil perusahaan berhasil diperbarui');
    }
}
