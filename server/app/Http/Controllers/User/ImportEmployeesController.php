<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ImportEmployeesController extends Controller
{
    public function index()
    {
        // Add your logic here
        return view('admin.user.importFiles.importEmployees');
    }
}
