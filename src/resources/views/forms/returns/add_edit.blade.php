@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Return') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form role="form"
                                  class="form-edit-add"
                                  id="form-edit-add"
                                  action="/Forms/Returns/Save"
                                  method="POST" enctype="multipart/form-data">

                                {{ csrf_field() }}

                                <input type="hidden" name="id" value="{{ $return->id }}">

                                @Input(['attribute' => 'customer_name', 'model' => $return, 'label' => 'Customer Name *'])

                                @Select(['attribute' => 'issue', 'model' => $return, 'label' => 'Issue *', 'options' => App\Models\Forms\ProductReturn::issue_options])

                                @Input(['attribute' => 'first_contact_date', 'model' => $return, 'label' => 'First Contact Date *', 'type' => 'date'])

                                @Input(['attribute' => 'order_number', 'model' => $return, 'label' => 'Order Number *'])

                                <button class="btn btn-success" style="width: 100%;" type="submit">Save</button>

                            </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection