@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Complaint') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form role="form"
                              class="form-edit-add"
                              id="form-edit-add"
                              action="/Forms/Complaints/Save"
                              method="POST" enctype="multipart/form-data">

                            {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ $complaint->id }}">

                            @Input(['attribute' => 'complaint_date', 'model' => $complaint, 'label' => 'Complaint Date *', 'type' => 'date'])

                            @Select(['attribute' => 'received_by', 'model' => $complaint, 'label' => 'Received By *', 'options' => $user_array])

                            @Select(['attribute' => 'receipt_type', 'model' => $complaint, 'label' => 'Receipt Type *', 'options' => App\Models\Forms\Complaint::receipt_type_options])

                            @Input(['attribute' => 'customer_name', 'model' => $complaint, 'label' => 'Customer Name *'])

                            @Input(['attribute' => 'description', 'model' => $complaint, 'label' => 'Description *'])

                            @Select(['attribute' => 'category', 'model' => $complaint, 'label' => 'Category *', 'options' => App\Models\Forms\Complaint::category_options])

                            @Select(['attribute' => 'department', 'model' => $complaint, 'label' => 'Department *', 'options' => App\Models\Forms\Complaint::department_options])

                            @Select(['attribute' => 'assigned_to', 'model' => $complaint, 'label' => 'Assigned To *', 'options' => $user_array])

                            @Select(['attribute' => 'status', 'model' => $complaint, 'label' => 'Status *', 'options' => App\Models\Forms\Complaint::status_options])

                            <button class="btn btn-success" style="width: 100%;" type="submit">Save</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection