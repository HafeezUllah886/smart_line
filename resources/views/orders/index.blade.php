@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header d-flex justify-content-between">
                    <h5>Orders</h5>
                    <button aria-controls="canvasEnd" class="btn btn-primary" data-bs-target="#canvasEnd"
                        data-bs-toggle="offcanvas" type="button">Filter</button>
                </div>
                <div class="card-body p-0">
                    <div class="app-datatable-default overflow-auto app-scroll">
                        <table class="display app-data-table default-data-table" id="defaultDatatable">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">#</th>
                                    <th class="text-start">Order #</th>
                                    <th class="text-start">Date</th>
                                    <th class="text-start">Supplier</th>
                                    <th class="text-start">Customer</th>
                                    <th class="text-end">Purchase</th>
                                    <th class="text-end">Sale</th>
                                    <th class="text-end">Expense</th>
                                    <th class="text-end">Profit/Loss</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td class="text-dark" style="width: 10px;">{{ $key + 1 }}</td>
                                        <td class="text-start">{{ $order->inv }}</td>
                                        <td class="text-start">{{ date('d-m-Y', strtotime($order->date)) }}</td>
                                        <td class="text-start">{{ $order->supplier->title }}</td>
                                        <td class="text-start">{{ $order->customer->title }}</td>
                                        <td class="text-end">{{ number_format($order->purchase_amount, 2) }}</td>
                                        <td class="text-end">{{ number_format($order->sale_amount, 2) }}</td>
                                        <td class="text-end">{{ number_format($order->route_expense, 2) }}</td>
                                        <td class="text-end">
                                            @if ($order->profit_loss >= 0)
                                                <span
                                                    class="text-success">{{ number_format($order->profit_loss, 2) }}</span>
                                            @else
                                                <span class="text-danger">{{ number_format($order->profit_loss, 2) }}</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm px-2" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('orders.show', $order->id) }}"><i
                                                                class="ti ti-eye me-2 text-secondary"></i> View</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('orders.edit', $order->id) }}"><i
                                                                class="ti ti-edit me-2 text-secondary"></i> Edit</a></li>
                                                    <li>
                                                        <a class="dropdown-item text-danger"
                                                            href="{{ route('order.delete', $order->id) }}"><i
                                                                class="ti ti-trash me-2 text-danger"></i>
                                                            Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Default Datatable end -->



    </div>
    <!-- Default Modals -->


@section('filter-content')
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="ti ti-calendar"></i></span>
            <label for="fromdate" class="form-label" style="display: none;">From Date</label>
            <input type="date" class="form-control" name="from" id="fromdate" value="{{ $from }}">
        </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="ti ti-calendar"></i></span>
            <label for="todate" class="form-label" style="display: none;">To Date</label>
            <input type="date" class="form-control" name="to" id="todate" value="{{ $to }}">
        </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="ti ti-user"></i></span>
            <label for="supplier" class="form-label" style="display: none;">Supplier</label>
            <select class="form-control" name="supplier" id="supplier">
                <option value="all">All Suppliers</option>
                @foreach ($suppliers as $sup)
                    <option value="{{ $sup->id }}" {{ $supplier == $sup->id ? 'selected' : '' }}>
                        {{ $sup->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="ti ti-user"></i></span>
            <label for="customer" class="form-label" style="display: none;">Customers</label>
            <select class="form-control" name="customer" id="customer">
                <option value="all">All Customers</option>
                @foreach ($customers as $cus)
                    <option value="{{ $cus->id }}" {{ $customer == $cus->id ? 'selected' : '' }}>
                        {{ $cus->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection

@include('layout.offcan')
@endsection

@section('page-css')
<!-- data table css -->
<link href="{{ asset('assets/vendor/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('page-js')
<!-- data table js -->
<script src="{{ asset('assets/vendor/datatable/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('assets/vendor/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatable/datatable2/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatable/datatable2/jszip.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatable/datatable2/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatable/datatable2/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/vendor/datatable/datatable2/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatable/datatable2/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/data_table.js') }}"></script>
@endsection
