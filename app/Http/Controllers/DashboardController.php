<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $company = Company::count();

        return view('dashboard.dashboard', [
            'company' => $company,
        ]);
    }
}
