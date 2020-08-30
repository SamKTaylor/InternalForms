@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Returns') }}
                        <div class="float-right">
                            <button class="btn btn-success" onclick="window.location.href = '/Forms/Returns/Add'">
                                New Return
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

                        <ul class="list-group list-group-horizontal" style="margin-bottom: 10px;">
                            <a class="filter list-group-item list-group-item-action active" data-filter="Active">All Active</a>
                            <a class="filter list-group-item list-group-item-action" data-filter="Warehouse">Warehouse</a>
                            <a class="filter list-group-item list-group-item-action" data-filter="Sales">Sales</a>
                            <a class="filter list-group-item list-group-item-action" data-filter="Purchasing">Purchasing</a>
                            <a class="filter list-group-item list-group-item-action" data-filter="All">All</a>
                        </ul>

                        <table id="returns-table" class="table">
                            <thead>
                                <tr>
                                    <th>First Contact Date</th>
                                    <th>Customer Name</th>
                                    <th>Order Number</th>
                                    <th>Tag</th>
                                    <th>Created By</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                            <a href="/Forms/Returns/CSV">Download CSV</a>
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

                var url = '/Forms/Returns/Json/' + $(this).data('filter');

                $('#returns-table').DataTable().ajax.url( url ).load();

            });



            $('#returns-table').DataTable( {
                "bStateSave": true,
                serverSide: true,
                ajax: '/Forms/Returns/Json/Active',
                columns: [
                    { data: "date" },
                    { data: "customer_name" },
                    { data: "order_number" },
                    { data: "tag" },
                    { data: "user_created_by.name" },
                    { data: "id",
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html("<a href='/Forms/Returns/View/"+oData.id+"'>View</a>");
                        }}
                ],
            } );
        });
    </script>
@endsection