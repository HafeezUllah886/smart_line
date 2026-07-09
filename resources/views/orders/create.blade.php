@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header d-flex justify-content-between">
                    <h5>Create Order</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="post">
                        @csrf
                        <div class="row g-1">
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" id="date" class="form-control"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <select name="product" class="select2 w-100">
                                        <option value=""></option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="driver">Driver</label>
                                    <select name="driver" class="select2 w-100" id="driver">
                                        <option value=""></option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vehicle_no">Vehicle No.</label>
                                    <input type="text" name="vehicle_no" id="vehicle_no" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <h5 class="text-muted"><small>Purchase Details</small></h5>
                                <hr class="my-2">
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label for="supplier">Supplier</label>
                                    <select name="supplier" class="select2 w-100">
                                        <option value=""></option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="qty">Details</label>
                                    <div class="input-group">
                                    <input type="number" step="any" min="0" name="purchase_price" placeholder="Price" id="purchase_price" class="form-control">
                                    <input type="number" step="any" min="0" name="purchase_qty" placeholder="Qty" id="purchase_qty" class="form-control">
                                    <input type="number" readonly step="any" min="0" name="purchase_amount" placeholder="Amount" id="purchase_amount" class="form-control">
                                    </div>
                                </div>
                            </div>
                             
                              <div class="col-md-3">
                                <div class="form-group">
                                    <label for="purchase_account">Purchase Account</label>
                                    <select name="purchase_account" id="purchase_account" class="select2 w-100">
                                        <option value="">Pending</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <h5 class="text-muted"><small>Sale Details</small></h5>
                                <hr class="my-2">
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label for="customer">Customer</label>
                                    <select name="customer" class="select2 w-100">
                                        <option value=""></option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="qty">Details</label>
                                    <div class="input-group">
                                    <input type="number" step="any" min="0" name="sale_price" placeholder="Price" id="sale_price" class="form-control">
                                    <input type="number" step="any" min="0" name="sale_qty" placeholder="Qty" id="sale_qty" class="form-control">
                                    <input type="number" readonly step="any" min="0" name="sale_amount" placeholder="Amount" id="sale_amount" class="form-control">
                                    </div>
                                </div>
                            </div>
                             
                              <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sale_account">Sale Account</label>
                                    <select name="sale_account" id="sale_account" class="select2 w-100">
                                        <option value="">Pending</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             <div class="col-12">
                                <h5 class="text-muted"><small>Check Posts Details</small></h5>
                                <hr class="my-2">
                            </div>
                           
                            <div class="col-12">
                                 
                                <div class="form-group">
                                    <label for="checkpost">Check Post</label>
                                    <select name="checkpost" id="checkpost" class="select2 w-100">
                                        <option value=""></option>
                                        @foreach ($checkposts as $checkpost)
                                            <option value="{{ $checkpost->id }}">{{ $checkpost->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                           

                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th width="30%">Post</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Payment</th>
                                       
                                        <th></th>
                                    </thead>
                                    <tbody id="posts_list"></tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-end">Total</th>
                                            <th class="text-end" id="totalPostAmount">0.00</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="comp">Inv No.</label>
                                    <input type="text" name="inv" id="inv" class="form-control">
                                </div>
                            </div>
                           
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary w-100">Create Order</button>
                            </div>
                </div>
            </form>
                </div>
            </div>
        </div>
        <!-- Default Datatable end -->
    </div>
@endsection
@section('page-css')
<link href="{{ asset('assets/vendor/select/select2.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('page-js')
<script src="{{ asset('assets/vendor/select/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
         $('#checkpost').select2({
                placeholder: "Select a Checkpost",
                allowClear: true,
                width: '100%'
            });
       
    });

     $("#checkpost").on('select2:select', function(e) {
            var value = e.params.data.id;
            if (value) {
                getSinglePost(value);
                $(this).val(null).trigger('change');
                $(this).select2('open');
            }
        });

        var existingPosts = [];

        function getSinglePost(id) {
            $.ajax({
                url: "{{ url('orders/getcheckpost/') }}/" + id,
                method: "GET",
                success: function(post) {
                    let found = $.grep(existingPosts, function(element) {
                        return element === post.id;
                    });
                    if (found.length > 0) {

                    } else {
                        var id = post.id;
                        var html = '<tr id="row_' + id + '">';
                        html += '<td class="p-1">' + post.title + '</td>';
                        html += '<td class="p-0"><input type="number" name="post_amount[]" oninput="updateTotal()" step="any" value="0" min="0" class="form-control form-control-sm text-center p-1" id="post_amount_' + id + '"></td>';
                        html += '<td class="p-0"><select name="post_payment[]" id="post_payment_' + id + '" class="form-control form-control-sm text-center p-1 w-100"><option value="pending">Pending</option><option value="bydriver">By Driver</option><option value="byowner">By Owner</option></select></td>';
                        html += '<td class="p-0"> <span class="btn btn-sm btn-danger" onclick="deleteRow('+id+')">X</span> </td>';
                        html += '<input type="hidden" name="post_id[]" value="' + id + '">';
                        html += '</tr>';
                        $("#posts_list").prepend(html);
                        existingPosts.push(id);
                        updateTotal();
                    }
                }
            });
        }
        
        function updateTotal() {
            var total = 0;
            $("input[id^='post_amount_']").each(function() {
                var inputId = $(this).attr('id');
                var inputValue = $(this).val();
                total += parseFloat(inputValue);
            });

            $("#totalPostAmount").html(total.toFixed(2));
        }
        function deleteRow(id) {
            existingPosts = $.grep(existingPosts, function(value) {
                return value !== id;
            });
            $('#row_'+id).remove();
            updateTotal();
        }
</script>
@endsection
