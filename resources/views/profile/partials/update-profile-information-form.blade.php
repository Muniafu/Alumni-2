<section class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <h2 class="h5 mb-0">Profile Information</h2>
        <p class="mb-0 small text-light opacity-75">
            Update your account's profile information and details.
        </p>
    </div>

    <div class="card-body">

        {{-- Basic User Info --}}
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            {{-- Name --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Name</label>
                <input type="text" id="name" name="name"
                    value="{{ old('name', $user->name) }}"
                    class="form-control @error('name') is-invalid @enderror"
                    required autofocus autocomplete="name">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" id="email" name="email"
                    value="{{ old('email', $user->email) }}"
                    class="form-control @error('email') is-invalid @enderror"
                    required autocomplete="username">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Actions --}}
            <div class="d-flex align-items-center gap-3 mb-4">
                <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                @if (session('status') === 'profile-updated')
                    <span class="text-success small fw-semibold" id="save-alert">Saved.</span>
                    <script>
                        setTimeout(() => document.getElementById('save-alert').style.display = 'none', 2000);
                    </script>
                @endif
            </div>
        </form>

        {{-- Extended Profile Info --}}
        <form method="POST" action="{{ route('profile.details.update') }}">
            @csrf
            @method('PUT')

            {{-- Phone --}}
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" id="phone" name="phone"
                    value="{{ old('phone', $profile->phone) }}"
                    class="form-control @error('phone') is-invalid @enderror">
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Address --}}
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" id="address" name="address"
                    value="{{ old('address', $profile->address) }}"
                    class="form-control @error('address') is-invalid @enderror">
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Current Job --}}
            <div class="mb-3">
                <label for="current_job" class="form-label">Current Job</label>
                <input type="text" id="current_job" name="current_job"
                    value="{{ old('current_job', $profile->current_job) }}"
                    class="form-control @error('current_job') is-invalid @enderror">
                @error('current_job') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Company --}}
            <div class="mb-3">
                <label for="company" class="form-label">Company</label>
                <input type="text" id="company" name="company"
                    value="{{ old('company', $profile->company) }}"
                    class="form-control @error('company') is-invalid @enderror">
                @error('company') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Bio --}}
            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea id="bio" name="bio"
                    class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $profile->bio) }}</textarea>
                @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Skills --}}
            <div class="mb-3">
                <label for="skills" class="form-label">Skills (comma-separated)</label>
                <input type="text" id="skills" name="skills"
                    value="{{ old('skills', implode(',', $profile->skillsArray)) }}"
                    class="form-control @error('skills') is-invalid @enderror">
                @error('skills') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Interests --}}
            <div class="mb-3">
                <label for="interests" class="form-label">Interests (comma-separated)</label>
                <input type="text" id="interests" name="interests"
                    value="{{ old('interests', implode(',', $profile->interestsArray)) }}"
                    class="form-control @error('interests') is-invalid @enderror">
                @error('interests') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Social Links --}}
            <div class="mb-3">
                <label class="form-label">Social Links (linkedin, twitter, github, website)</label>
                <input type="text" name="social_links"
                    value="{{ old('social_links', implode(',', $profile->socialLinksArray)) }}"
                    class="form-control @error('social_links') is-invalid @enderror">
                @error('social_links') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Actions --}}
            <button type="submit" class="btn btn-success px-4">Update Details</button>
            @if (session('status') === 'profile-details-updated')
                <span class="text-success small fw-semibold" id="save-alert">Saved.</span>
                <script>
                    setTimeout(() => document.getElementById('save-alert').style.display = 'none', 2000);
                </script>
            @endif
        </form>
    </div>
</section>
