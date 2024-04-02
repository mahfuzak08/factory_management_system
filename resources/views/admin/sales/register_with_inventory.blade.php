<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin._head')
  </head>
  <body>
    <div class="container-scroller">
      @include('admin._navbar')
      <div class="container-fluid page-body-wrapper">
        @include('admin._sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                  <h3 class="page-title">{{ __('admin.sales_register') }}</h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('sales-report')}}" class="btn btn-rounded btn-sm btn-success">{{__('admin.all_sales')}}</a></li>
                    </ol>
                  </nav>
                </div>
                <div class="row">
                  <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <table class="table" style="min-width: 500px">
                          <tr>
                            <td colspan="2" width="100%">
                              <div class="ui-widget">
                                <input type="text" id="product-search" style="width: 100%" placeholder="{{__('Scan or Type Product Info')}}" autofocus=true>
                              </div>                            
                            </td>
                          </tr>
                        </table>
                        <form action="{{route('save-sales')}}" method="POST" class="forms-sample table-responsive">
                          @csrf
                          <style>
                            .table td{
                              padding: 5px 2px;
                            }
                          </style>
                          <table class="table" style="min-width:500px">
                            <tr>
                              <td width="70%">
                                <input type="text" required name="customer_new" list="customer" id="customer_id" class="form-control" placeholder="{{__('admin.customer_name')}}">
                                <input type="hidden" name="customer_id" id="customer_id_hidden">
                                <datalist id="customer">
                                  @foreach($customer as $v)
                                    <option value="{{$v->name}}" data-id="{{$v->id}}" data-mobile="{{$v->mobile}}" data-address="{{$v->address}}">
                                  @endforeach
                                </datalist>
                              </td>
                              <td width="30%">
                                <input type="date" required name="date" class="form-control" placeholder="YYYY-MM-DD" value="{{date('d-m-Y')}}">
                              </td>
                            </tr>
                            <tr>
                              <td width="70%">
                                <input type="text" name="address" id="address" class="form-control" placeholder="{{__('admin.address')}}">
                              </td>
                              <td width="30%">
                                <input type="text" required name="mobile" id="mobile" class="form-control" placeholder="{{__('admin.mobile')}}">
                              </td>
                            </tr>
                          </table>
                          
                          <table class="table">
                            <thead>
                              <tr>
                                <th width="2%"></th>
                                <th width="20%">{{__('admin.product_name')}}</th>
                                <th width="20%">{{__('admin.product_details')}}</th>
                                <th width="15%">{{__('admin.quantity')}}</th>
                                <th width="15%">{{__('admin.price')}}</th>
                                <th width="15%">{{__('admin.total')}}</th>
                                <th width="13%">{{__('admin.action')}}</th>
                              </tr>
                            </thead>
                            <tbody id="items">
                            </tbody>
                            <tfoot>
                              {{-- <tr>
                                <td colspan="5" class="text-right">{{__('admin.subtotal')}}</td>
                                <td><input type="text" name="subtotal" id="subtotal" class="form-control" placeholder="{{__('admin.subtotal')}}"></td>
                                <td></td>
                              </tr> --}}
                              {{-- <tr>
                                <td colspan="5" class="text-right">{{__('admin.discount')}}</td>
                                <td><input type="text" name="discount" id="discount" class="form-control" placeholder="{{__('admin.discount')}}"></td>
                                <td></td>
                              </tr> --}}
                              {{-- <tr>
                                <td colspan="4" class="text-right">Tax</td>
                                <td><input type="text" name="tax" id="tax" class="form-control" placeholder="{{__('admin.tax')}}"></td>
                                <td></td>
                              </tr> --}}
                              <tr>
                                <td colspan="5" class="text-right">{{__('admin.total')}}</td>
                                <td><input type="text" required name="total" id="total" class="form-control" placeholder="{{__('admin.total')}}"></td>
                                <td></td>
                              </tr>
                              <tr class="payment_row">
                                <td colspan="4" class="text-right">{{__('admin.receive_amount')}}</td>
                                <td>
                                  <select name="payment_type[]" required id="payment_type" style="width: 100%;">
                                  @foreach($account as $ac)
                                    <option value="{{$ac->id}}">{{$ac->name}}</option>
                                  @endforeach
                                  </select>
                                </td>
                                <td>
                                  <input type="text" required name="receive_amount[]" class="form-control" placeholder="{{__('admin.receive_amount')}}">
                                </td>
                                <td>
                                  <button type="button" class="add_payment_row btn btn-inverse-success btn-icon">
                                    <i class="mdi mdi-plus"></i>
                                  </button>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="5" class="text-right">
                                  @if(hasModuleAccess("Sales_Add"))
                                  <button type="submit" class="btn btn-rounded btn-primary btn-sm">{{ __('admin.save_now') }}</button>
                                  @else
                                  <a class="btn btn-rounded btn-secondary btn-sm">{{ __('admin.save_now') }}</a>
                                  @endif
                                </td>
                                <td>
                                  <a onclick="history.back()" class="btn btn-sm btn-rounded btn-secondary">{{ __('admin.cancel') }}</a>
                                </td>
                                <td></td>
                              </tr>
                            </tfoot>
                          </table>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          @include('admin._footer')
        </div>
      </div>
    </div>
    <table class="hidden">
      <tr id="rowsample" class="item hidden">
        <td class="sl">1</td>
        <td>
          <input type="text" disabled class="product_name form-control">
          <input type="hidden" name="product_name[]" class="product_name">
        </td>
        <td>
          <input type="text" disabled class="product_details form-control">
          <input type="hidden" name="product_details[]" class="product_details">
        </td>
        <td>
          <input type="text" name="quantity[]" onblur="adjust_price()" class="qmp quantity form-control" placeholder="{{__('admin.quantity')}}">
        </td>
        <td>
          <input type="text" name="price[]" onblur="adjust_price()" class="qmp price form-control" placeholder="{{__('admin.price')}}">
        </td>
        <td>
          <input type="text" name="total[]" disabled class="total form-control" placeholder="{{__('admin.total')}}">
        </td>
        <td>
          <input type="hidden" name="product_id[]" class="product_id">
          <button type="button" class="remove_row btn btn-inverse-danger btn-icon">
            <i class="mdi mdi-delete"></i>
          </button>
        </td>
      </tr>
    </table>
    @include('admin._script')
    <script>
      // customer selection
      const input = document.getElementById('customer_id');
      const datalist = document.getElementById('customer');

      input.addEventListener('input', (event) => {
        let selectedLabel = event.target.value;
        let option = [...datalist.options].find((opt) => opt.value === selectedLabel);
        if (option) {
          $('#customer_id_hidden').val(option.getAttribute('data-id'));
          $('#mobile').val(option.getAttribute('data-mobile'));
          $('#address').val(option.getAttribute('data-address'));
        }
      });
      
      // product selection
      $(function() {
        $("#product-search").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('autocomplete_product_search') }}",
                    dataType: "json",
                    data: {
                        query: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.name + ' - ' + item.category_name + ' - ' + item.size,
                                value: item,
                                id: item.id
                            };
                        }));
                    }
                });
            },
            minLength: 2, // Minimum characters to trigger autocomplete
            select: function(event, ui) {
                // Do something when a product is selected
                let already = false;
                $("#items .item").each(function(){
                  if($(this).find('.product_id').val() === ui.item.value.id + '@' + ui.item.value.variant_id){
                    already = true;
                    $(this).find('.quantity').val(Number($(this).find('.quantity').val()) + 1);
                  }
                });
                
                if(already === false){
                  let rowsample = $("#rowsample");
                  let rowlen = Number($("#items tr").length);
                  let clonedRow = rowsample.clone(); // Clone the last row
                  clonedRow.find('.sl').text(rowlen+1); // row number
                  clonedRow.removeClass('hidden'); // remove hidden class
                  clonedRow.find('input[type="text"]').val(''); // clear text field
                  clonedRow.find('.product_id').val(ui.item.value.id + '@' + ui.item.value.variant_id); // add product name
                  clonedRow.find('.product_name').val(ui.item.value.size ? ui.item.value.name + "(" + ui.item.value.size + ")" : ui.item.value.name); // add product name
                  clonedRow.find('.product_details').val(ui.item.value.description); // add product description
                  clonedRow.find('.quantity').val(1); // add product quantity
                  clonedRow.find('.price').val(ui.item.value.price); // add product price
                  
                  // Append the cloned row to the table body
                  $("#items").append(clonedRow);
                }
                adjust_price();

                $("#product-search").val(''); // Clear the input field
                return false; // Prevent the default behavior of selecting an item
            },
            close: function(event, ui) {
                // Clear the input field when the autocomplete menu is closed
                $("#product-search").val('');
            }
        });
    });

      function adjust_price(){
        $('#items .item').each(function(){
          let q = Number($(this).find('.quantity').val());
          let p = Number($(this).find('.price').val());
          $(this).find('.total').val(q*p);
        });
        var total = 0;
        $('#items .total').each(function(){
          const value = parseFloat($(this).val());
          if (!isNaN(value)) {
            total += Number(value);
          }
        });
        $('#total').val(Number(total));
      }
      
      // remove item row
      $(document).on("click", ".remove_row", function(){
        let $tr = $(this).closest('.item');
        $tr.remove();
        let i = 1;
        // rearrange sl
        $("tr .sl").each(function() {
          $(this).text(i++)
        });
        adjust_price();
      });
      
      // add new payment row
      $(document).on("click", ".add_payment_row", function(){
        let $tr = $(this).closest('.payment_row');
        let $clone = $tr.clone();
        $clone.find(':text').val('');
        $tr.after($clone);
        $(this).addClass('remove_payment_row').removeClass('add_payment_row');
        $(this).addClass('btn-inverse-danger').removeClass('btn-inverse-success');
        $(this).find('i').addClass('mdi-delete').removeClass('mdi-plus');
      });
      
      // remove payment row
      $(document).on("click", ".remove_payment_row", function(){
        let $tr = $(this).closest('tr');
        $tr.remove();
      });
    </script>
  </body>
</html>