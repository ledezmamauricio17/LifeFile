<?php

namespace App\Http\Controllers;

use App\Models\Asignment;
use App\Models\Department;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $department = Department::findOrFail($user['department_id']);
            $records = Record::where('user_id', '=', $user->id)->get();
            foreach ($records as $record) {
                $record['first_name'] = $user->first_name;
                $record['last_name'] = $user->last_name;
                $record['document'] = $user->document;
                $record['department'] = $department->name;
            }
            $data = ['data' => $records];

        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
        }
        return $data;
    }

    public function store(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $record = new Record();
            $record->action = $request->action;
            $record->date = now();
            $record->user_id = $user->id;
            $record->save();

            $data = ['data' => $record];

        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
        }
        return $data;
    }

    public function filter(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $department = Department::findOrFail($user['department_id']);
            $records = Record::where('user_id', '=', $user->id)->whereBetween('date', [$request->min, $request->max])->get();
            foreach ($records as $record) {
                $record['first_name'] = $user->first_name;
                $record['last_name'] = $user->last_name;
                $record['document'] = $user->document;
                $record['department'] = $department->name;
            }
            $data = ['data' => $records];

        } catch (\Exception $e) {
            $data = ['response' => 'error', $e];
        }
        return $data;

    }

}
