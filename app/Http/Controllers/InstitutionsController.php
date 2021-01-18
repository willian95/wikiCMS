<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstitutionsController extends Controller
{
    function index(){

        return view("institutions.index");

    }
}
