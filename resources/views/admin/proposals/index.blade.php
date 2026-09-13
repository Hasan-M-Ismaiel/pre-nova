@extends('layouts.app')

@section('content')

<div class="container mt-5 mb-3">

    <div class="bg-light rounded p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">Proposals</h5>

            <a href="{{ route('admin.proposals.create') }}"
               class="btn btn-primary">
                + Create Proposal
            </a>
        </div>

        @if($proposals->count())

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($proposals as $proposal)

                            <tr>

                                <td>
                                    {{ $proposal->id }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $proposal->title }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $proposal->client_name }}
                                </td>

                                <td>
                                    @if($proposal->amount !== null)
                                        {{ number_format($proposal->amount, 2) }}
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>

                                    @if($proposal->status === 'draft')
                                        <span class="badge bg-secondary">
                                            Draft
                                        </span>

                                    @elseif($proposal->status === 'sent')
                                        <span class="badge bg-info">
                                            Sent
                                        </span>

                                    @elseif($proposal->status === 'approved')
                                        <span class="badge bg-success">
                                            Approved
                                        </span>

                                    @elseif($proposal->status === 'rejected')
                                        <span class="badge bg-danger">
                                            Rejected
                                        </span>
                                    @endif

                                </td>

                                <td>
                                    {{ $proposal->created_at->format('Y-m-d') }}
                                </td>

                                <td class="text-end">

                                    <a href="{{ route('admin.proposals.show', $proposal) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>

                                    <a href="{{ route('admin.proposals.edit', $proposal) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.proposals.destroy', $proposal) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this proposal?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-5">

                <h6 class="text-muted">
                    No proposals yet.
                </h6>

                <a href="{{ route('admin.proposals.create') }}"
                   class="btn btn-primary mt-3">
                    Create Your First Proposal
                </a>

            </div>

        @endif

    </div>

</div>

@endsection