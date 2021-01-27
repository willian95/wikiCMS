<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\AdminMail;

class AdminMailTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function createAdminMail()
    {
        $this->withoutExceptionHandling();

        $email = "williandev95@gmail.com";

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post("/admin-email/store", [
            'email' => $email
        ]);

        $response->assertOk();
        $this->assertCount(1, AdminMail::all());
        
        $adminMail = AdminMail::first();

        $this->assertEquals($adminMail->email, $email);

    }

    /** @test */
    public function indexExists(){

        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get("/admin-email");

        $response->assertOk();
        $response->assertViewIs("mail.index");

    }

    /** @test */
    public function listAdminMail(){

        $this->withoutExceptionHandling();

        $adminMails = factory(AdminMail::class, 3)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get("/admin-email/fetch");

        $response->assertOk();
        $this->assertCount(3, AdminMail::all());

    }

    /** @test */
    public function updateAdminMail(){

        $this->withoutExceptionHandling();

        $email = "williandev952@gmail.com";

        $user = factory(User::class)->create();
        $adminMail = factory(AdminMail::class)->create();

        $response = $this->actingAs($user)->post("/admin-email/update", [
            'email' => $email,
            "id" => $adminMail->id
        ]);

        $response->assertOk();
        $this->assertCount(1, AdminMail::all());
        
        $adminMail = AdminMail::first();

        $this->assertEquals($adminMail->email, $email);

    }

    /** @test */
    public function deleteAdminMail(){

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $adminMail = factory(AdminMail::class)->create();

        $response = $this->actingAs($user)->post("/admin-email/delete", [
            "id" => $adminMail->id
        ]);

        $response->assertOk();
        $this->assertCount(0, AdminMail::all());

    }


}
