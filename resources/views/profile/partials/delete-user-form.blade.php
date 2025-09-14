<section class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-danger text-white">
        <h2 class="h5 mb-0">Delete Account</h2>
        <p class="mb-0 small text-light opacity-75">
            Once your account is deleted, all of its resources and data will be permanently removed.
            Please download any data you wish to retain before proceeding.
        </p>
    </div>

    <div class="card-body">
        {{-- Trigger Delete Modal --}}
        <button type="button" class="btn btn-danger fw-semibold" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
            Delete Account
        </button>
    </div>
</section>

{{-- Confirm Delete Modal --}}
<div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmUserDeletionLabel">
                        Confirm Account Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="text-dark mb-3">
                        Are you sure you want to delete your account?
                        <span class="fw-bold text-danger">This action is permanent.</span>
                    </p>
                    <p class="text-muted small">
                        Please enter your password to confirm you would like to permanently delete your account.
                    </p>

                    {{-- Password Field --}}
                    <div class="mb-3">
                        <label for="delete_account_password" class="form-label fw-semibold">
                            Password
                        </label>
                        <input
                            type="password"
                            id="delete_account_password"
                            name="password"
                            placeholder="Enter your password"
                            class="form-control @error('password', 'userDeletion') is-invalid @enderror">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger fw-semibold">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
