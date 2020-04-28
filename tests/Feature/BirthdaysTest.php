<?php

namespace Tests\Feature;

use App\Contact;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BirthdaysTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function contacts_with_birthdays_in_the_current_month_can_be_fetch()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $birthdayContact = factory(Contact::class)->create([
            'birthday' => now()->subYear(),
            'user_id' => $user->id
        ]);
        $noBirthdayContact = factory(Contact::class)->create([
            'birthday' => now()->subMonth(),
            'user_id' => $user->id
        ]);

        $this->get("/api/birthdays?api_token={$user->api_token}")->assertJsonCount(1)->assertJson([
            'data' => [
                [
                    'data' => [
                        'contact_id' => $birthdayContact->id,
                        'company'    => $birthdayContact->company
                    ]
                ]
            ]
        ]);
    }
}
