<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Title;
use DB;

class ProjectController extends Controller
{
    
    function index(){

        return view("projects.index");

    }

    function fetch($page){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;

            $projects = Project::skip($skip)->take($dataAmount)->withTrashed()->where("status", "launched")->with("user")->with(["titles" => function($q){
                $q->orderBy("id", "desc")->where("status", "launched")->take(1);
                }
            ])->get();
            $projectsCount = Project::with(["titles" => function($q){
                $q->orderBy("id", "desc")->where("status", "launched")->take(1);
                }
            ])->withTrashed()->with("user")->where("status", "launched")->count();

            return response()->json(["success" => true, "projects" => $projects, "projectsCount" => $projectsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    function search(Request $request){

        try{

            $dataAmount = 20;
            $skip = ($request->page-1) * $dataAmount;

            $projects = [];
            $projectId = [];
            $projectResults = [];
            $words = $this->splitWords($request);

            $titles = $this->projectTitles($words);

            foreach($titles as $result){
                array_push($projectId, $result->project_id);
            }

            $projects = array_reverse($projectId);
            $projects = array_count_values($projects);
            $projectsCount = count($projects);
            $projectId = [];

            foreach($projects as $key => $value){

                $projectId[] = [
                    "id" => $key,
                    "amount" => $value
                ];

            }

            usort($projectId, function ($item1, $item2) {
                return $item2['amount'] <=> $item1['amount'];
            });


            $projects = [];
            $skipIndex = 0;
            $takeIndex = 0;
           
            foreach($projectId as $project){

                if($skipIndex >= $skip && $takeIndex < $dataAmount){
                    
                    array_push($projects, $project["id"]);

                    $takeIndex++;
                }
                
                $skipIndex++;
                
            }
            
            $projectsResults = [];
            foreach($projects as $key){

                $projectModel = Project::where("id", $key)->with(["titles" => function($q){
                    $q->orderBy("id", "desc")->where("status", "launched")->take(1);
                    }
                ])->with("user")->first(); 

                $projectsResults[] = [
                    $projectModel
                ];

            }

            return response()->json(["success" => true, "projects" => $projectsResults, "projectsCount" => $projectsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    function splitWords($request){

        $words = explode(' ',strtolower($request->search)); // coloco cada palabra en un espacio del array
        $wordsToDelete = array('de', "y", "la");

        $words = array_values(array_diff($words,$wordsToDelete)); // Elimino todas las coincidencias de las wordsToDelete

        return $words;
    }

    function projectTitles($words){
        $titles = Title::where(function ($query) use($words) {
            for ($i = 0; $i < count($words); $i++){
                if($words[$i] != ""){
                    $query->where('title', "like", "%".$words[$i]."%")->where("status", "launched")->groupBy("project_id")->get(['title', DB::raw('MAX(id) as id')]);
                }
            }      
        })->get();

        return $titles;
    }

    function delete(Request $request){

        try{

            $project = Project::find($request->id);
            $project->delete();

            return response()->json(["success" => true, "msg" => "Project blocked"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Something went wrong", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function restore(Request $request){

        try{

            $project = Project::where("id", $request->id)->withTrashed()->first();
            $project->restore();

            return response()->json(["success" => true, "msg" => "Project restored"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

}
