<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Alumni & Student Directory
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('directory.index') }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="form-input rounded-md shadow-sm w-full" placeholder="Name, email, skills, etc.">
                            </div>
                            <div>
                                <label for="graduation_year" class="block text-sm font-medium text-gray-700 mb-1">Graduation Year</label>
                                <select name="graduation_year" id="graduation_year" class="form-select rounded-md shadow-sm w-full">
                                    <option value="">All Years</option>
                                    @foreach($graduationYears as $year)
                                        <option value="{{ $year }}" {{ request('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="program" class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                                <select name="program" id="program" class="form-select rounded-md shadow-sm w-full">
                                    <option value="">All Programs</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program }}" {{ request('program') == $program ? 'selected' : '' }}>{{ $program }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select name="role" id="role" class="form-select rounded-md shadow-sm w-full">
                                    <option value="">All Roles</option>
                                    <option value="alumni" {{ request('role') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                                    <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Students</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end space-x-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('directory.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>

                    @if($users->isEmpty())
                        <p class="text-gray-500">No users found matching your criteria.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($users as $user)
                                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                    <div class="p-6">
                                        <div class="flex items-center space-x-4 mb-4">
                                            <div class="flex-shrink-0 h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500 text-xl">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-lg">
                                                    <a href="{{ route('directory.show', $user) }}" class="hover:text-blue-600">{{ $user->name }}</a>
                                                </h3>
                                                <p class="text-gray-600">{{ $user->program }}</p>
                                                <p class="text-sm text-gray-500">Class of {{ $user->graduation_year }}</p>
                                            </div>
                                        </div>
                                        @if($user->profile)
                                            <div class="space-y-2">
                                                @if($user->profile->current_job)
                                                <div>
                                                    <span class="text-gray-500 text-sm">Current Job:</span>
                                                    <p class="font-medium">{{ $user->profile->current_job }}</p>
                                                </div>
                                                @endif
                                                @if($user->profile->company)
                                                <div>
                                                    <span class="text-gray-500 text-sm">Company:</span>
                                                    <p class="font-medium">{{ $user->profile->company }}</p>
                                                </div>
                                                @endif
                                                @if($user->profile->skills)
                                                <div>
                                                    <span class="text-gray-500 text-sm">Skills:</span>
                                                    <div class="flex flex-wrap gap-1 mt-1">
                                                        @foreach(array_slice($user->profile->skills, 0, 3) as $skill)
                                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">{{ $skill }}</span>
                                                        @endforeach
                                                        @if(count($user->profile->skills) > 3)
                                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">+{{ count($user->profile->skills) - 3 }} more</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="mt-4 pt-4 border-t">
                                            <a href="{{ route('directory.show', $user) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
