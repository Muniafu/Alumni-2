<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.reports.generate') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="report_type" class="block text-sm font-medium text-gray-700 mb-1">Report Type</label>
                                <select name="report_type" id="report_type" class="form-select rounded-md shadow-sm w-full" required>
                                    <option value="">Select Report Type</option>
                                    <option value="users">Users Report</option>
                                    <option value="events">Events Report</option>
                                    <option value="jobs">Job Postings Report</option>
                                </select>
                            </div>
                            <div>
                                <label for="format" class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                                <select name="format" id="format" class="form-select rounded-md shadow-sm w-full" required>
                                    <option value="">Select Format</option>
                                    <option value="csv">CSV</option>
                                    <option value="xlsx">Excel (XLSX)</option>
                                </select>
                            </div>
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date (Optional)</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="form-input rounded-md shadow-sm w-full">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date (Optional)</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="form-input rounded-md shadow-sm w-full">
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
