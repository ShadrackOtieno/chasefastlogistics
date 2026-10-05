<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:160',
            'phone' => 'nullable|string|max:40',
            'subject' => 'required|string|max:160',
            'message' => 'required|string|max:4000',
            'website' => 'max:0', // honeypot
        ]);
        unset($data['website']);

        $msg = ContactMessage::create($data);

        if ($to = Setting::get('notify_email')) {
            try {
                Mail::raw("From: {$msg->name} <{$msg->email}> {$msg->phone}\n\n{$msg->message}", fn ($m) => $m->to($to)->replyTo($msg->email)->subject("Website message: {$msg->subject}"));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return redirect()->route('contact')->with('success', 'Thank you. Your message has been received and we will get back to you shortly.');
    }
}
