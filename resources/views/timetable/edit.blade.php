@extends('layouts.master')

@section('title')
    {{ __('timetable') }}
@endsection

@section('css')
    <style>
        :root {
            --timetable-primary: #4e73df;
            --timetable-accent: #6366f1;
            --timetable-bg: #f4f7fe;
            --timetable-card-bg: #ffffff;
            --timetable-text-main: #2e3759;
            --timetable-text-muted: #718096;
            --timetable-border: #e2e8f0;
        }

        .content-wrapper {
            background: var(--timetable-bg);
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: #fff;
            overflow: hidden;
        }

        .timetable-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .timetable-header h3 {
            margin: 0;
            font-weight: 700;
            color: var(--timetable-text-main);
        }

        /* Sidebar Styling */
        #external-events {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid var(--timetable-border);
            height: fit-content;
        }

        #external-events h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--timetable-text-main);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .fc-event {
            cursor: pointer;
            margin-bottom: 12px !important;
            padding: 12px 15px !important;
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
            font-weight: 600;
            font-size: 0.85rem;
            color: #fff !important;
        }

        .fc-event:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        /* Calendar Styling */
        .calendar-wrapper {
            background: #fff;
            padding: 1rem;
            border-radius: 15px;
        }

        .fc {
            font-family: 'Inter', sans-serif;
        }

        .fc .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 700;
            color: var(--timetable-text-main);
        }

        .fc .fc-button-primary {
            background-color: var(--timetable-accent) !important;
            border-color: var(--timetable-accent) !important;
            border-radius: 8px !important;
            font-weight: 600;
            text-transform: capitalize;
        }

        .fc th {
            background: #f1f5f9;
            padding: 12px !important;
            font-weight: 700 !important;
            color: var(--timetable-text-main) !important;
            border: none !important;
        }

        .fc td {
            border: 1px solid #f1f5f9 !important;
        }

        .fc-timegrid-slot {
            height: 60px !important;
        }

        /* Legend Styling */
        .color-legend {
            margin-top: 3rem;
            padding: 2rem;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .legend-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--timetable-text-main);
        }

        .legend-items {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #f8fafc;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--timetable-text-main);
        }

        .color-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .btn-back {
            background: #f1f5f9;
            color: var(--timetable-text-main);
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #e2e8f0;
            color: var(--timetable-text-main);
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="timetable-header">
            <div>
                <a href="{{ route('timetable.index') }}" class="btn-back mb-2">
                    <i class="fa fa-arrow-left"></i> {{ __('Back to List') }}
                </a>
                <h3>{{ $classSection->full_name }} <span class="text-muted" style="font-weight: 400; font-size: 1.1rem;">- {{ __('Manage Timetable') }}</span></h3>
            </div>
            <div class="header-actions">
                <button class="btn btn-theme" onclick="window.print()"><i class="fa fa-print mr-2"></i> {{ __('Print') }}</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div id='external-events'>
                    <h4>{{ __('Subjects') }}</h4>
                    <p class="small text-muted mb-4">{{ __('Drag and drop subjects into the calendar grid below') }}</p>

                    @foreach ($subjectTeachers as $subjectTeacher)
                        <div class='fc-event'
                            style="background-color: {{ $subjectTeacher->subject->bg_color ?? '#6366f1' }}"
                            data-color="{{ $subjectTeacher->subject->bg_color ?? '#6366f1' }}"
                            data-subject_teacher_id="{{ $subjectTeacher->id }}"
                            data-subject_id="{{ $subjectTeacher->subject_id }}"
                            data-subject-type="{{ $subjectTeacher->class_subject ? $subjectTeacher->class_subject->type : '' }}"
                            data-duration='{{ $timetableSettingsData['timetable_duration'] ?? '01:00:00' }}'
                            data-note="">
                            <div class='fc-event-main'>
                                {{ $subjectTeacher->subject->name }}
                                <div style="font-size: 0.7rem; opacity: 0.8; font-weight: 400;">{{ $subjectTeacher->teacher->full_name }}</div>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($subjectWithoutTeacherAssigned as $subject)
                        @php
                            $filtered = collect($subject->class_subjects)->first();
                        @endphp
                        <div class='fc-event'
                            style="background-color: {{ $subject->bg_color ?? '#94a3b8' }}" 
                            data-color="{{ $subject->bg_color ?? '#94a3b8' }}"
                            data-duration='{{ $timetableSettingsData['timetable_duration'] ?? '01:00:00' }}'
                            data-subject_id="{{ $subject->id }}" data-note=""
                            data-subject-type="{{ $filtered['type'] ?? '' }}">
                            <div class='fc-event-main'>
                                {{ $subject->name }}
                                <div style="font-size: 0.7rem; opacity: 0.8; font-weight: 400;">{{ __('No Teacher Assigned') }}</div>
                            </div>
                        </div>
                    @endforeach

                    <div class='fc-event'
                        style="background-color: #334155" data-color="#334155" data-duration='00:30:00'
                        data-note="Break">
                        <div class='fc-event-main'>
                            <i class="fa fa-coffee mr-2"></i> {{ __('Break') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="calendar-wrapper">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="color-legend">
            <div class="legend-title">{{ __('Subject Color Legend') }}</div>
            <div class="legend-items">
                @foreach ($subjectTeachers as $subjectTeacher)
                    <div class="legend-item">
                        <div class="color-dot" style="background: {{ $subjectTeacher->subject->bg_color ?? '#6366f1' }}"></div>
                        {{ $subjectTeacher->subject->name }}
                    </div>
                @endforeach
                @foreach ($subjectWithoutTeacherAssigned as $subject)
                    <div class="legend-item">
                        <div class="color-dot" style="background: {{ $subject->bg_color ?? '#94a3b8' }}"></div>
                        {{ $subject->name }}
                    </div>
                @endforeach
                <div class="legend-item">
                    <div class="color-dot" style="background: #334155"></div>
                    {{ __('Break') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            @foreach ($timetables as $timetable)
                @php
                    $filtered = null;
                    if ($timetable->subject && $timetable->subject->class_subjects) {
                        $filtered = $timetable->subject->class_subjects->where('class_id', $classSection->class_id)->first();
                    }
                @endphp

                createTimetable.addEvent({
                    title: "{{ $timetable->title }}",
                    daysOfWeek: [days.indexOf("{{ $timetable->day }}")],
                    startTime: "{{ $timetable->start_time }}",
                    endTime: "{{ $timetable->end_time }}",
                    color: "{{ $timetable->subject->bg_color ?? '#334155' }}",
                    id: "{{ $timetable->id }}",
                    subject_type: "{{ $filtered?->type ?? '' }}",
                });
            @endforeach

            createTimetable.setOption("slotMinTime",
                "{{ $timetableSettingsData['timetable_start_time'] ?? '08:00:00' }}");
            createTimetable.setOption("slotMaxTime",
                "{{ $timetableSettingsData['timetable_end_time'] ?? '18:00:00' }}");
            createTimetable.setOption("slotDuration",
                "{{ $timetableSettingsData['timetable_duration'] ?? '01:00:00' }}");
            
            // Re-render calendar to apply options
            createTimetable.render();
        });
    </script>
@endsection