<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;

class CutOffController extends Controller
{
    public function index()
    {
        return view('admin.payroll.cutOff.index', []);
    }

}
