@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<div class="col-sm-6">
    <h4 class="page-title text-left">Student</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Student</a></li>  
    </ol>
</div>
@endsection
@section('button')
<a href="#addnew" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Add New Student</a>
        

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
                                                        <th data-priority="7">
                                                            Actions
                                                        </th>
                                                     
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach( $students_logs as $student_log)

                                                        <tr>
                                                            <td>
                                                                {{ $student_log->std_no }}
                                                            </td>
                                                            <td>
                                                                {{ strtoupper($student_log->name) }}
                                                            </td>
                                                            <td>
                                                                {{ $student_log->lrn_no}}
                                                            </td>
                                                            <td>    
                                                                {{ strtoupper($student_log->std_track) }} | {{ strtoupper($student_log->std_strand) }}
                                                            </td>
                                                            <td>    
                                                                {{ strtoupper($student_log->std_section) }}
                                                            </td>
                                                            <td>    
                                                                {{ strtoupper($student_log->std_grade) }}
                                                            </td>
                                                            <td>
                                                                <a href="#edit{{$student_log_logs->id}}" data-toggle="modal" class="btn btn-success btn-sm edit btn-flat"><i class='fa fa-edit'></i></a>
                                                                <a href="#delete{{$student_log_logs->id}}" data-toggle="modal" class="btn btn-danger btn-sm delete btn-flat"><i class='fa fa-trash'></i></a>
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
                                    
@foreach($students as $student)
@include('includes.edit_delete_student')
@endforeach
                        
@include('includes.add_student')

@endsection


@section('script')
@endsection