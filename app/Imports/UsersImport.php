<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = new User([
            "first_name" => $row['first_name'],
            "last_name" => $row['last_name'],
            "document" => $row['document'],
            "type" => $row['type'],
            "status" => $row['status'],
            "password" => Hash::make($row['document']),
            "department" => $row['department']
        ]);
        return $user;
    }
}
