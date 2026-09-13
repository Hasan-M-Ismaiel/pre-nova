<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        {{ $proposal->title }} • novALight
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background: #f7f7f8;
            color: #222;
        }

        .proposal-wrapper {
            max-width: 1000px;
            margin: 60px auto;
        }

        .proposal-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        }

        .proposal-header {
            padding: 40px;
            border-bottom: 1px solid #eee;
        }

        .proposal-body {
            padding: 40px;
        }

        .proposal-section {
            margin-bottom: 40px;
        }

        .proposal-section h5 {
            margin-bottom: 15px;
            font-weight: 600;
        }

        .proposal-content {
            white-space: normal;
            line-height: 1.8;
            color: #555;
        }

        .amount-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-draft {
            background: #e9ecef;
            color: #495057;
        }

        .status-sent {
            background: #cff4fc;
            color: #055160;
        }

        .status-approved {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-rejected {
            background: #f8d7da;
            color: #842029;
        }

        .brand {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .actions {
            border-top: 1px solid #eee;
            padding-top: 30px;
        }
    </style>

</head>


<body>

    <div class="container">

        <div class="proposal-wrapper">

            {{-- Brand --}}
            <div class="text-center mb-4">

                <div class="brand">
                    novALight
                </div>

                <small class="text-muted">
                    Proposal
                </small>

            </div>


            {{-- Alerts --}}

            @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

            @endif


            @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

            @endif


            @if(session('info'))

            <div class="alert alert-info">
                {{ session('info') }}
            </div>

            @endif


            {{-- Proposal --}}

            <div class="proposal-card">


                {{-- Header --}}

                <div class="proposal-header">

                    <div class="d-flex justify-content-between align-items-start gap-3">

                        <div>

                            <h1 class="mb-2">
                                {{ $proposal->title }}
                            </h1>

                            <p class="text-muted mb-0">

                                Prepared for
                                <strong>
                                    {{ $proposal->client_name }}
                                </strong>

                            </p>

                        </div>


                        @php

                        $statusClass = match($proposal->status) {

                        'draft' => 'status-draft',

                        'sent' => 'status-sent',

                        'approved' => 'status-approved',

                        'rejected' => 'status-rejected',

                        default => 'status-draft',

                        };

                        @endphp


                        <span class="status-badge {{ $statusClass }}">

                            {{ ucfirst($proposal->status) }}

                        </span>

                    </div>

                </div>


                {{-- Body --}}

                <div class="proposal-body">


                    {{-- Description --}}

                    @if($proposal->description)

                    <div class="proposal-section">

                        <h5>
                            Overview
                        </h5>

                        <div class="proposal-content">

                            {!! nl2br(e($proposal->description)) !!}

                        </div>

                    </div>

                    @endif


                    {{-- Scope --}}

                    @if($proposal->scope)

                    <div class="proposal-section">

                        <h5>
                            Scope of Work
                        </h5>

                        <div class="proposal-content">

                            {!! nl2br(e($proposal->scope)) !!}

                        </div>

                    </div>

                    @endif


                    {{-- Terms --}}

                    @if($proposal->terms)

                    <div class="proposal-section">

                        <h5>
                            Terms & Conditions
                        </h5>

                        <div class="proposal-content">

                            {!! nl2br(e($proposal->terms)) !!}

                        </div>

                    </div>

                    @endif


                    {{-- Amount --}}

                    @if($proposal->amount !== null)

                    <div class="proposal-section">

                        <div class="amount-box">

                            <div class="text-muted mb-1">
                                Total Proposal Value
                            </div>

                            <h2 class="mb-0">
                                ${{ number_format($proposal->amount, 2) }}
                            </h2>

                        </div>

                    </div>

                    @endif


                    {{-- Actions --}}

                    @if($proposal->status === 'sent')

                    <div class="mt-4 d-flex gap-2">

                        <form
                            action="{{ route('proposals.public.approve', $proposal->token) }}"
                            method="POST">
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-success"
                                onclick="return confirm('Are you sure you want to approve this proposal?')">
                                <i class="fa fa-check me-1"></i>
                                Approve Proposal
                            </button>
                        </form>

                        <form
                            action="{{ route('proposals.public.reject', $proposal->token) }}"
                            method="POST">
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-outline-danger"
                                onclick="return confirm('Are you sure you want to reject this proposal?')">
                                <i class="fa fa-times me-1"></i>
                                Reject Proposal
                            </button>
                        </form>

                    </div>

                    @elseif($proposal->status === 'draft')

                    <div class="alert alert-secondary mt-4">
                        This proposal is not available for review yet.
                    </div>

                    @elseif($proposal->status === 'approved')

                    <div class="alert alert-success mt-4">
                        <i class="fa fa-check-circle me-1"></i>
                        This proposal has been approved.
                        @if($proposal->approved_at)

                        <div class="small mt-2">

                            On
                            {{ $proposal->approved_at->format('M d, Y H:i') }}

                        </div>

                        @endif
                    </div>

                    @elseif($proposal->status === 'rejected')

                    <div class="alert alert-danger mt-4">
                        <i class="fa fa-times-circle me-1"></i>
                        This proposal has been rejected.
                    </div>

                    @endif


                </div>

            </div>


            {{-- Footer --}}

            <div class="text-center mt-4">

                <small class="text-muted">

                    Powered by
                    <strong>novALight</strong>

                </small>

            </div>

        </div>

    </div>

</body>

</html>