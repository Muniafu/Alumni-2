@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-semibold text-primary mb-0">
        <i class="fa-solid fa-pen-to-square me-2"></i> Edit Event
    </h2>
</div>
@endsection

@section('content')
<div class="row justify-content-center my-4">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-medium">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $event->title) }}" required autofocus>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Start Date/Time -->
                        <div class="col-md-6">
                            <label for="start" class="form-label fw-medium">Start Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" id="start" name="start"
                                   class="form-control @error('start') is-invalid @enderror"
                                   value="{{ old('start', $event->start->format('Y-m-d\TH:i')) }}" required>
                            @error('start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- End Date/Time -->
                        <div class="col-md-6">
                            <label for="end" class="form-label fw-medium">End Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" id="end" name="end"
                                   class="form-control @error('end') is-invalid @enderror"
                                   value="{{ old('end', $event->end->format('Y-m-d\TH:i')) }}" required>
                            @error('end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="col-md-6">
                            <label for="location" class="form-label fw-medium">Location</label>
                            <input type="text" id="location" name="location"
                                   class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location', $event->location) }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Capacity -->
                        <div class="col-md-6">
                            <label for="capacity" class="form-label fw-medium">Capacity (leave blank for unlimited)</label>
                            <input type="number" id="capacity" name="capacity" min="1"
                                   class="form-control @error('capacity') is-invalid @enderror"
                                   value="{{ old('capacity', $event->capacity) }}">
                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="col-md-6">
                            <label for="image" class="form-label fw-medium">Event Image</label>
                            @if($event->image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($event->image) }}"
                                         alt="Current event image"
                                         class="img-thumbnail shadow-sm" style="max-height: 120px;">
                                </div>
                            @endif
                            <input type="file" id="image" name="image"
                                   class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Online Event Checkbox -->
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" id="is_online" name="is_online"
                                       class="form-check-input"
                                       {{ old('is_online', $event->is_online) ? 'checked' : '' }}>
                                <label for="is_online" class="form-check-label">This is an online event</label>
                            </div>
                        </div>

                        <!-- Meeting URL -->
                        <div class="col-12" id="meeting_url_container" style="{{ $event->is_online ? '' : 'display:none;' }}">
                            <label for="meeting_url" class="form-label fw-medium">Meeting URL</label>
                            <input type="url" id="meeting_url" name="meeting_url"
                                   class="form-control @error('meeting_url') is-invalid @enderror"
                                   value="{{ old('meeting_url', $event->meeting_url) }}">
                            @error('meeting_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label for="description" class="form-label fw-medium">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fa-solid fa-save me-2"></i> Update Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('is_online');
        const meetingUrlContainer = document.getElementById('meeting_url_container');

        function toggleMeetingUrl() {
            meetingUrlContainer.style.display = checkbox.checked ? 'block' : 'none';
        }

        checkbox.addEventListener('change', toggleMeetingUrl);
        toggleMeetingUrl(); // init
    });
</script>
@endpush
