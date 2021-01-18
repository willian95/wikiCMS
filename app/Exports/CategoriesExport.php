<?php

namespace App\Exports;

use App\Category;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CategoriesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excels.categories', [
            'categories' => Category::all()
        ]);
    }
}
