<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use App\Mail\ProposalSentMail;
use Illuminate\Support\Facades\Mail;

class ProposalController extends Controller
{
    public function show(string $token)
    {
        $proposal = Proposal::where('token', $token)->firstOrFail();

        return view('proposals.public', compact('proposal'));
    }

    public function approve(Request $request, string $token)
    {
        $proposal = Proposal::where('token', $token)->firstOrFail();

        if ($proposal->status === 'draft') {
            return back()->with(
                'error',
                'This proposal is not available for approval yet.'
            );
        }

        if ($proposal->status === 'approved') {
            return back()->with(
                'info',
                'This proposal has already been approved.'
            );
        }

        if ($proposal->status === 'rejected') {
            return back()->with(
                'error',
                'This proposal has already been rejected.'
            );
        }

        if ($proposal->status !== 'sent') {
            return back()->with(
                'error',
                'This proposal cannot be approved in its current status.'
            );
        }

        $proposal->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with(
            'success',
            'Thank you. The proposal has been approved successfully.'
        );
    }

    public function reject(Request $request, string $token)
    {
        $proposal = Proposal::where('token', $token)->firstOrFail();

        if ($proposal->status === 'draft') {
            return back()->with(
                'error',
                'This proposal is not available for rejection yet.'
            );
        }

        if ($proposal->status === 'approved') {
            return back()->with(
                'info',
                'This proposal has already been approved.'
            );
        }

        if ($proposal->status === 'rejected') {
            return back()->with(
                'info',
                'This proposal has already been rejected.'
            );
        }

        if ($proposal->status !== 'sent') {
            return back()->with(
                'error',
                'This proposal cannot be rejected in its current status.'
            );
        }

        $proposal->update([
            'status' => 'rejected',
        ]);

        return back()->with(
            'success',
            'The proposal has been rejected.'
        );
    }
}
