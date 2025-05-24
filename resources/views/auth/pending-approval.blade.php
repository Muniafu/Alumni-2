<x-guest-layout>
    <div class="card">
        <div class="card-body">
            <div class="mb-4 text-center">
                <h2 class="text-2xl font-bold text-gray-800">Account Pending Approval</h2>
                <p class="mt-2 text-gray-600">
                    Your account is currently under review by our administrators.
                    You'll receive access to the system once your account is approved.
                </p>
            </div>

            <div class="mt-4 text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="btn btn-primary">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
