@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header d-flex justify-content-between">
                    <h5>Edit Order: #{{ $order->inv }}</h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.update', $order->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row g-1">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" id="date" class="form-control"
                                        value="{{ date('Y-m-d', strtotime($order->date)) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <select name="product" class="select2 w-100">
                                        <option value=""></option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ $order->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
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
                                            <option value="{{ $driver->id }}" {{ $order->driver_id == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="vehicle_no">Vehicle No.</label>
                                    <input type="text" name="vehicle_no" id="vehicle_no" class="form-control" value="{{ $order->vehicle_no }}">
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
                                            <option value="{{ $supplier->id }}" {{ $order->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="qty">Details</label>
                                    <div class="input-group">
                                        <input type="number" step="any" min="0" name="purchase_price"
                                            placeholder="Price" value="{{ $order->purchase_price }}" oninput="updateTotal()" id="purchase_price"
                                            class="form-control">
                                        <input type="number" step="any" min="0" name="purchase_qty"
                                            placeholder="Qty" value="{{ $order->purchase_qty }}" oninput="updateTotal()" id="purchase_qty"
                                            class="form-control">
                                        <input type="number" readonly step="any" min="0" name="purchase_amount"
                                            placeholder="Amount" value="{{ $order->purchase_amount }}" id="purchase_amount" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="purchase_account">Purchase Account</label>
                                    <select name="purchase_account" id="purchase_account" class="select2 w-100">
                                        <option value="">Pending</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $order->purchase_account_id == $account->id ? 'selected' : '' }}>{{ $account->title }}</option>
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
                                            <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="qty">Details</label>
                                    <div class="input-group">
                                        <input type="number" step="any" min="0" name="sale_price"
                                            placeholder="Price" value="{{ $order->sale_price }}" id="sale_price" oninput="updateTotal()"
                                            class="form-control">
                                        <input type="number" step="any" min="0" name="sale_qty"
                                            placeholder="Qty" value="{{ $order->sale_qty }}" id="sale_qty" oninput="updateTotal()"
                                            class="form-control">
                                        <input type="number" readonly step="any" min="0" name="sale_amount"
                                            placeholder="Amount" value="{{ $order->sale_amount }}" id="sale_amount" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sale_account">Sale Account</label>
                                    <select name="sale_account" id="sale_account" class="select2 w-100">
                                        <option value="">Pending</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $order->sale_account_id == $account->id ? 'selected' : '' }}>{{ $account->title }}</option>
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
                                            <th class="text-end" id="totalPostAmount">{{ number_format($order->route_expense, 2) }}</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="col-12">
                                <h5 class="text-muted"><small>Other Route Expenses</small></h5>
                                <hr class="my-2">
                            </div>

                            <div class="col-12">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th width="30%">Category</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Notes</th>
                                        <th class="text-center"><button type="button" class="btn btn-sm btn-success" onclick="addExpenseRow()">+</button></th>
                                    </thead>
                                    <tbody id="extra_expenses_list"></tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-end">Total</th>
                                            <th class="text-center" id="totalExtraExpenseAmount">0.00</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label for="comp">Sales Total</label>
                                    <input type="number" id="sales_total" readonly class="form-control" value="{{ $order->sale_amount }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="comp">Purchase Total</label>
                                    <input type="number" id="purchase_total" readonly class="form-control" value="{{ $order->purchase_amount }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="comp">Route Expense</label>
                                    <input type="number" id="route_expense" readonly class="form-control" value="{{ $order->route_expense }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="comp">Profit / Loss</label>
                                    <input type="number" id="pl" readonly class="form-control" value="{{ $order->profit_loss }}">
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" cols="30" rows="5">{{ $order->notes }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary w-100">Update Order</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-css')
    <link href="{{ asset('assets/vendor/select/select2.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('page-js')
    <script src="{{ asset('assets/vendor/select/select2.min.js') }}"></script>
    <script>
        var existingPosts = [];

        $(document).ready(function() {
            $('.select2').select2();
            $('#checkpost').select2({
                placeholder: "Select a Checkpost",
                allowClear: true,
                width: '100%'
            });

            @foreach($order->expenses as $expense)
                addExistingPost({{ $expense->post_id }}, '{{ $expense->post->title ?? 'N/A' }}', {{ $expense->amount }}, '{{ $expense->payment }}');
            @endforeach
            
            @foreach($order->extraExpenses as $extra)
                addExistingExpenseRow('{{ $extra->expense_category_id }}', '{{ $extra->amount }}', '{{ addslashes($extra->notes) }}');
            @endforeach

            updateTotal();
        });

        $("#checkpost").on('select2:select', function(e) {
            var value = e.params.data.id;
            if (value) {
                getSinglePost(value);
                $(this).val(null).trigger('change');
                $(this).select2('open');
            }
        });

        function getSinglePost(id) {
            $.ajax({
                url: "{{ url('orders/getcheckpost/') }}/" + id,
                method: "GET",
                success: function(post) {
                    let found = $.grep(existingPosts, function(element) {
                        return element === post.id;
                    });
                    if (found.length > 0) {
                        // Already exists
                    } else {
                        addExistingPost(post.id, post.title, 0, 'pending');
                        updateTotal();
                    }
                }
            });
        }

        function addExistingPost(id, title, amount, payment) {
            var html = '<tr id="row_' + id + '">';
            html += '<td class="p-1">' + title + '</td>';
            html += '<td class="p-0"><input type="number" name="post_amount[]" oninput="updateTotal()" step="any" value="'+amount+'" min="0" class="form-control form-control-sm text-center p-1" id="post_amount_' + id + '"></td>';
            html += '<td class="p-0"><select name="post_payment[]" id="post_payment_' + id + '" class="form-control form-control-sm text-center p-1 w-100">';
            html += '<option value="pending" '+(payment == "pending" ? "selected" : "")+'>Pending</option>';
            html += '<option value="bydriver" '+(payment == "bydriver" ? "selected" : "")+'>By Driver</option>';
            html += '<option value="byowner" '+(payment == "byowner" ? "selected" : "")+'>By Owner</option>';
            html += '</select></td>';
            html += '<td class="p-0"> <span class="btn btn-sm btn-danger" onclick="deleteRow(' + id + ')">X</span> </td>';
            html += '<input type="hidden" name="post_id[]" value="' + id + '">';
            html += '</tr>';
            $("#posts_list").prepend(html);
            existingPosts.push(id);
        }

        function updateTotal() {
            var total = 0;
            $("input[id^='post_amount_']").each(function() {
                var inputId = $(this).attr('id');
                var inputValue = $(this).val();
                total += parseFloat(inputValue);
            });

            $("#totalPostAmount").html(total.toFixed(2));

            var extra_total = 0;
            $("input[name='expense_amount[]']").each(function() {
                var inputValue = $(this).val();
                if(inputValue) {
                    extra_total += parseFloat(inputValue);
                }
            });
            $("#totalExtraExpenseAmount").html(extra_total.toFixed(2));

            var sale_price = parseFloat($("#sale_price").val()) || 0;
            var sale_qty = parseFloat($("#sale_qty").val()) || 0;
            var purchase_price = parseFloat($("#purchase_price").val()) || 0;
            var purchase_qty = parseFloat($("#purchase_qty").val()) || 0;

            var sale_amount = sale_price * sale_qty;
            var purchase_amount = purchase_price * purchase_qty;

            $("#sale_amount").val(sale_amount.toFixed(2));
            $("#purchase_amount").val(purchase_amount.toFixed(2));

            $("#purchase_total").val(purchase_amount.toFixed(2));
            $("#sales_total").val(sale_amount.toFixed(2));
            $("#route_expense").val((total + extra_total).toFixed(2));
            $("#pl").val((sale_amount - purchase_amount - total - extra_total).toFixed(2));
        }

        function deleteRow(id) {
            existingPosts = $.grep(existingPosts, function(value) {
                return value !== id;
            });
            $('#row_' + id).remove();
            updateTotal();
        }

        var expenseCategoriesOptions = '<option value=""></option>';
        @foreach($expenseCategories as $category)
            expenseCategoriesOptions += '<option value="{{ $category->id }}">{{ $category->name }}</option>';
        @endforeach

        var expenseRowId = 0;
        function addExpenseRow() {
            expenseRowId++;
            var html = '<tr id="exp_row_' + expenseRowId + '">';
            html += '<td class="p-1"><select name="expense_category_id[]" class="form-control form-control-sm" required>' + expenseCategoriesOptions + '</select></td>';
            html += '<td class="p-1"><input type="number" name="expense_amount[]" oninput="updateTotal()" step="any" value="0" min="0" class="form-control form-control-sm text-center"></td>';
            html += '<td class="p-1"><input type="text" name="expense_notes[]" class="form-control form-control-sm"></td>';
            html += '<td class="p-1 text-center"><button type="button" class="btn btn-sm btn-danger" onclick="deleteExpenseRow(' + expenseRowId + ')">X</button></td>';
            html += '</tr>';
            $("#extra_expenses_list").append(html);
        }

        function addExistingExpenseRow(categoryId, amount, notes) {
            expenseRowId++;
            
            // Build options and pre-select
            var options = '<option value=""></option>';
            @foreach($expenseCategories as $category)
                options += '<option value="{{ $category->id }}" ' + (categoryId == "{{ $category->id }}" ? "selected" : "") + '>{{ $category->name }}</option>';
            @endforeach

            var html = '<tr id="exp_row_' + expenseRowId + '">';
            html += '<td class="p-1"><select name="expense_category_id[]" class="form-control form-control-sm" required>' + options + '</select></td>';
            html += '<td class="p-1"><input type="number" name="expense_amount[]" oninput="updateTotal()" step="any" value="'+amount+'" min="0" class="form-control form-control-sm text-center"></td>';
            html += '<td class="p-1"><input type="text" name="expense_notes[]" value="'+notes+'" class="form-control form-control-sm"></td>';
            html += '<td class="p-1 text-center"><button type="button" class="btn btn-sm btn-danger" onclick="deleteExpenseRow(' + expenseRowId + ')">X</button></td>';
            html += '</tr>';
            $("#extra_expenses_list").append(html);
        }

        function deleteExpenseRow(id) {
            $('#exp_row_' + id).remove();
            updateTotal();
        }
    </script>
@endsection
