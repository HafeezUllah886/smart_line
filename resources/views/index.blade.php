@extends('layout.app')

@section('page-css')
  
@endsection

@section('content')
    <!-- Dashboard Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 mt-3">
        <div>
            <h3 class="mb-1 text-dark f-w-700">Business Dashboard</h3>
            <p class="text-secondary mb-0">Overview of fuel sales, purchases, and cash flows for {{ projectName() }}</p>
        </div>
        <div class="text-secondary f-w-600">
            <i class="ti ti-calendar me-1"></i> {{ date('F Y') }}
        </div>
    </div>

    <!-- Row 1: Primary Month Metrics -->
    <div class="row">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm border-0 bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-white-50">Business Balance</p>
                            <h4 class="mb-0 text-white">{{ number_format($businessBalance, 2) }}</h4>
                        </div>
                        <div class="avatar avatar-md bg-white text-primary rounded-circle">
                            <i class="ti ti-briefcase fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm border-0 bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-white-50">Suppliers Balance</p>
                            <h4 class="mb-0 text-white">{{ number_format($supplierBalance, 2) }}</h4>
                        </div>
                        <div class="avatar avatar-md bg-white text-info rounded-circle">
                            <i class="ti ti-building-store fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm border-0 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-white-50">Customers Balance</p>
                            <h4 class="mb-0 text-white">{{ number_format($customerBalance, 2) }}</h4>
                        </div>
                        <div class="avatar avatar-md bg-white text-success rounded-circle">
                            <i class="ti ti-users fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card h-100 shadow-sm border-0 bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-white-50">Checkposts Balance</p>
                            <h4 class="mb-0 text-white">{{ number_format($checkpostBalance, 2) }}</h4>
                        </div>
                        <div class="avatar avatar-md bg-white text-warning rounded-circle">
                            <i class="ti ti-flag fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Charts and Lists -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0">Monthly Profit ({{ date('Y') }})</h5>
                </div>
                <div class="card-body">
                    <div id="profitChart" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0">Top Customers ({{ date('Y') }})</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($topCustomers as $top)
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm bg-light text-primary rounded-circle me-3">
                                        <i class="ti ti-user fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">{{ $top->customer->title ?? 'N/A' }}</h6>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ number_format($top->total_sales, 0) }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center p-4 text-muted">No customers found this year.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        $(document).ready(function() {
            var options = {
                series: [{
                    name: 'Net Profit',
                    data: {!! json_encode($profitData) !!}
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#198754'],
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: {!! json_encode($months) !!},
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val.toFixed(2)
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#profitChart"), options);
            chart.render();
        });
    </script>
@endsection
