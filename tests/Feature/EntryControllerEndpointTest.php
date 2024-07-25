<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Symfony\Component\String\u;

class EntryControllerEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function get_entries_test()
    {
        $response = $this->get('/api/entries?page=1&page_size=3');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function add_new_entry_with_same_user()
    {
        $userName = 'test_user_' . now()->timestamp;
        $postData = [
            'username' => $userName,
            'subject' => 'Test subject',
            'message' => 'Test message. This is long message',
        ];
        $response = $this->post('/api/entries', $postData);
        $response->assertStatus(200);

        $postData['subject'] = 'This is new subject from same user test';
        $newResponse = $this->post('/api/entries', $postData);
        $newResponse->assertStatus(200);

        $user = \App\Models\User::whereUsername($userName)->first();
        $this->assertSame($user->last_entry, $postData['subject'] . ' | ' . $postData['message'], 'Ok');
    }

    /**
     * @test
     */
    public function add_new_entry_with_different_user()
    {
        // first user
        $firstUser = 'test_user_' . now()->timestamp;
        $postData = [
            'username' => $firstUser,
            'subject' => 'Test first user\'s subject',
            'message' => 'Test first users\'s message. This is long message.',
        ];
        $response = $this->post('/api/entries', $postData);
        $response->assertStatus(200);
        sleep(1);
        // second user
        $secondUser = 'test_user_' . now()->timestamp;
        $postData = [
            'username' => $secondUser,
            'subject' => 'Test second user\'s subject',
            'message' => 'Test second users\'s message. This is long message.',
        ];
        $response = $this->post('/api/entries', $postData);
        $response->assertStatus(200);

        $this->assertNotSame($firstUser, $secondUser);
    }
}
