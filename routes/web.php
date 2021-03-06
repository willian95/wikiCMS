<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/email-test", function(){

    //dd(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"), env("MAIL_PASSWORD"));

    $to_email = "rodriguezwillian95@gmail.com";
    $to_name = "Willian";

    \Mail::send("emails.email", [], function($message) use ($to_name, $to_email) {

        $message->to($to_email, $to_name)->subject("test");
        $message->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"));

    });

});

Route::get('/', "AuthController@index")->name("login")->middleware("guest");
Route::post("login", "AuthController@login");

Route::middleware(['auth'])->group(function () {

    Route::get("/home", "DashboardController@index");

    Route::get("/institution", "InstitutionController@index")->name("institutions.index");
    Route::post("institution/store", "InstitutionController@store");
    Route::post("institution/search", "InstitutionController@search");
    Route::get("/institution/fetch/{page}", "InstitutionController@fetch");
    Route::post("/institution/update", "InstitutionController@update");
    Route::post("/institution/delete", "InstitutionController@delete");
    Route::get("/institution/all", "InstitutionController@all");
    Route::get("/institution/export/csv", "InstitutionController@exportCsv");  
    Route::get("/institution/export/excel", "InstitutionController@exportExcel");
    Route::get("/institution/export/pdf", "InstitutionController@exportPdf");    
    Route::post("/institution/change-status", "InstitutionController@changeStatus");

    Route::get("pending-institution", "PendingInstitutionController@index");
    Route::get("pending-institution/fetch/{page}", "PendingInstitutionController@fetch");
    Route::post("pending-institution/approve", "PendingInstitutionController@approve");
    Route::post("pending-institution/search", "PendingInstitutionController@search");

    Route::get("/subject", "SubjectController@index")->name("categories.index");
    Route::post("subject/store", "SubjectController@store");
    Route::post("subject/search", "SubjectController@search");
    Route::get("/subject/fetch/{page}", "SubjectController@fetch");
    Route::post("/subject/update", "SubjectController@update");
    Route::post("/subject/delete", "SubjectController@delete");
    Route::get("/subject/all", "SubjectController@all");
    Route::get("/subject/export/csv", "SubjectController@exportCsv");  
    Route::get("/subject/export/excel", "SubjectController@exportExcel");
    Route::get("/subject/export/pdf", "SubjectController@exportPdf");    

    Route::get("/admin-email", "AdminMailController@index")->name("admin.email");
    Route::post("admin-email/store", "AdminMailController@store");
    Route::get("/admin-email/fetch", "AdminMailController@fetch");
    Route::post("/admin-email/update", "AdminMailController@update");
    Route::post("/admin-email/delete", "AdminMailController@delete");
    
    Route::get("/users", "UserController@index");
    Route::get("/users/fetch/{page}", "UserController@fetch");
    Route::get("/users/export/pdf", "UserController@exportPdf");
    Route::get("/users/export/excel", "UserController@exportExcel");
    Route::get("/users/export/csv", "UserController@exportCsv");
    Route::post("/users/search", "UserController@search");
    Route::post("/users/delete", "UserController@delete");
    Route::post("/users/restore", "UserController@restore");

    Route::get("/projects", "ProjectController@index");
    Route::get("/projects/fetch/{page}", "ProjectController@fetch");
    Route::post("/projects/search", "ProjectController@search");
    Route::post("/projects/delete", "ProjectController@delete");
    Route::post("/projects/restore", "ProjectController@restore");

    Route::get("/reported/users", "ReportedController@usersIndex");
    Route::get("/reported/users/fetch/{page}", "ReportedController@usersFetch");
    Route::get("/reported/users/show/{id}", "ReportedController@showUser");
    Route::post("/reported/users/search", "ReportedController@usersSearch");
    Route::post("/reported/users/unreport", "ReportedController@unbanUser");

    Route::get("/reported/institutions", "ReportedController@institutionsIndex");
    Route::get("/reported/institutions/fetch/{page}", "ReportedController@institutionsFetch");
    Route::get("/reported/institutions/show/{id}", "ReportedController@showInstitution");
    Route::post("/reported/institutions/search", "ReportedController@institutionsSearch");
    Route::post("/reported/institutions/unreport", "ReportedController@unbanInstitution");

    Route::get("/reported/projects", "ReportedController@projectsIndex");
    Route::get("/reported/projects/fetch/{page}", "ReportedController@projectsFetch");
    Route::get("/reported/projects/show/{id}", "ReportedController@showProject");
    Route::post("/reported/projects/unreport", "ReportedController@unbanProject");

    Route::get("project/public/my-projects/{page}/{teacherId}", "ProjectController@publicMyProjects");
    Route::get("project/public/my-public-projects/{page}/{teacherId}", "ProjectController@publicMyProjects");
    Route::get("project/public/my-follow-projects/{page}/{teacherId}", "ProjectController@publicMyFollowProjects");

    Route::get("/logout", "AuthController@logout");

    Route::get("/institution/public/get-teachers/{id}", "InstitutionController@getPublicInstitutionTeachers");
    Route::get("/institution/public/get-users/{id}", "InstitutionController@getPublicInstitutionUsers");

});