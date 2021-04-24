<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PendingInstitution;
use App\Institution;
use Carbon\Carbon;
use App\User;
use App\Http\Requests\PendingInstitutionApproveRequest;

class PendingInstitutionController extends Controller
{   
    function index(){

        return view("pendingInstitutions.index");

    }

    function fetch($page){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;

            $pendingInstitutions = PendingInstitution::skip($skip)->take($dataAmount)->get();
            $pendingInstitutionsCount = PendingInstitution::count();

            return response()->json(["success" => true, "pendingInstitutions" => $pendingInstitutions, "pendingInstitutionsCount" => $pendingInstitutionsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    function approve(PendingInstitutionApproveRequest $request){

        try{

            $institution = new Institution;
            $institution->name = $request->name;
            $institution->website = $request->website;
            $institution->type = $request->type;
            $institution->status = "approved";
            $institution->save();

            $this->storeUser($request->adminName, $request->adminEmail, $request->adminPassword, $institution->id);
            $this->changeUserPendingInstitution($request, $institution->id);
            $pendingInstitution = PendingInstitution::find($request->pendingInstitution);
            $pendingInstitution->delete();

            return response()->json(["success"=> true, "msg" => "Institution approved"]);
            
        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Something wen wrong", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function storeUser($name, $email, $password, $institutionId){

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->institution_id = $institutionId;
        $user->email_verified_at = Carbon::now();
        $user->role_id = 3;
        $user->save();

    }

    function changeUserPendingInstitution($request, $institutionId){

        User::where("pending_institution_id", $request->pendingInstitution)->update([
            "pending_institution_id" => null,
            "institution_id" => $institutionId,
            "pending_institution_name" => null
        ]);

    }

    function search(Request $request){

        try{

            $dataAmount = 20;
            $skip = ($request->page - 1) * $dataAmount;

            $pendingInstitutions = PendingInstitution::skip($skip)->take($dataAmount)->where("name", "like", "%".$request->search."%")->get();
            $pendingInstitutionsCount = PendingInstitution::where("name", "like", "%".$request->search."%")->count();

            return response()->json(["success" => true, "pendingInstitutions" => $pendingInstitutions, "pendingInstitutionsCount" => $pendingInstitutionsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Something went wrong"]);

        }

    }

}
