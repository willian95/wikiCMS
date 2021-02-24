<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excels.users', [
            'users' => User::where("role_id", ">", "1")->with("institution", "pendingInstitution", "country", "state")->get()
        ]);
    }
}
