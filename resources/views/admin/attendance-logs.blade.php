@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Attendance</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Attendance</a></li>  
    </ol>
</div>
@endsection

@section('content')
@include('includes.flash')


                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                                <table id="datatable-buttons" class="table table-striped table-hover table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th data-priority="2">
                                                            ID NO
                                                        </th>
                                                        <th data-priority="2">
                                                            Name
                                                        </th>
                                                        <th data-priority="2">
                                                            LRN NO
                                                        </th>
                                                        <th data-priority="2">
                                                            Track & Strand
                                                        </th>
                                                        <th data-priority="2">
                                                            Section
                                                        </th>
                                                        <th data-priority="2">
                                                            Grade Level
                                                        </th>
                                                        <th data-priority="2">
                                                            Date
                                                        </th>
                                                        <th data-priority="2">
                                                            Time In
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach( $student_logs as $student_log)

                                                        <tr>
                                                            <td>
                                                                {{ $student_log->student_no }}
                                                            </td>
                                                            <td>
                                                                {{ strtoupper($student_log->students_name) }}
                                                            </td>
                                                            <td>
                                                                {{ $student_log->students_lrn}}
                                                            </td>
                                                            <td>    
                                                                {{ strtoupper($student_log->student_track) }} | {{ strtoupper($student_log->student_strand) }}
                                                            </td>
                                                            <td>    
                                                                {{ strtoupper($student_log->student_section) }}
                                                            </td>
                                                            <td>    
                                                                {{ strtoupper($student_log->student_grade) }}
                                                            </td>
                                                            <td>    
                                                                {{ strtoupper($student_log->formatted_date ?? 'N/A') }}
                                                            </td>
                                                            <td>    
                                                                {{ strtoupper($student_log->formatted_time ?? 'N/A') }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->    
                                    

@endsection


@section('script')
@endsection