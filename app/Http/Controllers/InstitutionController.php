<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InstitutionStoreRequest;
use App\Http\Requests\InstitutionUpdateRequest;
use App\Institution;
use App\User;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InstitutionsExport;
use PDF;

class InstitutionController extends Controller
{
    function index(){

        return view("institutions.index");

    }

    function store(InstitutionStoreRequest $request){

        try{

            if($request->adminEmail == $request->adminEmail2){
                return response()->json(["success"=> false, "msg" => "Administrator emails can't be the same"]);
            }
    
            $institution = new Institution;
            $institution->name = $request->name;
            $institution->website = $request->website;
            $institution->type = $request->type;
            $institution->status = "approved";
            $institution->save();

            $this->storeUser($request->adminName, $request->adminEmail, $request->adminPassword, $institution->id);
            $this->storeUser($request->adminName2, $request->adminEmail2, $request->adminPassword2, $institution->id);

            return response()->json(["success"=> true, "msg" => "Institution succesfully created"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Something went wrong", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function update(InstitutionUpdateRequest $request){

        try{

            if($request->adminEmail == $request->adminEmail2){
                return response()->json(["success"=> false, "msg" => "Administrator emails can't be the same"]);
            }
    
            $institution = Institution::find($request->id);
            $institution->name = $request->name;
            
            $institution->website = $request->website;
            $institution->type = $request->type;
            $institution->status = "approved";
            $institution->update();

            $this->updateUser($request->adminId, $request->adminName, $request->adminEmail, $request->adminPassword, $institution->id);
            $this->updateUser($request->adminId2, $request->adminName2, $request->adminEmail2, $request->adminPassword2, $institution->id);

            return response()->json(["success"=> true, "msg" => "Institution succesfully updated"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Something went wrong", "err" => $e->getMessage(), "ln" => $e->getLine()]);
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

    function updateUser($id, $name, $email, $password, $institutionId){

        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;

        if(isset($password)){
            $user->password = bcrypt($password);
        }

        $user->institution_id = $institutionId;
        $user->email_verified_at = Carbon::now();
        $user->role_id = 3;
        $user->update();

    }

    function fetch($page){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;

            $institutions = Institution::skip($skip)->take($dataAmount)->with("users")->get();
            $institutionsCount = Institution::count();

            return response()->json(["success" => true, "institutions" => $institutions, "institutionsCount" => $institutionsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    function delete(Request $request){

        try{

            $institution = Institution::find($request->id);
            $institution->delete();

            $this->deleteUsers($request->id);

            return response()->json(["success" => true, "msg" => "Institution deleted"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Something went wrong"]);

        }

    }

    function deleteUsers($institutionId){

        $users = User::where("institution_id", $institutionId)->get();
        foreach($users as $user){

            $user->email = $user->email."-".uniqid();
            $user->update();

            $user->delete();

        }

    }

    function search(Request $request){

        try{

            $dataAmount = 20;
            $skip = ($request->page - 1) * $dataAmount;

            $institutions = Institution::skip($skip)->take($dataAmount)->where("name", "like", "%".$request->search."%")->get();
            $institutionsCount = Institution::where("name", "like", "%".$request->search."%")->count();

            return response()->json(["success" => true, "institutions" => $institutions, "institutionsCount" => $institutionsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Something went wrong"]);

        }

    }

    function exportExcel(){

        return Excel::download(new InstitutionsExport, 'institutions.xlsx');

    }

    function exportCsv(){

        return Excel::download(new InstitutionsExport, 'institutions.csv');

    }

    function exportPdf(){

        $pdf = PDF::loadView('pdfs.institutions', ["institutions" => Institution::with("users")->get()]);
        return $pdf->download('institutions.pdf');

    }

    function changeStatus(Request $request){

        try{

            $institution = Institution::find($request->id);
            $institution->status = $request->status;
            $institution->update();

            return response()->json(["success" => true, "msg" => "Institution status changed", "status" => $request->status]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Something went wrong"]);

        }

    }

    function getPublicInstitutionUsers($id){

        $users = User::where("institution_id", $id)->where("role_id", 3)->get();
        return response()->json(["users" => $users]);
    }

    function getPublicInstitutionTeachers($id){

        $teachers = User::where("institution_id", $id)->where("role_id", 2)->count();
        return response()->json(["teachers" => $teachers]);
        
    }

}
