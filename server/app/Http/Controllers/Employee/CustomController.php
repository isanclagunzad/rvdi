<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.employee.customField.index');
    }

    public function manage(Request $request)
    {
        return view('admin.employee.customField.manage');
    }

}
