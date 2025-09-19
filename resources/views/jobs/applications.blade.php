@extends('layouts.app')

@section('header')
<div class="d-flex align-items-center justify-content-between">
    <h2 class="fw-semibold text-primary mb-0">
        <i class="fa-solid fa-clipboard-list me-2"></i> Applications for: {{ $job->title }}
    </h2>
</div>
@endsection

@section('content')
<div class="row py-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                @if($applications->isEmpty())
                    <p class="text-secondary">No applications received yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Applicant</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Applied</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                <tr>
                                    <!-- Applicant Info -->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $application->applicant->profile_photo_url }}" alt="{{ $application->applicant->name }}" class="rounded-circle me-3" width="40" height="40">
                                            <div>
                                                <div class="fw-medium text-dark">{{ $application->applicant->name }}</div>
                                                <small class="text-muted">{{ $application->applicant->email }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Status Badge -->
                                    <td>
                                        @php
                                            $statusClass = match($application->status) {
                                                'submitted' => 'badge bg-primary',
                                                'reviewed' => 'badge bg-warning text-dark',
                                                'interviewed' => 'badge bg-info text-dark',
                                                'hired' => 'badge bg-success',
                                                'rejected' => 'badge bg-danger',
                                                default => 'badge bg-secondary',
                                            };
                                        @endphp
                                        <span class="{{ $statusClass }}">{{ ucfirst($application->status) }}</span>
                                    </td>

                                    <!-- Applied Date -->
                                    <td>
                                        <small class="text-muted">{{ $application->created_at->diffForHumans() }}</small>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <a href="{{ route('applications.show', $application) }}" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fa-solid fa-eye me-1"></i> View
                                        </a>
                                        <td>
                                            @can('view', $application)
                                                <a href="{{ route('resume.download', $application->resume_path) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fa-solid fa-download me-1"></i> Resume
                                                </a>
                                            @else
                                                <span class="text-muted">No access</span>
                                            @endcan
                                        </td>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
