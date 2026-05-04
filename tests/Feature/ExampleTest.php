<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
<<<<<<< HEAD
        $this->assertTrue(true);
=======
        $response = $this->get('/');

        $response->assertStatus(200);
>>>>>>> fb4e66edda25b343721dad90c6012d741003189d
    }
}
