<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class QuoteRequestController extends Controller
{
    public function create(Request $request)
    {
        return view('site.quote', ['selected' => $request->query('service')]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'company' => 'nullable|string|max:160',
            'email' => 'required|email|max:160',
            'phone' => 'required|string|max:40',
            'service_type' => 'required|in:'.implode(',', QuoteRequest::SERVICE_TYPES),
            'origin' => 'required|string|max:160',
            'destination' => 'required|string|max:160',
            'cargo_description' => 'required|string|max:2000',
            'weight' => 'nullable|string|max:60',
            'container_type' => 'nullable|string|max:60',
            'message' => 'nullable|string|max:3000',
            'website' => 'max:0', // honeypot: real people leave this empty
        ]);
        unset($data['website']);

        $data['reference'] = 'QT-'.date('ymd').'-'.strtoupper(Str::random(4));
        $quote = QuoteRequest::create($data);

        $this->notify("New quote request {$quote->reference}", "From: {$quote->name} ({$quote->company})\nEmail: {$quote->email}\nPhone: {$quote->phone}\nService: {$quote->service_type}\nRoute: {$quote->origin} -> {$quote->destination}\nCargo: {$quote->cargo_description}\nWeight: {$quote->weight}\nContainer: {$quote->container_type}\n\n{$quote->message}\n\nView: ".route('admin.quotes.show', $quote));

        return redirect()->route('quote.create')->with('quote_ref', $quote->reference);
    }

    private function notify(string $subject, string $body): void
    {
        $to = Setting::get('notify_email');
        if (! $to) {
            return;
        }
        try {
            Mail::raw($body, fn ($m) => $m->to($to)->subject($subject));
        } catch (\Throwable $e) {
            report($e); // never lose the enquiry because mail failed: it is already saved
        }
    }
}
