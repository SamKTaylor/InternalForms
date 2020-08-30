@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ __('Complaint') }}
                        @if($complaint->acknowledged_date == NULL && $complaint->assigned_to == Auth::user()->id)
                            <div class="float-right" style="padding-left: 4px;">
                                <button class="btn btn-success" onclick="window.location.href = '/Forms/Complaints/Acknowledge/{{$complaint->id}}'">
                                    Acknowledge
                                </button>
                            </div>
                        @endif

                        <div class="float-right">
                            <button class="btn btn-success" onclick="window.location.href = '/Forms/Complaints/Edit/{{ $complaint->id }}'">
                                Edit
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Status</th>
                                <td>{{ $complaint->status }}</td>
                            </tr>
                            <tr>
                                <th>Complaint Date</th>
                                <td>{{ $complaint->complaint_date->toDateString() }}</td>
                            </tr>
                            <tr>
                                <th>Received By</th>
                                <td>{{ $complaint->user_received_by->name }}</td>
                            </tr>
                            <tr>
                                <th>Receipt Type</th>
                                <td>{{ $complaint->receipt_type }}</td>
                            </tr>
                            <tr>
                                <th>Customer Name</th>
                                <td>{{ $complaint->customer_name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $complaint->description }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $complaint->category }}</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>{{ $complaint->department }}</td>
                            </tr>
                            <tr>
                                <th>Assigned To</th>
                                <td>{{ $complaint->user_assigned_to->name }}</td>
                            </tr>
                            <tr>
                                <th>Acknowledged Date</th>
                                @if($complaint->acknowledged_date != NULL)
                                <td>{{ $complaint->acknowledged_date->toDateString() }}</td>
                                @else
                                <td></td>
                                @endif
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $complaint->created_at->toDateTimeString() }}</td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Resolution') }}</div>

                    <div class="card-body">

                        <table class="table">
                                @if($complaint->resolved_date == NULL)
                                <tr>
                                    <td colspan="2">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#mark_resolved_modal" style="width: 100%;">
                                            Mark As Resolved
                                        </button>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <th>Root Cause</th>
                                    <td>{{ $complaint->root_cause }}</td>
                                </tr>
                                <tr>
                                    <th>Resolved Date</th>
                                    <td>{{ $complaint->resolved_date->toDateString() }}</td>
                                </tr>
                                <tr>
                                    <th>Resolved By</th>
                                    <td>{{ $complaint->user_resolved_by->name }}</td>
                                </tr>
                                <tr>
                                    <th>Corrective Action</th>
                                    <td>{{ $complaint->corrective_action }}</td>
                                </tr>
                                <tr>
                                    <th>Preventative Action</th>
                                    <td>{{ $complaint->preventative_action }}</td>
                                </tr>
                            @endif
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($complaint->resolved_date == NULL)
        <form role="form"
              class="form-edit-add"
              id="form-edit-add"
              action="/Forms/Complaints/Resolve"
              method="POST" enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" name="id" value="{{ $complaint->id }}">

            <div class="modal fade" id="mark_resolved_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Mark Resolved</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @Select(['attribute' => 'resolved_by', 'model' => $complaint, 'label' => 'Resolved By *', 'options' => $user_array])
                            @Input(['attribute' => 'root_cause', 'model' => $complaint, 'label' => 'Root Cause *'])
                            @Input(['attribute' => 'corrective_action', 'model' => $complaint, 'label' => 'Corrective Action *'])
                            @Input(['attribute' => 'preventative_action', 'model' => $complaint, 'label' => 'Preventative Action *'])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
@endsection
