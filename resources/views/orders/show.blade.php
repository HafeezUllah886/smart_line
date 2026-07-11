@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Order Details: #{{ $order->inv }}</h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <h6 class="text-muted">Date</h6>
                            <p>{{ date('d-m-Y', strtotime($order->date)) }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">Product</h6>
                            <p>{{ $order->product->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">Driver</h6>
                            <p>{{ $order->driver->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">Vehicle No.</h6>
                            <p>{{ $order->vehicle_no }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary border-bottom pb-2">Purchase Details</h5>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th>Supplier:</th>
                                    <td>{{ $order->supplier->title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Account:</th>
                                    <td>{{ $order->purchaseAccount->title ?? 'Pending' }}</td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td>{{ number_format($order->purchase_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Quantity:</th>
                                    <td>{{ number_format($order->purchase_qty, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount:</th>
                                    <th class="text-danger">{{ number_format($order->purchase_amount, 2) }}</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary border-bottom pb-2">Sale Details</h5>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th>Customer:</th>
                                    <td>{{ $order->customer->title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Account:</th>
                                    <td>{{ $order->saleAccount->title ?? 'Pending' }}</td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td>{{ number_format($order->sale_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Quantity:</th>
                                    <td>{{ number_format($order->sale_qty, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount:</th>
                                    <th class="text-success">{{ number_format($order->sale_amount, 2) }}</th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary border-bottom pb-2">Checkpost Route Expenses</h5>
                            @if ($order->expenses->count() > 0)
                                <table class="table table-striped table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Checkpost</th>
                                            <th>Payment By</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->expenses as $key => $expense)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $expense->post->title ?? 'N/A' }}</td>
                                                <td class="text-capitalize">
                                                    {{ ($expense->payment == 'pending' ? 'Pending' : $expense->payment == 'byowner') ? 'By Owner' : 'By Driver' }}
                                                </td>
                                                <td class="text-end">{{ number_format($expense->amount, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end">Total Route Expenses</th>
                                            <th class="text-end text-danger">{{ number_format($order->route_expense, 2) }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            @else
                                <p class="text-muted">No route expenses recorded for this order.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="fw-bold">Notes</label>
                                <p class="text-muted">{{ $order->notes ?? 'No notes provided.' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title border-bottom pb-2">Financial Summary</h5>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Total Sales:</span>
                                        <span class="text-success">{{ number_format($order->sale_amount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Total Purchases:</span>
                                        <span class="text-danger">- {{ number_format($order->purchase_amount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Route Expenses:</span>
                                        <span class="text-danger">- {{ number_format($order->route_expense, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between border-top pt-2">
                                        <span class="fw-bold">Profit / Loss:</span>
                                        <span
                                            class="fw-bold {{ $order->profit_loss >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($order->profit_loss, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
