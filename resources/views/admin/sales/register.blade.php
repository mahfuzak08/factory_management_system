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
                <div class="row">
                  <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">{{ __('admin.sales_register') }}</h4>
                        {{-- <p class="card-description"> Horizontal form layout </p> --}}
                        {{-- <form class="forms-sample">
                          <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-4 col-form-label">{{__('admin.product_name_barcode')}}</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" id="exampleInputUsername2" placeholder="{{__('admin.product_name_barcode')}}">
                            </div>
                          </div>
                        </form> --}}
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
                                <input type="text" required name="date" class="form-control" placeholder="YYYY-MM-DD" value="{{date('Y-m-d')}}">
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
                                <th width="40%">{{__('admin.product_name')}}</th>
                                <th width="15%">{{__('admin.quantity')}}</th>
                                <th width="15%">{{__('admin.price')}}</th>
                                <th width="15%">{{__('admin.total')}}</th>
                                <th width="13%">{{__('admin.action')}}</th>
                              </tr>
                            </thead>
                            <tbody id="items">
                              <tr class="item">
                                <td class="sl">1</td>
                                <td>
                                  <input type="text" name="product_name[]" class="form-control" placeholder="{{__('admin.product_name')}}">
                                </td>
                                <td>
                                  <input type="text" name="quantity[]" class="qmp quantity form-control" placeholder="{{__('admin.quantity')}}">
                                </td>
                                <td>
                                  <input type="text" name="price[]" class="qmp price form-control" placeholder="{{__('admin.price')}}">
                                </td>
                                <td>
                                  <input type="text" name="total[]" disabled class="total form-control" placeholder="{{__('admin.total')}}">
                                </td>
                                <td>
                                  <input type="hidden" name="product_id[]">
                                  <button type="button" class="add_item_row btn btn-inverse-success btn-icon">
                                    <i class="mdi mdi-plus"></i>
                                  </button>
                                </td>
                              </tr>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="4" class="text-right">{{__('admin.subtotal')}}</td>
                                <td><input type="text" name="subtotal" id="subtotal" class="form-control" placeholder="{{__('admin.subtotal')}}"></td>
                                <td></td>
                              </tr>
                              <tr>
                                <td colspan="4" class="text-right">{{__('admin.discount')}}</td>
                                <td><input type="text" name="discount" id="discount" class="form-control" placeholder="{{__('admin.discount')}}"></td>
                                <td></td>
                              </tr>
                              {{-- <tr>
                                <td colspan="4" class="text-right">Tax</td>
                                <td><input type="text" name="tax" id="tax" class="form-control" placeholder="{{__('admin.tax')}}"></td>
                                <td></td>
                              </tr> --}}
                              <tr>
                                <td colspan="4" class="text-right">{{__('admin.total')}}</td>
                                <td><input type="text" required name="total" id="total" class="form-control" placeholder="{{__('admin.total')}}"></td>
                                <td></td>
                              </tr>
                              <tr class="payment_row">
                                <td colspan="3" class="text-right">{{__('admin.receive_amount')}}</td>
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
                                <td colspan="4" class="text-right">
                                  <button type="submit" class="btn btn-rounded btn-primary btn-sm">{{ __('admin.save_now') }}</button>
                                </td>
                                <td>
                                  <button class="btn btn-rounded btn-secondary btn-sm">{{ __('admin.cancel') }}</button>
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
    @include('admin._script')
    <script>
      // customer selection
      const input = document.getElementById('customer_id');
      const datalist = document.getElementById('customer');

      input.addEventListener('input', (event) => {
        const selectedLabel = event.target.value;
        const option = [...datalist.options].find((opt) => opt.value === selectedLabel);
        if (option) {
          $('#customer_id_hidden').val(option.getAttribute('data-id'));
          $('#mobile').val(option.getAttribute('data-mobile'));
          $('#address').val(option.getAttribute('data-address'));
        }
      });

      // quantity and price multiplication
      $(document).on('change', "input.qmp", function() {
        let $tr = $(this).closest('.item');
        let q = Number($tr.find('.quantity').val());
        let p = Number($tr.find('.price').val());
        $tr.find('.total').val(q*p);
        
        let st = Number($('#subtotal').val());
        $('#subtotal').val(st+(q*p));
        st = Number($('#subtotal').val());
        $('#total').val(st);
      });
      
      // subtotal and total 
      $(document).on('change', "tfoot input", function() {
        var total = 0;
        $('.total').each(function(){
          const value = parseFloat($(this).val());
          if (!isNaN(value)) {
            total += value;
          }
        });
        
        $('#subtotal').val(total);
        let d = Number($('#discount').val());
        $('#total').val(total-d);
      });

      // add new item row
      $(document).on("click", ".add_item_row", function(){
        let rowlen = Number($("#items tr").length);
        let $tr = $(this).closest('.item');
        let $clone = $tr.clone();
        $clone.find('.sl').text(rowlen+1);
        $clone.find(':text').val('');
        $tr.after($clone);
        $(this).addClass('remove_row').removeClass('add_item_row');
        $(this).addClass('btn-inverse-danger').removeClass('btn-inverse-success');
        $(this).find('i').addClass('mdi-delete').removeClass('mdi-plus');
      });
      
      // remove item row
      $(document).on("click", ".remove_row", function(){
        let $tr = $(this).closest('.item');
        $tr.remove();
        let i = 1;
        // rearrange sl
        $("tr .sl").each(function() {
          $(this).text(i++)
        });
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