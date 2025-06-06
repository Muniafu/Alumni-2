<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('error'))
                        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.reports.generate') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="report_type" :value="__('Report Type')" />
                                <select name="report_type" id="report_type" class="form-select rounded-md shadow-sm w-full" required>
                                    <option value="">Select Report Type</option>
                                    <option value="users">Users Report</option>
                                    <option value="events">Events Report</option>
                                    <option value="jobs">Job Postings Report</option>
                                </select>
                                <x-input-error :messages="$errors->get('report_type')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="format" :value="__('Format')" />
                                <select name="format" id="format" class="form-select rounded-md shadow-sm w-full" required>
                                    <option value="">Select Format</option>
                                    <option value="csv">CSV</option>
                                    <option value="xlsx">Excel (XLSX)</option>
                                </select>
                                <x-input-error :messages="$errors->get('format')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="start_date" :value="__('Start Date (Optional)')" />
                                <x-text-input type="date" name="start_date" id="start_date" class="w-full" />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="end_date" :value="__('End Date (Optional)')" />
                                <x-text-input type="date" name="end_date" id="end_date" class="w-full" />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <x-primary-button>Generate Report</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
