<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $q = QuoteRequest::query()->latest();
        if ($status = $request->query('status')) {
            $q->where('status', $status);
        }
        return view('admin.quotes.index', ['quotes' => $q->paginate(20)->withQueryString()]);
    }

    public function show(QuoteRequest $quote)
    {
        return view('admin.quotes.show', compact('quote'));
    }

    public function update(Request $request, QuoteRequest $quote)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(QuoteRequest::STATUSES))],
            'admin_notes' => 'nullable|string|max:5000',
        ]);
        $quote->update($data);
        return back()->with('success', 'Quote request updated.');
    }

    public function destroy(QuoteRequest $quote)
    {
        $quote->delete();
        return redirect()->route('admin.quotes.index')->with('success', 'Quote request deleted.');
    }
}
