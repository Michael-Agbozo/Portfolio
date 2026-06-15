<?php

namespace Tests\Feature;

use App\Mail\ContactMessageConfirmation;
use App\Mail\ContactMessageReceived;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    public function test_contact_form_stores_a_message(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
            'message' => 'Hi, I would like to discuss a project with you.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('messages', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
        ]);
    }

    public function test_contact_form_sends_a_copy_to_the_reply_inbox(): void
    {
        Mail::fake();

        $this->post('/contact', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
            'message' => 'Hi, I would like to discuss a project with you.',
        ]);

        Mail::assertSent(ContactMessageReceived::class, function (ContactMessageReceived $mail) {
            return $mail->hasTo('michaelsogagbozo@gmail.com')
                && $mail->contactMessage->email === 'jane@example.com'
                && $mail->contactMessage->subject === 'Project enquiry';
        });
    }

    public function test_contact_form_sends_a_confirmation_to_the_visitor(): void
    {
        Mail::fake();

        $this->post('/contact', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
            'message' => 'Hi, I would like to discuss a project with you.',
        ]);

        Mail::assertSent(ContactMessageConfirmation::class, function (ContactMessageConfirmation $mail) {
            return $mail->hasTo('jane@example.com')
                && $mail->contactMessage->name === 'Jane Visitor'
                && $mail->contactMessage->subject === 'Project enquiry';
        });
    }

    public function test_contact_form_still_succeeds_if_email_delivery_fails(): void
    {
        Mail::shouldReceive('to')->once()->andThrow(new RuntimeException('SMTP is unavailable.'));

        $response = $this->post('/contact', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
            'message' => 'Hi, I would like to discuss a project with you.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('messages', [
            'email' => 'jane@example.com',
            'subject' => 'Project enquiry',
        ]);
    }

    public function test_contact_form_rejects_invalid_input(): void
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'subject' => '',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
        $this->assertDatabaseCount('messages', 0);
    }
}
