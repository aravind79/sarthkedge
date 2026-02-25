@extends('layouts.master')

@section('title')
    {{ __('student_profile') }} - {{ $student->user->first_name }} {{ $student->user->last_name }}
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
           {{ __('student_profile') }}
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('reports.student.student-reports') }}">{{ __('student_reports') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('profile') }}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Left Column : Profile + Info -->
        <div class="col-lg-3 col-md-4 grid-margin">
            {{-- Student avatar + quick actions --}}
            <div class="card student-profile-card mb-3">
                <div class="card-body text-center">
                    <div class="student-avatar-wrapper mb-3">
                        <img src="{{ $student->user->image ?? asset('assets/images/avatar-placeholder.png') }}"
                             class="student-avatar"
                             alt="{{ $student->user->full_name ?? '' }}">
                    </div>
                    <p class="text-muted small mb-1">{{ __('admission_no') }} {{ $student->admission_no }}</p>
                    <h5 class="font-weight-bold mb-3 text-capitalize">
                        {{ $student->user->first_name }} {{ $student->user->last_name }}
                    </h5>

                    <div class="d-flex justify-content-center gap-2 mb-2">
                        <a href="javascript:void(0)" class="circle-icon-btn btn-view" data-toggle="tooltip" title="{{ __('View') }}">
                            <i class="fa fa-search"></i>
                        </a>
                        <a href="{{ route('students.create') }}" class="circle-icon-btn btn-edit" data-toggle="tooltip" title="{{ __('Edit') }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="javascript:void(0)" class="circle-icon-btn btn-delete" data-toggle="tooltip" title="{{ __('Delete') }}">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Basic information list --}}
            <div class="card student-info-card">
                <div class="card-header py-2">
                    <h6 class="mb-0">{{ __('basic_information') }}</h6>
                </div>
                <div class="card-body student-info-body">
                    <ul class="list-unstyled mb-0">
                        <li class="info-row">
                            <span class="label">{{ __('Class & Section') }}</span>
                            <span class="value">
                                {{ $student->class_section->class->name ?? '-' }}
                                @if($student->class_section?->section?->name)
                                    ({{ $student->class_section->section->name }})
                                @endif
                            </span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('Roll Number') }}</span>
                            <span class="value">{{ $student->roll_number ?? '-' }}</span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('dob') }}</span>
                            <span class="value">{{ $student->user->dob ?? '-' }}</span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('gender') }}</span>
                            <span class="value text-capitalize">{{ $student->user->gender ?? '-' }}</span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('admission_date') }}</span>
                            <span class="value">{{ $student->admission_date ?? '-' }}</span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('guardian') }}</span>
                            <span class="value">
                                {{ $student->guardian->first_name ?? '' }}
                                {{ $student->guardian->last_name ?? '' }}
                            </span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('guardian') . ' ' . __('mobile') }}</span>
                            <span class="value">{{ $student->guardian->mobile ?? '-' }}</span>
                        </li>
                        <li class="info-row">
                            <span class="label">{{ __('current_address') }}</span>
                            <span class="value text-truncate-2">
                                {{ $student->user->current_address ?: '-' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Column : Dashboard Tabs + Analytics -->
        <div class="col-lg-9 col-md-8 grid-margin">
            <div class="card">
                <div class="card-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs nav-tabs-line" id="studentTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab">
                                {{ __('Overview') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="academic-tab" data-toggle="tab" href="#academic" role="tab">
                                {{ __('Academic') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab">
                                {{ __('attendance') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="fees-tab" data-toggle="tab" href="#fees" role="tab">
                                {{ __('Fees') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab">
                                {{ __('Documents') }}
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content border-0 px-0" id="studentTabContent">
                        {{-- Overview dashboard --}}
                        <div class="tab-pane fade show active py-3" id="overview" role="tabpanel">
                            <div class="row">
                                <!-- Attendance Report Card -->
                                <div class="col-lg-6 mb-3">
                                    <div class="card dashboard-card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">{{ __('Attendance Report') }}</h6>
                                            <span class="badge badge-light">{{ $student->session_year->name ?? '' }}</span>
                                        </div>
                                        <div class="card-body p-3 d-flex">
                                            <div class="attendance-donut mr-3">
                                                <div class="donut-circle">
                                                    <span class="donut-value">100%</span>
                                                </div>
                                                <small class="text-muted d-block text-center mt-1">{{ __('Present') }}</small>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small text-muted mb-1">{{ __('Summary') }}</div>
                                                <div class="row">
                                                    <div class="col-6 mb-1">
                                                        <div class="stat-pill stat-present">
                                                            <span class="label">{{ __('Present Days') }}</span>
                                                            <span class="value">-</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-1">
                                                        <div class="stat-pill stat-absent">
                                                            <span class="label">{{ __('Absent Days') }}</span>
                                                            <span class="value">-</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-1">
                                                        <div class="stat-pill">
                                                            <span class="label">{{ __('Working Days') }}</span>
                                                            <span class="value">-</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mb-1">
                                                        <div class="stat-pill">
                                                            <span class="label">{{ __('Attendance %') }}</span>
                                                            <span class="value">-</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small class="text-muted d-block mt-2">
                                                    {{ __('Detailed charts are available in the Attendance tab.') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Examination Report Card -->
                                <div class="col-lg-6 mb-3">
                                    <div class="card dashboard-card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">{{ __('Examination Report') }}</h6>
                                            <i class="fa fa-bar-chart text-muted"></i>
                                        </div>
                                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-1 text-muted small">{{ __('Latest Exam') }}</p>
                                                <h6 class="mb-2">{{ $latestExam->title ?? __('No Exam Data') }}</h6>
                                                <p class="mb-1 small">
                                                    <strong>{{ __('Total Marks') }}:</strong> {{ $latestExam->total_marks ?? '-' }}
                                                </p>
                                                <p class="mb-1 small">
                                                    <strong>{{ __('Obtained') }}:</strong> {{ $latestExam->obtained_marks ?? '-' }}
                                                </p>
                                                <p class="mb-0 small">
                                                    <strong>{{ __('Result') }}:</strong>
                                                    <span class="badge badge-pill {{ ($latestExam->status ?? '') === 'Pass' ? 'badge-success' : 'badge-warning' }}">
                                                        {{ $latestExam->status ?? __('N/A') }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="empty-illustration text-center text-muted">
                                                <i class="fa fa-file-text-o fa-3x mb-2"></i>
                                                <p class="small mb-0">{{ __('View detailed results in Academic tab') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Fee Report Card -->
                                <div class="col-lg-6 mb-3">
                                    <div class="card dashboard-card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">{{ __('Fee Report') }}</h6>
                                            <i class="fa fa-credit-card text-muted"></i>
                                        </div>
                                        <div class="card-body p-3">
                                            @php
                                                $totalFee = $feeSummary['total'] ?? null;
                                                $paidFee = $feeSummary['paid'] ?? null;
                                                $dueFee = $feeSummary['due'] ?? null;
                                            @endphp
                                            <div class="row">
                                                <div class="col-4">
                                                    <p class="small text-muted mb-1">{{ __('Total Fee') }}</p>
                                                    <h6 class="mb-0">{{ $totalFee ?? '-' }}</h6>
                                                </div>
                                                <div class="col-4">
                                                    <p class="small text-muted mb-1">{{ __('Paid') }}</p>
                                                    <h6 class="mb-0 text-success">{{ $paidFee ?? '-' }}</h6>
                                                </div>
                                                <div class="col-4">
                                                    <p class="small text-muted mb-1">{{ __('Due') }}</p>
                                                    <h6 class="mb-0 text-danger">{{ $dueFee ?? '-' }}</h6>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                @php
                                                    $status = $feeSummary['status'] ?? null;
                                                @endphp
                                                <span class="badge badge-pill
                                                    @if($status === 'Paid') badge-success
                                                    @elseif($status === 'Partial') badge-warning
                                                    @elseif($status === 'Due') badge-danger
                                                    @else badge-secondary @endif">
                                                    {{ $status ?? __('No Data') }}
                                                </span>
                                                <small class="d-block text-muted mt-2">
                                                    {{ __('For full statement, open the Fees tab.') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Class Test / Subject Performance -->
                                <div class="col-lg-6 mb-3">
                                    <div class="card dashboard-card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">{{ __('Subject Performance') }}</h6>
                                            <i class="fa fa-line-chart text-muted"></i>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <div class="performance-circle">
                                                        <div class="inner">
                                                            <span class="score">76%</span>
                                                            <span class="label small text-muted">{{ __('Overall Score') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <ul class="list-unstyled mb-0 small">
                                                        <li class="mb-1">
                                                            <strong>Mathematics</strong>
                                                            <span class="text-muted d-block">A • 85%</span>
                                                        </li>
                                                        <li class="mb-1">
                                                            <strong>Science</strong>
                                                            <span class="text-muted d-block">B+ • 78%</span>
                                                        </li>
                                                        <li class="mb-1">
                                                            <strong>English</strong>
                                                            <span class="text-muted d-block">A • 88%</span>
                                                        </li>
                                                        <li class="mt-1 text-muted">
                                                            {{ __('Detailed marks are available in Academic tab.') }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Academic (reuse existing exam report tab) --}}
                        <div class="tab-pane fade py-3" id="academic" role="tabpanel">
                            @include('reports.student.exam-report-tab')
                        </div>

                        {{-- Full Attendance analytics --}}
                        <div class="tab-pane fade py-3" id="attendance" role="tabpanel">
                            @include('reports.student.attendance-report-tab', ['sessionYears' => $sessionYears])
                        </div>

                        {{-- Full Fees analytics --}}
                        <div class="tab-pane fade py-3" id="fees" role="tabpanel">
                            @include('reports.student.fees-report-tab', ['studentFees' => $studentFees])
                        </div>

                        {{-- Documents section (placeholder) --}}
                        <div class="tab-pane fade py-3" id="documents" role="tabpanel">
                            <div class="card">
                                <div class="card-body text-center text-muted">
                                    <i class="fa fa-folder-open-o fa-3x mb-3"></i>
                                    <p class="mb-1">{{ __('Documents module coming soon.') }}</p>
                                    <small>{{ __('Here you will be able to preview admission and academic documents.') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .student-profile-card {
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
    }
    .student-avatar-wrapper {
        width: 110px;
        height: 110px;
        border-radius: 999px;
        margin: 0 auto;
        background: #e0ecff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .student-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }
    .circle-icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: #fff;
        margin: 0 4px;
    }
    .circle-icon-btn.btn-view { background: #8b9cf9; }
    .circle-icon-btn.btn-edit { background: #6fc1ff; }
    .circle-icon-btn.btn-delete { background: #ff9aa2; }

    .student-info-card {
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    }
    .student-info-card .card-header {
        background: #f9fafb;
        border-bottom: 1px solid #edf2f7;
    }
    .student-info-body {
        max-height: 360px;
        overflow-y: auto;
    }
    .student-info-body .info-row {
        padding: 6px 0;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        flex-direction: column;
    }
    .student-info-body .info-row:last-child {
        border-bottom: none;
    }
    .student-info-body .label {
        font-size: 11px;
        text-transform: uppercase;
        color: #9ca3af;
        letter-spacing: .03em;
    }
    .student-info-body .value {
        font-size: 13px;
        color: #111827;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dashboard-card {
        border-radius: 16px;
    }
    .dashboard-card .card-header {
        background: #f9fafb;
        border-bottom: 1px solid #edf2f7;
    }
    .attendance-donut .donut-circle {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: conic-gradient(#4f46e5 0 75%, #e5e7eb 75% 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #111827;
        font-weight: 600;
        font-size: 18px;
    }
    .attendance-donut .donut-value {
        background: #fff;
        border-radius: 50%;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 0 2px rgba(255,255,255,0.6);
    }
    .stat-pill {
        border-radius: 10px;
        padding: 6px 8px;
        background: #f3f4f6;
        display: flex;
        justify-content: space-between;
        font-size: 11px;
    }
    .stat-pill .label {
        color: #6b7280;
    }
    .stat-pill .value {
        font-weight: 600;
        color: #111827;
    }
    .stat-present { background: #e0f2fe; }
    .stat-absent { background: #fee2e2; }

    .performance-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: conic-gradient(#22c55e 0 76%, #e5e7eb 76% 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .performance-circle .inner {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .performance-circle .score {
        font-weight: 700;
        font-size: 20px;
    }

    .empty-illustration {
        max-width: 140px;
    }

    @media (max-width: 991.98px) {
        .student-info-body {
            max-height: none;
        }
    }
</style>
@endsection

@push('scripts')
<script>
    $(function () {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

