<section class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-warning text-dark">
        <h2 class="h5 mb-0">Update Password</h2>
        <p class="mb-0 small text-dark opacity-75">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            {{-- Current Password --}}
            <div class="mb-3">
                <label for="update_password_current_password" class="form-label fw-semibold">
                    Current Password
                </label>
                <input
                    type="password"
                    id="update_password_current_password"
                    name="current_password"
                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                    autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="mb-3">
                <label for="update_password_password" class="form-label fw-semibold">
                    New Password
                </label>
                <input
                    type="password"
                    id="update_password_password"
                    name="password"
                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                    autocomplete="new-password">
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label fw-semibold">
                    Confirm Password
                </label>
                <input
                    type="password"
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                    autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-warning px-4 fw-semibold">
                    Save Changes
                </button>

                @if (session('status') === 'password-updated')
                    <span class="text-success small fw-semibold" id="password-save-alert">Saved.</span>
                    <script>
                        setTimeout(() => {
                            const alert = document.getElementById('password-save-alert');
                            if(alert) alert.style.display = 'none';
                        }, 2000);
                    </script>
                @endif
            </div>
        </form>
    </div>
</section>
