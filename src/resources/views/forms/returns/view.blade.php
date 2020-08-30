@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ __('Return') }}

                        @if($return->closed_date == NULL)
                        <div class="float-right">
                            <button class="btn btn-success" onclick="window.location.href = '/Forms/Returns/Edit/{{ $return->id }}'">
                                Edit
                            </button>
                        </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Customer Name</th>
                                <td>{{ $return->customer_name }}</td>
                            </tr>
                            <tr>
                                <th>Issue</th>
                                <td>{{ $return->issue }}</td>
                            </tr>
                            <tr>
                                <th>Received By</th>
                                <td>{{ $return->first_contact_date->toDateString() }}</td>
                            </tr>
                            <tr>
                                <th>Order Number</th>
                                <td>{{ $return->order_number }}</td>
                            </tr>
                            <tr>
                                <th>Tag</th>
                                <td>{{ $return->tag }}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{ $return->user_created_by->name }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $return->created_at->toDateTimeString() }}</td>
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
                            @if($return->goods_receive_date == NULL)
                                <tr>
                                    <td colspan="2"><button class="btn btn-success" data-toggle="modal" data-target="#goods_receive_date_modal" style="width: 100%;">Mark Goods Received</button></td>
                                </tr>
                                @else
                                <tr>
                                    <th>Goods Receive Date</th>
                                    <td>{{ $return->goods_receive_date->toDateString() }}</td>
                                </tr>
                                @if($return->inspected_date == NULL)
                                    <tr>
                                        <td colspan="2"><button class="btn btn-success" data-toggle="modal" data-target="#goods_inspected_date_modal" style="width: 100%;">Set Goods Inspected Date </button></td>
                                    </tr>
                                @else
                                    <tr>
                                        <th>Goods Inspected Date</th>
                                        <td>{{ $return->inspected_date->toDateString() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Outcome</th>
                                        <td>{{ $return->Outcome() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Action</th>
                                        <td>{{ $return->OutcomeAction() }}</td>
                                    </tr>
                                    @if($return->closed_date == NULL)
                                        <tr>
                                            <td colspan="2"><button class="btn btn-success" data-toggle="modal" data-target="#return_closed_modal" style="width: 100%;">Close Return</button></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <th>Closed Date</th>
                                            <td>{{ $return->closed_date->toDateString() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Further Action</th>
                                            <td>{{ $return->further_action }}</td>
                                        </tr>

                                    @endif
                                @endif
                            @endif
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($return->goods_receive_date == NULL)
        <form role="form"
              class="form-edit-add"
              id="form-edit-add"
              action="/Forms/Returns/Receive"
              method="POST" enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" name="id" value="{{ $return->id }}">

            <div class="modal fade" id="goods_receive_date_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Mark Goods Received</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @Input(['attribute' => 'goods_receive_date', 'model' => $return, 'label' => 'Goods Receive Date', 'type' => 'date'])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
        @if($return->inspected_date == NULL)
            <form role="form"
                  class="form-edit-add"
                  id="form-edit-add"
                  action="/Forms/Returns/Inspected"
                  method="POST" enctype="multipart/form-data">

                {{ csrf_field() }}

                <input type="hidden" name="id" value="{{ $return->id }}">

                <div class="modal fade" id="goods_inspected_date_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Mark Goods Inspected</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @Input(['attribute' => 'inspected_date', 'model' => $return, 'label' => 'Goods Inspected Date', 'type' => 'date'])
                                @Select(['attribute' => 'outcome', 'model' => $return, 'label' => 'Outcome', 'options' => App\Models\Forms\ProductReturn::outcome_options])
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


        @else
            @if($return->closed_date == NULL)
                <form role="form"
                      class="form-edit-add"
                      id="form-edit-add"
                      action="/Forms/Returns/Resolve"
                      method="POST" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <input type="hidden" name="id" value="{{ $return->id }}">

                    <div class="modal fade" id="return_closed_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Close Return</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @Input(['attribute' => 'closed_date', 'model' => $return, 'label' => 'Closed Date', 'type' => 'date'])
                                    @Input(['attribute' => 'further_action', 'model' => $return, 'label' => 'Further Action *'])
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
        @endif

    @endif


@endsection
