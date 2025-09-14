@extends('layouts.app')

@section('header')
<h2 class="fw-semibold fs-4 text-dark d-flex align-items-center">
    <i class="bi bi-graph-up-arrow text-primary me-2"></i> {{ __('Generate Reports') }}
</h2>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            {{-- Error Alert --}}
            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <form action="{{ route('admin.reports.generate') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="row g-4">
                    {{-- Report Type --}}
                    <div class="col-md-6">
                        <label for="report_type" class="form-label fw-semibold">Report Type</label>
                        <select name="report_type" id="report_type"
                                class="form-select @error('report_type') is-invalid @enderror" required>
                            <option value="">Select Report Type</option>
                            <option value="users">Users Report</option>
                            <option value="events">Events Report</option>
                            <option value="jobs">Job Postings Report</option>
                        </select>
                        @error('report_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Format --}}
                    <div class="col-md-6">
                        <label for="format" class="form-label fw-semibold">Format</label>
                        <select name="format" id="format"
                                class="form-select @error('format') is-invalid @enderror" required>
                            <option value="">Select Format</option>
                            <option value="csv">CSV</option>
                            <option value="xlsx">Excel (XLSX)</option>
                        </select>
                        @error('format') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Start Date --}}
                    <div class="col-md-6">
                        <label for="start_date" class="form-label fw-semibold">Start Date <span class="text-muted">(Optional)</span></label>
                        <input type="date" id="start_date" name="start_date"
                               class="form-control @error('start_date') is-invalid @enderror">
                        @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- End Date --}}
                    <div class="col-md-6">
                        <label for="end_date" class="form-label fw-semibold">End Date <span class="text-muted">(Optional)</span></label>
                        <input type="date" id="end_date" name="end_date"
                               class="form-control @error('end_date') is-invalid @enderror">
                        @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success shadow-sm px-4">
                        <i class="bi bi-file-earmark-bar-graph me-1"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
