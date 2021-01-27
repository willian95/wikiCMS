<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Subject;

class SubjectTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    /** @test */
    public function indexExists()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get("/subject");

        $response->assertOk();
        $response->assertViewIs("subjects.index");
    }

    /** @test */
    public function storeSubject()
    {
        //$this->withoutExceptionHandling();

        $name = "Math";
        $institutionType = "organization";

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post("/subject/store", [
            "name" => $name,
            "institutionType" => $institutionType,

        ]);

        $response->assertOk();
        $this->assertCount(1, Subject::all());
        
        $subject = Subject::first();

        $this->assertEquals($subject->name, $name);
        $this->assertEquals($subject->institution_type, $institutionType);

    }


}
