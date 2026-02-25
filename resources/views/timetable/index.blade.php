@extends('layouts.master')

@section('title')
    {{ __('timetable') }}
@endsection

@section('css')
    <style>
        :root {
            --timetable-primary: #4e73df;
            --timetable-secondary: #858796;
            --timetable-success: #1cc88a;
            --timetable-info: #36b9cc;
            --timetable-warning: #f6c23e;
            --timetable-danger: #e74a3b;
            --timetable-light: #f8f9fc;
            --timetable-dark: #5a5c69;
            --timetable-bg: #f4f7fe;
            --timetable-card-bg: #ffffff;
            --timetable-text-main: #2e3759;
            --timetable-text-muted: #718096;
            --timetable-accent: #6366f1;
            --timetable-border: #e2e8f0;
            --timetable-input-bg: #f8fafc;
        }

        .content-wrapper {
            background: var(--timetable-bg);
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--timetable-text-main);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1rem;
            color: var(--timetable-text-muted);
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            background: var(--timetable-card-bg);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-body {
            padding: 2rem;
        }

        .settings-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--timetable-text-main);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .settings-section-title i {
            color: var(--timetable-accent);
        }

        .form-group label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--timetable-text-main);
            margin-bottom: 8px;
        }

        .form-control {
            background-color: var(--timetable-input-bg) !important;
            border: 1px solid var(--timetable-border) !important;
            border-radius: 10px !important;
            height: 48px !important;
            padding: 12px 16px !important;
            transition: all 0.2s;
        }

        .form-control:focus {
            background-color: #fff !important;
            border-color: var(--timetable-accent) !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        }

        .btn-theme {
            background: var(--timetable-accent) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            color: #fff !important;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .btn-theme:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(99, 102, 241, 0.3);
        }

        /* Table Styles */
        #toolbar {
            margin-bottom: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid var(--timetable-border);
        }

        .bootstrap-table .fixed-table-container {
            border: none !important;
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background: #f1f5f9 !important;
            color: var(--timetable-text-main) !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 15px !important;
            border: none !important;
        }

        .table tbody td {
            padding: 15px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: var(--timetable-text-main);
        }

        .timetable-slot-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            background: var(--timetable-bg);
            color: var(--timetable-accent);
            margin-bottom: 4px;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .day-column {
            min-width: 140px;
        }

        .fixed-table-pagination {
            padding: 1rem 0;
        }

        .page-item.active .page-link {
            background-color: var(--timetable-accent) !important;
            border-color: var(--timetable-accent) !important;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ __('Timetable') }}</h3>
            <p class="page-subtitle">{{ __('View and manage class timetables') }}</p>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="settings-section-title">
                            <i class="fa fa-cog"></i> {{ __('Timetable Settings') }}
                        </div>
                        <form class="edit-form edit-form-without-reset timetable-settings-form mb-5"
                            action="{{ route('timetable.settings') }}" method="POST">
                            <div class="row align-items-end">
                                <div class="form-group col-sm-12 col-md-3">
                                    <label for="starting_time">{{ __('Starting Time') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="timetable_start_time" id="starting_time" class="form-control"
                                        value="{{ $timetableData['timetable_start_time'] ?? ""}}" />
                                </div>

                                <div class="form-group col-sm-12 col-md-3">
                                    <label for="ending_time">{{ __('Ending Time') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="timetable_end_time" id="ending_time" class="form-control"
                                        value="{{ $timetableData['timetable_end_time'] ?? ""}}" />
                                </div>
                                <div class="form-group col-sm-12 col-md-3">
                                    <label for="duration">{{ __('Timeslot Duration') }}
                                        <small>({{__('in Minutes')}})</small><span class="text-danger">*</span></label>
                                    <input type="number" name="timetable_duration" id="duration" class="form-control"
                                        min="1" value="{{ $timetableData['timetable_duration'] ?? ""}}" />
                                </div>
                                <div class="form-group col-sm-12 col-md-3">
                                    <button type="submit" id="generate"
                                        class="btn btn-theme w-100">{{__('Save Settings')}}</button>
                                </div>
                            </div>
                        </form>

                        <hr class="mb-5" style="border-top: 1px dashed var(--timetable-border);">

                        <div class="row" id="toolbar">
                            <div class="col-md-3">
                                <label class="filter-menu font-weight-bold mb-2">{{ __('Filter by Medium') }}</label>
                                {!! Form::select('medium_id', $mediums, null, ['class' => 'form-control', 'id' => 'filter_medium_id', 'placeholder' => __('select_medium')]) !!}
                            </div>

                            <div class="col-md-3">
                                <label class="filter-menu font-weight-bold mb-2">{{ __('Filter by Class') }}</label>
                                {!! Form::select('class_id', $classes, null, ['class' => 'form-control', 'id' => 'filter_class_id', 'placeholder' => __('select_class')]) !!}
                            </div>

                            <div class="col-md-6 d-flex align-items-end justify-content-end">
                                <button type="button" class="btn btn-theme" data-toggle="modal"
                                    data-target="#cloneTimetableModal">
                                    <i class="fa fa-copy mr-2"></i> {{ __('Clone / Use Template') }}
                                </button>
                            </div>
                        </div>

                        <!-- Clone Timetable Modal -->
                        <div class="modal fade" id="cloneTimetableModal" tabindex="-1" role="dialog"
                            aria-labelledby="cloneTimetableModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cloneTimetableModalLabel">
                                            {{ __('Clone Timetable (Template)') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('timetable.copy') }}" method="POST" class="create-form">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>{{ __('Copy From (Template)') }} <span
                                                        class="text-danger">*</span></label>
                                                <select name="from_class_section_id" class="form-control" required>
                                                    <option value="">{{ __('Select Class Section') }}</option>
                                                    @foreach($classes as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ __('Copy To') }} <span class="text-danger">*</span></label>
                                                <select name="to_class_section_id" class="form-control" required>
                                                    <option value="">{{ __('Select Class Section') }}</option>
                                                    @foreach($classes as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <p class="text-warning small"><i class="fa fa-exclamation-triangle"></i>
                                                {{ __('Warning: This will overwrite any existing timetable for the target class section.') }}
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ __('Close') }}</button>
                                            <button type="submit" class="btn btn-theme">{{ __('Copy Timetable') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                                data-url="{{ route('timetable.show', [1]) }}" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-toolbar="#toolbar"
                                data-show-columns="true" data-show-refresh="true" data-fixed-columns="false"
                                data-fixed-number="2" data-fixed-right-number="1" data-trim-on-search="false"
                                data-mobile-responsive="true" data-sort-name="id" data-query-params="timetableQueryParams"
                                data-sort-order="desc" data-maintain-selected="true" data-export-data-type='all'
                                data-show-export="true"
                                data-export-options='{ "fileName": "timetable-list-<?= date('d-m-y') ?>" }'>
                                <thead>
                                    <tr>
                                        <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                            {{ __('id') }}
                                        </th>
                                        <th scope="col" data-field="no">{{ __('no.') }}</th>
                                        <th scope="col" data-field="full_name" data-sortable="true">
                                            {{ __('Class Section') }}
                                        </th>
                                        <th scope="col" data-field="Monday" data-formatter="timetableDayFormatter"
                                            class="day-column">{{ __('Monday') }}</th>
                                        <th scope="col" data-field="Tuesday" data-formatter="timetableDayFormatter"
                                            class="day-column">{{ __('Tuesday') }}</th>
                                        <th scope="col" data-field="Wednesday" data-formatter="timetableDayFormatter"
                                            class="day-column">{{ __('Wednesday') }}</th>
                                        <th scope="col" data-field="Thursday" data-formatter="timetableDayFormatter"
                                            class="day-column">{{ __('Thursday') }}</th>
                                        <th scope="col" data-field="Friday" data-formatter="timetableDayFormatter"
                                            class="day-column">{{ __('Friday') }}</th>
                                        <th scope="col" data-field="Saturday" data-formatter="timetableDayFormatter"
                                            class="day-column">{{ __('Saturday') }}</th>
                                        <th scope="col" data-field="Sunday" data-formatter="timetableDayFormatter"
                                            class="day-column" data-visible="false">{{ __('Sunday') }}</th>
                                        <th scope="col" data-field="operate" data-escape="false"
                                            data-events="timetableEvents">{{ __('action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection