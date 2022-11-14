<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {

        try {
            $department = Department::orderBy('name', 'ASC')->get();
            $data = ['data' => $department];
        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
        }
        return $data;
    }
    
}
