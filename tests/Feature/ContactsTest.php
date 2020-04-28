<?php

namespace Tests\Feature;

use App\Contact;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp() :void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function an_authenticated_user_should_redirect_to_login()
    {
        $response = $this->post('/api/contacts', array_merge($this->data(), ['api_token' => '']));
        $response->assertRedirect('/login');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function a_list_of_contacts_can_be_fetched_for_the_authenticated_user()
    {
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $contact = factory(Contact::class)->create(['user_id' => $user->id]);
        $anotherContact = factory(Contact::class)->create(['user_id' => $anotherUser->id]);

        $response = $this->get("/api/contacts/?api_token={$user->api_token}");
        $firstContact = $user->contacts->first();
        // dd( json_decode($response->getContent()) );
        $response->assertJsonCount(1)->assertJson([
            'data' => [
                [
                    'data' => [
                        'contact_id'  => $firstContact->id,
                        'name'        => $firstContact->name,
                        'email'       => $firstContact->email,
                        'birthday'    => $firstContact->birthday->format('m/d/Y'),
                        'company'     => $firstContact->company,
                        'last_update' => $firstContact->updated_at->diffForHumans(),
                    ],
                    'links' => [
                        'self'=> "/contacts/{$firstContact->id}",
                    ]
                ]
            ]
        ]);


    }

    /** @test */
    public function an_authenticated_user_can_add_a_contact()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/api/contacts/', array_merge($this->data()));

        $contact = Contact::first();

        $this->assertEquals($this->data()['name'], $contact->name);
        $this->assertEquals($this->data()['email'], $contact->email);
        $this->assertEquals($this->data()['birthday'], $contact->birthday);
        $this->assertEquals($this->data()['company'], $contact->company);

        $response->assertStatus(Response::HTTP_CREATED );

        $response->assertJson([
            'data' => [
                'contact_id'  => $contact->id,
                'name'        => $contact->name,
                'email'       => $contact->email,
                'birthday'    => $contact->birthday->format('m/d/Y'),
                'company'     => $contact->company,
                'last_update' => $contact->updated_at->diffForHumans(),
            ],
            'links' => [
                'self'=> "/contacts/{$contact->id}",
            ]
        ]);
    }

    /** @test */
    public function fields_are_required()
    {
        collect(['name', 'email', 'birthday', 'company'])->each(function($field) {
            $response = $this->post('/api/contacts', array_merge($this->data(), [$field => '']));

            $response->assertSessionHasErrors($field);

            $this->assertCount(0, Contact::all());
        });

    }

    /** @test */
    public function email_must_be_a_valid_email()
    {
        $response = $this->post('/api/contacts', array_merge($this->data(), ['email' => 'THIS IS NOT AN EMAIL']));

        $response->assertSessionHasErrors('email');

        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function birthdays_are_properly_stored()
    {

        $response = $this->post('/api/contacts', $this->data());

        $this->assertCount(1, Contact::all());

        $this->assertInstanceOf(Carbon::class, $birthday = Contact::first()->birthday);

        $this->assertEquals('08-04-1989', $birthday->format('m-d-Y'));
    }

    /** @test */
    public function a_contact_can_be_retrieved()
    {
        $this->withoutExceptionHandling();

        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $response = $this->get("/api/contacts/{$contact->id}?api_token={$this->user->api_token}", $this->data());

        $response->assertJson([
            'data' => [
                'contact_id'  => $contact->id,
                'name'        => $contact->name,
                'email'       => $contact->email,
                'birthday'    => $contact->birthday->format('m/d/Y'),
                'company'     => $contact->company,
                'last_update' => $contact->updated_at->diffForHumans(),
            ]
        ]);
    }

    /** @test */
    public function only_the_user_contacts_can_be_retrieved()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $anotherUser = factory(User::class)->create();

        $response = $this->get("/api/contacts/{$contact->id}?api_token={$anotherUser->api_token}");

        $response->assertStatus(403);
    }

    /** @test */
    public function a_contact_can_be_patched()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $response = $this->patch("/api/contacts/{$contact->id}", $this->data());

        $contact = $contact->fresh();

        $this->assertEquals($this->data()['name'], $contact->name);
        $this->assertEquals($this->data()['email'], $contact->email);
        $this->assertEquals($this->data()['birthday'], $contact->birthday);
        $this->assertEquals($this->data()['company'], $contact->company);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'data' => [
                'contact_id'  => $contact->id,
            ],
            'links' => [
                'self'=> "/contacts/{$contact->id}",
            ]
        ]);
    }

    /** @test */
    public function only_the_owner_of_the_contac_can_patch_the_contact()
    {
        $contact = factory(Contact::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->patch("/api/contacts/{$contact->id}", array_merge($this->data(), ['api_token' => $anotherUser->api_token]));

        $response->assertStatus(403);
    }

    /** @test */
    public function a_contact_can_be_deleted()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $response = $this->delete("/api/contacts/{$contact->id}", ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Contact::all());

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function only_the_owner_can_delete_the_contact()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $anotherUser = factory(User::class)->create();

        $response = $this->delete("/api/contacts/{$contact->id}", ['api_token' => $anotherUser->api_token]);

        $this->assertCount(1, Contact::all());

        $response->assertStatus(403);
    }

    public function data()
    {
        return [
            'name'      => 'John Doe',
            'email'     => 'john@doe.com',
            'birthday'  => Carbon::parse('08/04/1989'),
            'company'   => 'ABS Company',
            'api_token' => $this->user->api_token,
            'user_id'   => $this->user->id
        ];
    }
}
