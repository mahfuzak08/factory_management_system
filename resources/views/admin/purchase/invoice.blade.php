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
                        <h4 class="card-title">{{ __('admin.purchase_register') }}</h4>
                        @php
                            print_r($invoice);
                        @endphp
                        <form action="{{route('save-purchase')}}" method="POST" class="forms-sample table-responsive">
                          @csrf
                          <style>
                            .table td{
                              padding: 5px 2px;
                            }
                          </style>
                          {{-- <table class="table" style="min-width:500px">
                            <tr>
                              <td width="70%">
                                <input type="text" required name="vendor_new" list="vendor" id="vendor_id" class="form-control" placeholder="{{__('admin.vendor_name')}}">
                                <input type="hidden" name="vendor_id" id="vendor_id_hidden">
                                <datalist id="vendor">
                                  @foreach($vendor as $v)
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
                          </table> --}}
                          {{-- <table class="table">
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
                                <td colspan="4" class="text-right">Sub Totat</td>
                                <td><input type="text" name="subtotal" id="subtotal" class="form-control" placeholder="{{__('admin.subtotal')}}"></td>
                                <td></td>
                              </tr>
                              <tr>
                                <td colspan="4" class="text-right">Discount</td>
                                <td><input type="text" name="discount" id="discount" class="form-control" placeholder="{{__('admin.discount')}}"></td>
                                <td></td>
                              </tr>
                              <tr>
                                <td colspan="4" class="text-right">Total</td>
                                <td><input type="text" required name="total" id="total" class="form-control" placeholder="{{__('admin.total')}}"></td>
                                <td></td>
                              </tr>
                              <tr>
                                <td colspan="4" class="text-right">Payment Type</td>
                                <td>
                                  <select name="payment_type" required id="payment_type" style="width: 100%;">
                                  @foreach($account as $ac)
                                    <option value="{{$ac->id}}">{{$ac->name}}</option>
                                  @endforeach
                                  </select>
                                </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td colspan="4" class="text-right">Receive Amout</td>
                                <td><input type="text" required name="receive_amount" class="form-control" placeholder="{{__('admin.receive_amount')}}"></td>
                                <td></td>
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
                          </table> --}}
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
  </body>
</html>