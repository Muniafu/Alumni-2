<x-layout>
    <x-slot name="title">Mentorship Requests</x-slot>

    <div class="container py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>Mentorship Requests</h4>
                    </div>

                    <div class="card-body">
                        <ul class="nav nav-tabs" id="requestsTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="received-tab" data-toggle="tab" href="#received" role="tab">
                                    Received Requests
                                    @if($receivedRequests->count() > 0)
                                        <span class="badge badge-primary">{{ $receivedRequests->count() }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="sent-tab" data-toggle="tab" href="#sent" role="tab">
                                    Sent Requests
                                    @if($sentRequests->count() > 0)
                                        <span class="badge badge-info">{{ $sentRequests->count() }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content py-3" id="requestsTabContent">
                            <div class="tab-pane fade show active" id="received" role="tabpanel">
                                @if($receivedRequests->isEmpty())
                                    <div class="alert alert-info">You have no received mentorship requests.</div>
                                @else
                                    @foreach($receivedRequests as $request)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <h5>Request from {{ $request->mentee->name }}</h5>
                                                    <span class="badge badge-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'accepted' ? 'success' : 'danger') }}">
                                                        {{ ucfirst($request->status) }}
                                                    </span>
                                                </div>

                                                <p class="text-muted">Goal: {{ $request->goal }}</p>
                                                <p>{{ $request->message }}</p>

                                                @if($request->status === 'pending')
                                                    <form action="{{ route('mentorship.respond-request', $request) }}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="response-message-{{ $request->id }}">Response Message (Optional)</label>
                                                            <textarea class="form-control" id="response-message-{{ $request->id }}"
                                                                      name="message" rows="2"></textarea>
                                                        </div>
                                                        <button type="submit" name="response" value="accept"
                                                                class="btn btn-success btn-sm">Accept</button>
                                                        <button type="submit" name="response" value="reject"
                                                                class="btn btn-danger btn-sm">Reject</button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="card-footer text-muted">
                                                Requested {{ $request->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    @endforeach
                                    {{ $receivedRequests->links() }}
                                @endif
                            </div>

                            <div class="tab-pane fade" id="sent" role="tabpanel">
                                @if($sentRequests->isEmpty())
                                    <div class="alert alert-info">You have no sent mentorship requests.</div>
                                @else
                                    @foreach($sentRequests as $request)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <h5>Request to {{ $request->mentor->name }}</h5>
                                                    <span class="badge badge-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'accepted' ? 'success' : 'danger') }}">
                                                        {{ ucfirst($request->status) }}
                                                    </span>
                                                </div>

                                                <p class="text-muted">Goal: {{ $request->goal }}</p>
                                                <p>{{ $request->message }}</p>

                                                @if($request->status === 'rejected' && $request->message)
                                                    <div class="alert alert-light">
                                                        <strong>Mentor's Response:</strong> {{ $request->message }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="card-footer text-muted">
                                                Sent {{ $request->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    @endforeach
                                    {{ $sentRequests->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
