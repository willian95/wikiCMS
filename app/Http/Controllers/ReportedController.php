<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TeacherReport;
use App\Institution;
use App\InstitutionReport;
use App\Project;
use App\ProjectReport;
use App\Title;
use App\SecondaryField;
use App\UpvoteSystemProject;
use App\UpvoteSystemProjectVote;
use DB;

class ReportedController extends Controller
{
    
    function usersIndex(){

        return view("reported.users");

    }
    
    function usersFetch($page){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;

            $users = User::skip($skip)->take($dataAmount)->where("is_banned", 1)->withTrashed()->where("role_id", "2")->with("institution", "pendingInstitution", "country", "state")->get();
            $usersCount = User::with("institution", "pendingInstitution", "country", "state")->where("is_banned", 1)->withTrashed()->where("role_id", "2")->count();

            return response()->json(["success" => true, "users" => $users, "usersCount" => $usersCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    function usersSearch(Request $request){

        try{

            $dataAmount = 20;
            $skip = ($request->page - 1) * $dataAmount;

            $users = User::skip($skip)->take($dataAmount)->where("is_banned", 1)->where("name", "like", "%".$request->search."%")->orWhere("email", "like", "%".$request->search."%")->withTrashed()->where("role_id", "2")->with("institution", "pendingInstitution", "country", "state")->get();
            $usersCount = User::where("name", "like", "%".$request->search."%")->orWhere("email", "like", "%".$request->search."%")->withTrashed()->where("role_id", "2")->where("is_banned", 1)->with("institution", "pendingInstitution", "country", "state")->count();

            return response()->json(["success" => true, "users" => $users, "usersCount" => $usersCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Something went wrong"]);

        }

    }

    function showUser($id){

        $user = User::find($id);
        if($user && $user->role_id == 2){
            return view("profiles.teacherPublic", ["user" => $user]);
        }else{
            abort(404);
        }
    
    }

    function unbanUser(Request $request){

        try{

            $reports = TeacherReport::where("teacher_id", $request->teacherId)->get();

            foreach($reports as $report){
                $report->delete();
            }

            $teacher = User::find($request->teacherId);
            $teacher->is_banned = 0;
            $teacher->update();

            return response()->json(["success" => true, "msg" => "User unbanned"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Something went wrong"]);
        }

    }

    function institutionsIndex(){
        return view("reported.institutions");
    }

    function institutionsFetch($page){

        try{

            $dataAmount = 20;
            $skip = ($page - 1) * $dataAmount;

            $institutions = Institution::skip($skip)->take($dataAmount)->where("is_banned", 1)->withTrashed()->get();
            $institutionsCount = Institution::where("is_banned", 1)->withTrashed()->count();

            return response()->json(["success" => true, "institutions" => $institutions, "institutionsCount" => $institutionsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    function institutionsSearch(Request $request){

        try{

            $dataAmount = 20;
            $skip = ($request->page - 1) * $dataAmount;

            $institutions = Institution::skip($skip)->take($dataAmount)->where("is_banned", 1)->withTrashed()->get();
            $institutionsCount = Institution::where("name", "like", "%".$request->search."%")->withTrashed()->where("is_banned", 1)->count();

            return response()->json(["success" => true, "institutions" => $institutions, "institutionsCount" => $institutionsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Something went wrong"]);

        }

    }

    function showInstitution($id){

        $institution = Institution::find($id);
        if($institution){
            return view("profiles.institutionPublic", ["institution" => $institution]);
        }else{
            abort(404);
        }
        

    }

    function unbanInstitution(Request $request){

        try{

            $reports = InstitutionReport::where("institution_id", $request->institutionId)->get();

            foreach($reports as $report){
                $report->delete();
            }

            $institution = Institution::find($request->institutionId);
            $institution->is_banned = 0;
            $institution->update();

            return response()->json(["success" => true, "msg" => "Institution unbanned"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Something went wrong"]);
        }

    }

    function projectsIndex(){

        return view("reported.projects");

    }

    function projectsFetch($page){

        try{

            $dataAmount = 10;
            $skip = ($page-1) * $dataAmount;

            $projectQuery = Project::where("status", "banned")->orderBy("id", "desc")->with(["titles" => function($q){
                    $q->orderBy("id", "desc");
                }
            ]);

            $projectQueryCount = Project::where("status", "banned")->orderBy("id", "desc")->with(["titles" => function($q){
                    $q->orderBy("id", "desc");
                }
            ]);

            $projects = $projectQuery->skip($skip)->take($dataAmount)->get();
            $projectsCount = $projectQueryCount->count();

            return response()->json(["success" => true, "projects" => $projects, "projectsCount" => $projectsCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    public function showProject($slug){

        //dd($slug);

        $projctId = $slug;

        $project = Project::where("id", $projctId)->with(["titles" => function($q){
            $q->orderBy("id", "desc")->where("status", "launched")->take(1);
            }
        ])->with(["secondaryFields" => function($q){

            $q->groupBy('type')->orderBy('id', 'desc')->where("status", "launched")->get(['type', 'title', 'description', DB::raw('MAX(id) as id')]);

        }])->with("user")->get(); 

        if($project[0]->status == "banned" && \Auth::guest()){

            return "project reported";

        }

        if($project[0]->status == "banned" && \Auth::user()->role_id != 1){
            return "project reported";
        }

        $drivingQuestionTitle = "";
        $drivingQuestion = "";
        $timeFrameTitle = "";
        $timeFrame = "";
        $publicProductTitle = "";
        $publicProduct = "";
        $mainInfo = "";
        $bibliography="";
        $subjectTitle = "";
        $subjects = "";
        $levelTitle = "";
        $level = "";
        $hashtag = "";
        $calendarActivities = "";
        $upvoteSystem = "";
        $projectSumary = "";

        $title = $this->showTitleSection($project[0]->id)->title;
        $drivingQuestionTitle = $this->showProjectSection($project[0]->id, "drivingQuestion")->title;
        $drivingQuestion = $this->showProjectSection($project[0]->id, "drivingQuestion")->description;
        $timeFrameTitle = $this->showProjectSection($project[0]->id, "timeFrame")->title;
        $timeFrame = $this->showProjectSection($project[0]->id, "timeFrame")->description;
        $publicProductTitle = $this->showProjectSection($project[0]->id, "publicProduct")->title;
        $publicProduct = $this->showProjectSection($project[0]->id, "publicProduct")->description;
        $projectSumary = $this->showProjectSection($project[0]->id, "projectSumary")->description;
        $mainInfo = $this->showProjectSection($project[0]->id, "mainInfo")->description;
        $bibliography = $this->showProjectSection($project[0]->id, "bibliography")->description;
        $subjectTitle = $this->showProjectSection($project[0]->id, "subject")->title;
        $subjects = $this->showProjectSection($project[0]->id, "subject")->description;
        $levelTitle = $this->showProjectSection($project[0]->id, "level")->title;
        $level = $this->showProjectSection($project[0]->id, "level")->description;
        $hashtag = $this->showProjectSection($project[0]->id, "hashtag")->description;
        $calendarActivities = $this->showProjectSection($project[0]->id, "calendarActivities")->description;
        $upvoteSystem = $this->showProjectSection($project[0]->id, "upvoteSystem")->description;
        $assestmentPoints = UpvoteSystemProject::where("project_id", $project[0]->id)->with("assestmentPointType")->get();
        $assestmentPointsArray = [];

        foreach($assestmentPoints as $point){
            $assestmentPointsArray[] = [
                "name" =>  $point->assestmentPointType->name,
                "value" => UpvoteSystemProjectVote::where("project_id", $project[0]->id)->where("assestment_point_type_id", $point->assestmentPointType->id)->count()
            ];
        }

        $titleHistory = $this->titleHistory($project[0]->id);
        $drivingQuestionHistory = $this->secondaryFieldsHistory($project[0]->id, "drivingQuestion");
        $timeFrameHistory = $this->secondaryFieldsHistory($project[0]->id, "timeFrame");
        $publicProjectHistory = $this->secondaryFieldsHistory($project[0]->id, "publicProduct");
        $mainInfoHistory = $this->secondaryFieldsHistory($project[0]->id, "mainInfo");
        $bibliographyHistory = $this->secondaryFieldsHistory($project[0]->id, "bibliography");
        $subjectHistory = $this->secondaryFieldsHistory($project[0]->id, "subject");
        $levelHistory = $this->secondaryFieldsHistory($project[0]->id, "level");
        $hashtagHistory = $this->secondaryFieldsHistory($project[0]->id, "hashtag");
        $calendarActivitiesHistory = $this->secondaryFieldsHistory($project[0]->id, "calendarActivities");
        $projectSumaryHistory = $this->secondaryFieldsHistory($project[0]->id, "projectSumary");
            //$drivingQuestionHistory = $this->showProjectSection($project[0]->id, "upvoteSystem")

        
        if($project[0]->type == "own-template"){

            return view("profiles.ownTemplateShow", 
                [
                    "id" => $project[0]->id, 
                    "title" => $project[0]->titles[0]->title, 
                    "drivingQuestionTitle" => $drivingQuestionTitle,
                    "drivingQuestion" => $drivingQuestion,
                    "timeFrameTitle" => $timeFrameTitle,
                    "timeFrame" => $timeFrame,
                    "publicProductTitle" => $publicProductTitle,
                    "publicProduct" => $publicProduct,
                    "mainInfo" => $mainInfo,
                    "bibliography" => $bibliography,
                    "subjectTitle" => $subjectTitle,
                    "subjects" => $subjects,
                    "levelTitle" => $levelTitle,
                    "level" => $level,
                    "hashtag" => $hashtag,
                    "calendarActivities" => str_replace("'", "\'", $calendarActivities),
                    "upvoteSystem" => $upvoteSystem,
                    "projectSumary" => $projectSumary,
                    "project" => $project,
                    "assestmentPoints" => $assestmentPoints,
                    "assestmentPointsArray" => json_encode($assestmentPointsArray),
                    "titleHistory" => $titleHistory,
                    "drivingQuestionHistory" => $drivingQuestionHistory,
                    "timeFrameHistory" => $timeFrameHistory,
                    "publicProjectHistory" => $publicProjectHistory,
                    "mainInfoHistory" => $mainInfoHistory,
                    "bibliographyHistory" => $bibliographyHistory,
                    "subjectHistory" => $subjectHistory,
                    "levelHistory" => $levelHistory,
                    "hashtagHistory" => $hashtagHistory,
                    "calendarActivitiesHistory" => $calendarActivitiesHistory,
                    "projectSumaryHistory" => $projectSumaryHistory
                ]
            );
        }else{

            $toolsTitle = $this->showProjectSection($project[0]->id, "tools")->title;
            $tools = $this->showProjectSection($project[0]->id, "tools")->description;
            $learningGoalsTitle = $this->showProjectSection($project[0]->id, "learningGoals")->title;
            $learningGoals = $this->showProjectSection($project[0]->id, "learningGoals")->description;
            $resourcesTitle = $this->showProjectSection($project[0]->id, "resources")->title;
            $resources = $this->showProjectSection($project[0]->id, "resources")->description;
            $projectMilestonesTitle = $this->showProjectSection($project[0]->id, "projectMilestone")->title;
            $projectMilestones = $this->showProjectSection($project[0]->id, "projectMilestone")->description;
            $expertTitle = $this->showProjectSection($project[0]->id, "expert")->title;
            $expert  = $this->showProjectSection($project[0]->id, "expert")->description;
            $fieldWorkTitle = $this->showProjectSection($project[0]->id, "fieldWork")->title;
            $fieldWork  = $this->showProjectSection($project[0]->id, "fieldWork")->description;
            $globalConnectionsTitle = $this->showProjectSection($project[0]->id, "globalConnections")->title;
            $globalConnections = $this->showProjectSection($project[0]->id, "globalConnections")->description;
            $assestmentPoints = UpvoteSystemProject::where("project_id", $project[0]->id)->with("assestmentPointType")->get();
            $assestmentPointsArray = [];

            foreach($assestmentPoints as $point){
                $assestmentPointsArray[] = [
                    "name" =>  $point->assestmentPointType->name,
                    "value" => UpvoteSystemProjectVote::where("project_id", $project[0]->id)->where("assestment_point_type_id", $point->assestmentPointType->id)->count()
                ];
            }

            $toolHistory = $this->secondaryFieldsHistory($project[0]->id, "tools");
            $learningGoalHistory = $this->secondaryFieldsHistory($project[0]->id, "learningGoals");
            $resourceHistory = $this->secondaryFieldsHistory($project[0]->id, "resources");
            $projectMilestoneHistory = $this->secondaryFieldsHistory($project[0]->id, "projectMilestone");
            $expertHistory  = $this->secondaryFieldsHistory($project[0]->id, "expert");
            $fieldWorkHistory  = $this->secondaryFieldsHistory($project[0]->id, "fieldWork");
            $globalConnectionHistory = $this->secondaryFieldsHistory($project[0]->id, "globalConnections");

            return view("profiles.wikiPBLTemplateShow", [
                "id" => $project[0]->id, 
                "title" => $title, 
                "drivingQuestionTitle" => $drivingQuestionTitle,
                "drivingQuestion" => $drivingQuestion,
                "timeFrameTitle" => $timeFrameTitle,
                "timeFrame" => $timeFrame,
                "publicProductTitle" => $publicProductTitle,
                "publicProduct" => $publicProduct,
                "mainInfo" => $mainInfo,
                "bibliography" => $bibliography,
                "subjectTitle" => $subjectTitle,
                "subjects" => $subjects,
                "levelTitle" => $levelTitle,
                "level" => $level,
                "hashtag" => $hashtag,
                "calendarActivities" => str_replace("'", "\'", $calendarActivities),
                "upvoteSystem" => $upvoteSystem,
                "projectSumary" => $projectSumary,
                "project" => $project,
                "toolsTitle" => $toolsTitle,
                "tools" => $tools,
                "learningGoalsTitle" => $learningGoalsTitle,
                "learningGoals" => str_replace("'", "\'", $learningGoals),
                "resourcesTitle" => $resourcesTitle,
                "resources" => $resources,
                "projectMilestonesTitle" => $projectMilestonesTitle,
                "projectMilestones" => str_replace("'", "\'", $projectMilestones),
                "expertTitle" => $expertTitle,
                "expert" => $expert,
                "fieldWorkTitle" => $fieldWorkTitle,
                "fieldWork" => $fieldWork,
                "globalConnectionsTitle" => $globalConnectionsTitle,
                "globalConnections" => $globalConnections,
                "assestmentPoints" => $assestmentPoints,
                "assestmentPointsArray" => json_encode($assestmentPointsArray),
                "projectSumaryHistory" => $projectSumaryHistory,

                "titleHistory" => $titleHistory,
                "drivingQuestionHistory" => $drivingQuestionHistory,
                "timeFrameHistory" => $timeFrameHistory,
                "publicProjectHistory" => $publicProjectHistory,
                "mainInfoHistory" => $mainInfoHistory,
                "bibliographyHistory" => $bibliographyHistory,
                "subjectHistory" => $subjectHistory,
                "levelHistory" => $levelHistory,
                "hashtagHistory" => $hashtagHistory,
                "calendarActivitiesHistory" => $calendarActivitiesHistory,
                "toolHistory" => $toolHistory,
                "learningGoalHistory" => $learningGoalHistory,
                "resourceHistory" => $resourceHistory,
                "projectMilestoneHistory" => $projectMilestoneHistory,
                "expertHistory" => $expertHistory,
                "fieldWorkHistory" => $fieldWorkHistory,
                "globalConnectionHistory" => $globalConnectionHistory
            ]);
        }


    }

    function showProjectSection($projectId, $type){

        return SecondaryField::where("project_id", $projectId)->where("type", $type)->orderBy("id", "desc")->where("status", "launched")->first();

    }

    function showTitleSection($projectId){

        return Title::where("project_id", $projectId)->orderBy("id", "desc")->where("status", "launched")->first();

    }

    function titleHistory($project_id){

        $historyTitleChanges = [];

        $titles = Title::where("project_id", $project_id)->where("status", "launched")->orderBy("id", "desc")->with(["user" => function($q){
            $q->withTrashed();
        }])->get();

        foreach($titles as $title){

            if($title->user){
                $historyTitleChanges[] = [
                    "user" => $title->user->name." ".$title->user->lastname,
                    "date" => $title->updated_at->format("m/d/Y")
                ];
            }

        }

        return json_encode($historyTitleChanges);

    }

    function secondaryFieldsHistory($project_id, $type){

        $historySectionChanges = [];

        $fields = SecondaryField::where("project_id", $project_id)->where("type", $type)->where("status", "launched")->orderBy("id", "desc")->with(["user" => function($q){
            $q->withTrashed();
        }])->get();

        foreach($fields as $field){

            if($field->user){
                $historySectionChanges[] = [
                    "user" => $field->user->name." ".$field->user->lastname,
                    "date" => $field->updated_at->format("m/d/Y")
                ];
            }

        }
        return json_encode($historySectionChanges);

    }

    function unbanProject(Request $request){

        try{

            $reports = ProjectReport::where("project_id", $request->projectId)->get();

            foreach($reports as $report){
                $report->delete();
            }

            $project = Project::find($request->projectId);
            $project->status = "launched";
            $project->update();

            return response()->json(["success" => true, "msg" => "Project unbanned"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Something went wrong"]);
        }

    }

    

}
