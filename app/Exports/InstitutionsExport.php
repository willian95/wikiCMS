<?php

namespace App\Exports;

use App\Institution;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InstitutionsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excels.institutions', [
            'institutions' => Institution::with("users")->get()
        ]);
    }
}
