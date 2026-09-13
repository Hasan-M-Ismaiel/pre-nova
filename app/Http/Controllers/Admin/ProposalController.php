<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ProposalSentMail;

class ProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::latest()->get();

        return view('admin.proposals.index', compact('proposals'));
    }

    public function create()
    {
        return view('admin.proposals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['nullable', 'email', 'max:255'],
            'client_phone' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'scope' => ['nullable', 'string'],
            'terms' => ['nullable', 'string'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:draft,sent,approved,rejected'],
        ]);

        $validated['token'] = Str::random(64);

        $proposal = Proposal::create($validated);

        return redirect()
            ->route('admin.proposals.show', $proposal)
            ->with('success', 'Proposal created successfully.');
    }

    public function show(Proposal $proposal)
    {
        return view('admin.proposals.show', compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        return view('admin.proposals.edit', compact('proposal'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['nullable', 'email', 'max:255'],
            'client_phone' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'scope' => ['nullable', 'string'],
            'terms' => ['nullable', 'string'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:draft,sent,approved,rejected'],
        ]);

        $proposal->update($validated);

        return redirect()
            ->route('admin.proposals.show', $proposal)
            ->with('success', 'Proposal updated successfully.');
    }

    public function destroy(Proposal $proposal)
    {
        $proposal->delete();

        return redirect()
            ->route('admin.proposals.index')
            ->with('success', 'Proposal deleted successfully.');
    }


    public function send(Proposal $proposal)
    {
        if (!$proposal->client_email) {
            return back()->with(
                'error',
                'This proposal does not have a client email address.'
            );
        }

        if ($proposal->status === 'approved') {
            return back()->with(
                'error',
                'An approved proposal cannot be sent again.'
            );
        }

        if ($proposal->status === 'rejected') {
            return back()->with(
                'error',
                'A rejected proposal cannot be sent.'
            );
        }

        Mail::to($proposal->client_email)
            ->send(new ProposalSentMail($proposal));

        $proposal->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return redirect()
            ->route('admin.proposals.show', $proposal)
            ->with('success', 'Proposal sent successfully.');
    }
}
