@extends('layout.app')
@section('content')
    <div class="row">
        <!-- Default Datatable start -->
        <div class="col-12">
            <div class="card ">
                <div class="card-header d-flex justify-content-between">
                    <h5>Drivers</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new">Add New</button>
                </div>
                <div class="card-body p-0">
                    <div class="app-datatable-default overflow-auto app-scroll">
                        <table class="display app-data-table default-data-table" id="defaultDatatable">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th class="text-start">Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drivers as $key => $driver)
                                    <tr>
                                        <td class="text-dark">{{ $key + 1 }}</td>
                                        <td class="text-start">{{ $driver->name }}</td>
                                        <td>{{ $driver->phone }}</td>
                                        <td>{{ $driver->address }}</td>
                                        <td>
                                            @if ($driver->is_active == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $driver->id }}">Edit</button>
                                        </td>
                                        <div id="edit{{ $driver->id }}" class="modal fade" tabindex="-1"
                                            aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">Edit Driver</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"> </button>
                                                    </div>
                                                    <form action="{{ route('drivers.update', $driver->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group mt-2">
                                                                <label for="name">Name</label>
                                                                <input type="text" name="name" required
                                                                    value="{{ $driver->name }}" id="name"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <label for="phone">Phone</label>
                                                                <input type="text" name="phone" required
                                                                    value="{{ $driver->phone }}" id="phone"
                                                                    class="form-control">
                                                            </div>

                                                            <div class="form-group mt-2">
                                                                <label for="address">Address</label>
                                                                <input type="text" name="address" required
                                                                    value="{{ $driver->address }}" id="address"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <label for="status">Status</label>
                                                                <select name="is_active" id="status"
                                                                    class="form-control">
                                                                    <option value="1"
                                                                        {{ $driver->is_active == '1' ? 'selected' : '' }}>
                                                                        Active</option>
                                                                    <option value="0"
                                                                        {{ $driver->is_active == '0' ? 'selected' : '' }}>
                                                                        Inactive</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

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
    <div id="new" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Create New Driver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form action="{{ route('drivers.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="name">Name</label>
                            <input type="text" name="name" required id="name" class="form-control">
                        </div>
                        <div class="form-group mt-2">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" required id="phone" class="form-control">
                        </div>
                        <div class="form-group mt-2">
                            <label for="address">Address</label>
                            <input type="text" name="address" required id="address" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
