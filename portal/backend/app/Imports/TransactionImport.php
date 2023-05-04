<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class TransactionImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Log::debug($row['name'] ." ---------". $row['email']);
            // User::create([
            //     'name' => $row['name'],
            //     'email' => $row['email'],
            //     'password' => bcrypt($row['password']),
            // ]);
        }
    }
}
