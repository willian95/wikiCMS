<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PDF;
use Excel;

class UserController extends Controller
{
    
    function index(){
        return view("users.index");
    }

    function fetch($page){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;

            $users = User::skip($skip)->take($dataAmount)->withTrashed()->where("role_id", ">", "1")->with("institution", "pendingInstitution", "country", "state")->get();
            $usersCount = User::with("institution", "pendingInstitution", "country", "state")->withTrashed()->where("role_id", ">", "1")->count();

            return response()->json(["success" => true, "users" => $users, "usersCount" => $usersCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    function search(Request $request){

        try{

            $dataAmount = 20;
            $skip = ($request->page - 1) * $dataAmount;

            $users = User::skip($skip)->take($dataAmount)->where("name", "like", "%".$request->search."%")->orWhere("email", "like", "%".$request->search."%")->withTrashed()->where("role_id", ">", "1")->with("institution", "pendingInstitution", "country", "state")->get();
            $usersCount = User::where("name", "like", "%".$request->search."%")->orWhere("email", "like", "%".$request->search."%")->withTrashed()->where("role_id", ">", "1")->with("institution", "pendingInstitution", "country", "state")->count();

            return response()->json(["success" => true, "users" => $users, "usersCount" => $usersCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Something went wrong"]);

        }

    }

    function delete(Request $request){

        try{

            $user = User::find($request->id);
            $user->delete();

            return response()->json(["success" => true, "msg" => "User blocked"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    function restore(Request $request){

        try{

            $user = User::where("id", $request->id)->withTrashed()->first();
            $user->restore();

            return response()->json(["success" => true, "msg" => "User restored"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    function exportPdf(){

        $pdf = PDF::loadView('pdfs.users', ["users" => User::where("role_id", ">", "1")->with("institution", "pendingInstitution", "country", "state")->get()]);
        return $pdf->download('users.pdf');

    }

    function exportExcel(){

        return Excel::download(new InstitutionsExport, 'institutions.xlsx');

    }

    function exportCsv(){

        return Excel::download(new InstitutionsExport, 'institutions.csv');

    }

}
