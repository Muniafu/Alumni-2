@extends('layouts.app')

@section('header')
<h2 class="fw-semibold fs-4 text-dark">
    <i class="bi bi-person-lines-fill text-primary me-2"></i> {{ __('User Details') }}
</h2>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <img src="{{ $user->profile->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
                         class="rounded-circle me-3" width="60" height="60" alt="User Avatar">
                    <div>
                        <h5 class="fw-bold text-primary mb-1">
                            <i class="bi bi-person-circle me-2"></i> {{ $user->name }}
                        </h5>
                        <span class="badge {{ $user->is_approved ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $user->is_approved ? 'Approved' : 'Pending Approval' }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('admin.user-management') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Users
                </a>
            </div>

            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-3" id="userTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#basic" role="tab"><i class="bi bi-info-circle me-1"></i> Basic Info</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab"><i class="bi bi-person-badge me-1"></i> Profile</a></li>
                @if(in_array(optional($user->roles->first())->name, ['student','alumni']))
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#academic" role="tab"><i class="bi bi-mortarboard me-1"></i> Academic</a></li>
                @endif
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#activity" role="tab"><i class="bi bi-graph-up me-1"></i> Activity</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#permissions" role="tab"><i class="bi bi-shield-lock me-1"></i> Permissions</a></li>
            </ul>

            {{-- Tab Content --}}
            <div class="tab-content">
                {{-- Basic Info --}}
                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                        <li class="list-group-item"><strong>Role:</strong> {{ optional($user->roles->first())->name ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Registered:</strong> {{ $user->created_at->format('M d, Y h:i A') }}</li>
                        <li class="list-group-item"><strong>Last Login:</strong> {{ $user->last_login_at?->diffForHumans() ?? 'N/A' }}</li>
                    </ul>
                </div>

                {{-- Profile --}}
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    @if($user->profile)
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Current Job:</strong> {{ $user->profile->current_job ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Company:</strong> {{ $user->profile->company ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Skills:</strong>
                            {{ !empty($user->profile->skills) ? implode(', ', $user->profile->skills) : 'N/A' }}
                        </li>
                    </ul>
                    @else
                    <p class="text-muted">No profile information available.</p>
                    @endif
                </div>

                {{-- Academic Info --}}
                @if(in_array(optional($user->roles->first())->name, ['student','alumni']))
                <div class="tab-pane fade" id="academic" role="tabpanel">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Student ID:</strong> {{ $user->student_id ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Graduation Year:</strong> {{ $user->graduation_year ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Program:</strong> {{ $user->program ?? 'N/A' }}</li>
                    </ul>
                </div>
                @endif

                {{-- Activity --}}
                <div class="tab-pane fade" id="activity" role="tabpanel">
                    <div class="accordion" id="activityAccordion">

                        {{-- Events Attended --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingEvents">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEvents">
                                    <i class="bi bi-calendar-event me-2"></i> Events Attended ({{ $user->events->count() }})
                                </button>
                            </h2>
                            <div id="collapseEvents" class="accordion-collapse collapse" data-bs-parent="#activityAccordion">
                                <div class="accordion-body">
                                    @forelse($user->events as $event)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                <strong>{{ $event->title }}</strong>
                                                <small class="text-muted">({{ $event->date->format('M d, Y') }})</small>
                                            </span>
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </li>
                                    @empty
                                        <p class="text-muted mb-0">No events attended yet.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Jobs Applied --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingJobs">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseJobs">
                                    <i class="bi bi-briefcase me-2"></i> Job Applications ({{ $user->jobApplications->count() }})
                                </button>
                            </h2>
                            <div id="collapseJobs" class="accordion-collapse collapse" data-bs-parent="#activityAccordion">
                                <div class="accordion-body">
                                    @forelse($user->jobApplications as $application)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                <strong>{{ $application->jobPosting->title }}</strong>
                                                <small class="text-muted">Applied: {{ $application->created_at->format('M d, Y') }}</small>
                                            </span>
                                            <a href="{{ route('jobs.show', $application->jobPosting) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </li>
                                    @empty
                                        <p class="text-muted mb-0">No job applications yet.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Forum Posts --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingPosts">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePosts">
                                    <i class="bi bi-chat-dots me-2"></i> Forum Posts ({{ $user->forumPosts->count() }})
                                </button>
                            </h2>
                            <div id="collapsePosts" class="accordion-collapse collapse" data-bs-parent="#activityAccordion">
                                <div class="accordion-body">
                                    @forelse($user->forumPosts as $post)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                <strong>{{ Str::limit($post->content, 50) }}</strong>
                                                <small class="text-muted">in {{ $post->thread->title ?? 'Unknown Thread' }}</small>
                                            </span>
                                            <a href="{{ route('forum.thread', $post->thread) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </li>
                                    @empty
                                        <p class="text-muted mb-0">No forum posts yet.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Permissions --}}
                <div class="tab-pane fade" id="permissions" role="tabpanel">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <h6 class="fw-semibold text-dark mb-3">Manage Permissions</h6>

                            <form action="{{ route('admin.permissions', $user) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Permission</th>
                                            <th class="text-center">Assigned</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $permission)
                                        <tr>
                                            <td>{{ ucfirst($permission->name) }}</td>
                                            <td class="text-center">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                    {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i> Update Permissions
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="d-flex justify-content-end mt-4 gap-2">
                <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
                <form action="{{ route('admin.user.delete', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
