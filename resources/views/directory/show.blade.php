<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Profile: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                            <p class="text-gray-600">{{ $user->program }} • Class of {{ $user->graduation_year }}</p>
                            <div class="mt-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                    {{ $user->roles->first()->name }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('conversations.create', ['recipients' => [$user->id]]) }}" class="btn btn-primary">
                                Send Message
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="md:col-span-2">
                            @if($user->profile)
                                @if($user->profile->bio)
                                <div class="mb-6">
                                    <h3 class="font-medium text-lg mb-2">About</h3>
                                    <div class="prose max-w-none">
                                        {!! nl2br(e($user->profile->bio)) !!}
                                    </div>
                                </div>
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if($user->profile->current_job || $user->profile->company)
                                    <div>
                                        <h3 class="font-medium text-lg mb-2">Professional</h3>
                                        <div class="space-y-2">
                                            @if($user->profile->current_job)
                                            <div>
                                                <span class="text-gray-500 block text-sm">Current Job</span>
                                                <span class="font-medium">{{ $user->profile->current_job }}</span>
                                            </div>
                                            @endif
                                            @if($user->profile->company)
                                            <div>
                                                <span class="text-gray-500 block text-sm">Company</span>
                                                <span class="font-medium">{{ $user->profile->company }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif

                                    @if($user->profile->skills || $user->profile->interests)
                                    <div>
                                        <h3 class="font-medium text-lg mb-2">Skills & Interests</h3>
                                        <div class="space-y-2">
                                            @if($user->profile->skills)
                                            <div>
                                                <span class="text-gray-500 block text-sm">Skills</span>
                                                <div class="flex flex-wrap gap-2 mt-1">
                                                    @foreach($user->profile->skills as $skill)
                                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-sm rounded">{{ $skill }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                            @if($user->profile->interests)
                                            <div>
                                                <span class="text-gray-500 block text-sm">Interests</span>
                                                <div class="flex flex-wrap gap-2 mt-1">
                                                    @foreach($user->profile->interests as $interest)
                                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-sm rounded">{{ $interest }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-gray-500">No profile information available.</p>
                            @endif
                        </div>

                        <div>
                            <div class="bg-gray-50 p-4 rounded-lg sticky top-4">
                                <h3 class="font-medium text-lg mb-3">Contact Information</h3>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-gray-500 block text-sm">Email</span>
                                        <a href="mailto:{{ $user->email }}" class="font-medium text-blue-600">{{ $user->email }}</a>
                                    </div>
                                    @if($user->profile && $user->profile->phone)
                                    <div>
                                        <span class="text-gray-500 block text-sm">Phone</span>
                                        <span class="font-medium">{{ $user->profile->phone }}</span>
                                    </div>
                                    @endif
                                    @if($user->profile && $user->profile->address)
                                    <div>
                                        <span class="text-gray-500 block text-sm">Address</span>
                                        <span class="font-medium">{{ $user->profile->address }}</span>
                                    </div>
                                    @endif
                                </div>

                                @if($user->profile && $user->profile->social_links)
                                <div class="mt-4 pt-4 border-t">
                                    <h3 class="font-medium text-lg mb-3">Social Links</h3>
                                    <div class="space-y-2">
                                        @foreach($user->profile->social_links as $platform => $url)
                                            @if($url)
                                            <div>
                                                <span class="text-gray-500 block text-sm capitalize">{{ $platform }}</span>
                                                <a href="{{ $url }}" target="_blank" class="font-medium text-blue-600">{{ $url }}</a>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
