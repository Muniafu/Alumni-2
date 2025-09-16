@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-primary mb-4">Sign Up as a Mentor</h2>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('mentorship.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="expertise" class="form-label">Your Expertise</label>
                    <input type="text" class="form-control" id="expertise" name="expertise" required>
                </div>
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio / Experience</label>
                    <textarea class="form-control" id="bio" name="bio" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
        </div>
    </div>
</div>
@endsection
