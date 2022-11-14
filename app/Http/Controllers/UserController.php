<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserVerification;
use App\Models\Department;
use App\Models\Record;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            foreach ($users as $user) {
                $department = Department::findOrFail($user['department_id']);
                $record = Record::where('user_id', '=', $user['id'])->where('action', '=', 'entry')->count();

                $user['department_name'] = $department->name;
                $user['total'] = $record;

                if ($user['type'] == '1') {
                    $user['type'] = 'Employee';
                } else {
                    $user['type'] = 'Admin';
                }
            }
            $data = ['data' => $users];
        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
        }

        return $data;
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'document' => 'required|unique:users',
            'type' => 'required',
            'status' => 'required',
            'department' => 'required',
        ]);
        try {
            $department = Department::findOrFail($request->department);
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->document = $request->document;
            if ($request->password != '') {
                $user->password = Hash::make($request->password);
            }
            $user->type = $request->type;
            $user->status = $request->status;
            $user->department_id = $department->id;
            $user->save();
            $data = ['response' => 'done'];
        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
        }

        return $data;
    }

    public function uploadUsers(Request $request)
    {
        try {
            $data = ['response' =>  Excel::import(new UsersImport, $request->file)];

        } catch (\Throwable $th) {
            $data = ['response' => $th];
        }

        return $data;
    }

    public function show(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $data = ['user' => $user];
        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
        }
        return $data;
    }

    public function change(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->status = $request->status;
            $user->save();
            $data = ['response' => 'done'];
        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
        }
        return $data;
    }

    public function isset(Request $request)
    {
        try {
            $user = User::whereDocument($request->document)->get();
            $data = ['response' => $user];
        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
        }
        return $data;
    }

    public function update(Request $request)
    {

        try {
            $department = Department::findOrFail($request->department_up);
            $user = User::findOrFail($request->idUser);
            $user->first_name = $request->first_name_up;
            $user->last_name = $request->last_name_up;
            $user->document = $request->document_up;
            if ($request->password_up != '') {
                $user->password = Hash::make($request->password_up);
            }
            $user->type = $request->type_up;
            $user->status = $request->status_up;
            $user->department_id = $department->id;
            $user->save();
            $data = ['response' => 'done'];
        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
        }

        return $data;
    }

    public function destroy(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->delete();
            $data = ['response' => 'done'];
        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
        }
        return $data;
    }
}
