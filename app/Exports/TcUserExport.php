<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TcUserExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return User::all();
        return User::all()->map(function($user) {
            return [
                'id' => $user->id,
               'first_name' => $user->first_name,
               'last_name' => $user->last_name,
               'user_mobile' => $user->user_mobile,
               'email '=> $user->email,
               'gender'=> $user->gender,
               'user_code '=>$user->user_code,
               'created_at'=>$user->created_at
            ];
        });
    }
    public function headings(): array
    {
        return [
            'ID',
            'FIRSTNAME',
            'LASTNAME',
            'MOBILE NUMBER',
            'EMAIL ID',
            'GENDER',
            'USER CODE',
            'CREATE_AT'
        ];
    }
}
