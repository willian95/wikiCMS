<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Institution;

class InstitutionTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    
    /** @test */
    public function indexExists()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get("/institution");

        $response->assertOk();
        $response->assertViewIs("institutions.index");
    }

    /** @test */
    public function storeInstitution()
    {
        $this->withoutExceptionHandling();

        $name = "Colegion";
        $image = "url de imagen";
        $website = "sitio web";
        $type = "organización";

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post("/institution/store", [
            "name" => $name,
            "image" => $image,
            "website" => $website,
            "type" => $type,
            "adminName" => "Willian Rodríguez",
            "adminEmail" => "rodriguezwillian95@gmail.com",
            "adminPassword" => "12345678",
            "adminName2" => "Jesus Ramirez",
            "adminEmail2" => "williandev95@gmail.com",
            "adminPassword2" => "12345678",
        ]);

        $response->assertOk();
        $this->assertCount(1, Institution::all());
        $this->assertCount(1, User::all());
        
        $institution = Institution::first();

        $this->assertEquals($institution->name, $name);
        $this->assertEquals($institution->image, $image);
        $this->assertEquals($institution->website, $website);
        $this->assertEquals($institution->type, $type);

    }

    /** @test */
    public function listInstitution(){

        $this->withoutExceptionHandling();

        $institutions = factory(Institution::class, 3)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get("/institution/fetch/1");

        $response->assertOk();
        $this->assertCount(3, Institution::all());

    }


    /** @test */
    public function updateInstitution(){

        $this->withoutExceptionHandling();

        $name = "Colegion";
        $image = "url de imagen";
        $website = "sitio web";
        $type = "organización";

        $user = factory(User::class)->create();
        $admin1 = factory(User::class)->create();
        $admin2 = factory(User::class)->create();
        
        $institution = factory(Institution::class)->create();

        $response = $this->actingAs($user)->post("/institution/update", [
            "name" => $name,
            "image" => $image,
            "website" => $website,
            "type" => $type,
            "adminId" => $admin1,
            "adminId2" => $admin2,
            "adminName" => "Willian Rodríguez",
            "adminEmail" => "rodriguezwillian95@gmail.com",
            "adminPassword" => "12345678",
            "adminName2" => "Jesus Ramirez",
            "adminEmail2" => "williandev95@gmail.com",
            "adminPassword2" => "12345678",
            "id" => $institution->id
        ]);

        $response->assertOk();
        $this->assertCount(1, Institution::all());
        
        $institution = Institution::first();

        $this->assertEquals($institution->name, $name);
        $this->assertEquals($institution->image, $image);
        $this->assertEquals($institution->website, $website);
        $this->assertEquals($institution->type, $type);

    }

    /** @test */
    public function deleteInstitution(){

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $institution = factory(Institution::class)->create();

        $response = $this->actingAs($user)->post("/institution/delete", [
            "id" => $institution->id
        ]);

        $response->assertOk();
        $this->assertCount(0, institution::all());

    }


}
