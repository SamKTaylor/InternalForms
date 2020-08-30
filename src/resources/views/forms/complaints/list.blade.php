@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Complaints') }}

                        <div class="float-right">
                            <button class="btn btn-success" onclick="window.location.href = '/Forms/Complaints/Add'">
                                New Complaint
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

                        <ul class="list-group list-group-horizontal" style="margin-bottom: 10px;">
                            <a class="filter list-group-item list-group-item-action active" data-filter="All">All</a>
                            <a class="filter list-group-item list-group-item-action" data-filter="UnacknowledgedAll">All Unacknowledged</a>
                            <a class="filter list-group-item list-group-item-action" data-filter="UnacknowledgedMy">My Unacknowledged</a>
                            <a class="filter list-group-item list-group-item-action" data-filter="My">Assigned to me</a>
                        </ul>


                        <table id="complaints-table" class="table">
                            <thead>
                                <tr>
                                    <th>Complaint Date</th>
                                    <th>Customer Name</th>
                                    <th>Category</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                        <a href="/Forms/Complaints/CSV">Download CSV</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            $('.filter').click(function () {

                $('.filter').removeClass('active');
                $(this).addClass('active');

                var url = '/Forms/Complaints/Json/' + $(this).data('filter');

                $('#complaints-table').DataTable().ajax.url( url ).load();

            });

            $('#complaints-table').DataTable( {
                "bStateSave": true,
                serverSide: true,
                ajax: '/Forms/Complaints/Json/All',
                columns: [
                    { data: "date" },
                    { data: "customer_name" },
                    { data: "category" },
                    { data: "user_assigned_to.name" },
                    { data: "status" },
                    { data: "id",
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<a href='/Forms/Complaints/View/"+oData.id+"'>View</a>");
                        }}

                ],
            } );

        });
    </script>
@endsection