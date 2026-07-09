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
   
@endsection

@section('page-js')
  
@endsection
