<?php

namespace Tests\Feature;

use App\Mail\InquiryReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_contact_submission_redirects_to_home_top_with_status(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.send'), [
            'type' => 'general',
            'name' => 'Taylor',
            'email' => 'taylor@example.com',
            'message' => 'Hello there',
            'website' => '',
        ]);

        $response
            ->assertRedirect(route('home'))
            ->assertSessionHas('status', 'Thanks! Your message was sent.');

        Mail::assertSent(InquiryReceived::class);
    }

    public function test_invalid_contact_submission_redirects_back_to_contact_section(): void
    {
        $response = $this->from(route('home').'#contact')->post(route('contact.send'), [
            'type' => 'general',
            'name' => 'Taylor',
            'email' => '',
            'message' => '',
            'website' => '',
        ]);

        $response->assertRedirect(route('home').'#contact');
        $response->assertSessionHasErrors(['email', 'message']);
    }
}
