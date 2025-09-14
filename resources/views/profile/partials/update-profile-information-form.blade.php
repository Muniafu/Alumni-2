<section class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <h2 class="h5 mb-0">Profile Information</h2>
        <p class="mb-0 small text-light opacity-75">
            Update your account's profile information and email address.
        </p>
    </div>

    <div class="card-body">
        {{-- Resend Verification Email --}}
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        {{-- Profile Update Form --}}
        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            {{-- Name --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="form-control @error('name') is-invalid @enderror"
                    required
                    autofocus
                    autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="form-control @error('email') is-invalid @enderror"
                    required
                    autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                {{-- Email Verification --}}
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="small text-muted">
                            Your email address is <span class="fw-bold text-danger">unverified</span>.
                            <button
                                form="send-verification"
                                class="btn btn-link btn-sm p-0 align-baseline text-decoration-underline">
                                Click here to re-send the verification email.
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success p-2 small mt-2 mb-0">
                                A new verification link has been sent to your email address.
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary px-4">
                    Save Changes
                </button>

                @if (session('status') === 'profile-updated')
                    <span class="text-success small fw-semibold" id="save-alert">Saved.</span>
                    <script>
                        setTimeout(() => document.getElementById('save-alert').style.display = 'none', 2000);
                    </script>
                @endif
            </div>
        </form>
    </div>
</section>
