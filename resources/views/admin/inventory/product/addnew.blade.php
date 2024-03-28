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
                  <h3 class="page-title"> {{ __('admin.add_product') }} </h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a onclick="history.back()" class="btn btn-sm btn-rounded btn-secondary">{{__('admin.back')}}</a></li>
                    </ol>
                  </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form class="forms-sample" method="POST" action="{{ route('save-item') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputName1">{{ __('admin.product_name') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName1" name="name" placeholder="{{ __('admin.product_name') }}" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName2">{{ __('admin.details') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName2" name="description" placeholder="{{ __('admin.details') }}">
                                    </div>
                                    <div class="form-group">
                                      <label for="cat">{{ __('admin.category') }}</label>
                                      <select id="cat" style="width: 100%;" name="category_id" required="true">
                                          <option value="">{{ __('Select Category') }}</option>
                                              @foreach($categories as $cat)
                                                  <option value="{{ $cat->id }}">{{$cat->name}}</option>
                                              @endforeach
                                      </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="size-check">
                                          <input name="size_check" type="checkbox" id="size-check" value="1"> {{ __('admin.Allow_Product_Sizes_Color') }}
                                        </label>
                                    </div>
                                    <div class="form-group hidden" id="size-display">
                                      <div class="row">
                                        <div class="col-3">
                                          <label for="Size_Name">
                                            {{ __('admin.Size_Name') }}
                                            <span>
																							{{ __('(eg. S,M,L,1Kg,5Kg etc)') }}
																						</span>
                                          </label>
                                          <input type="text" class="form-control sizename" name="sizes[]" placeholder="{{ __('admin.Size_Name') }}">
                                        </div>
                                        <div class="col-3">
                                          <label for="Color">
                                            {{ __('admin.Color') }}
                                            <span>
																							{{ __('(eg. Red, Green, Blue etc)') }}
																						</span>
                                          </label>
                                          <input type="text" class="form-control colorname" name="colors[]" placeholder="{{ __('admin.Color') }}">
                                        </div>
                                        <div class="col-1">
                                          <label for="quantity">{{ __('admin.quantity') }}</label>
                                          <input type="text" class="form-control quantity" name="qtys[]" placeholder="Qty">
                                        </div>
                                        <div class="col-2">
                                          <label for="price">{{__('admin.purchase')}} {{ __('admin.price') }}</label>
                                          <input type="text" class="form-control price" name="buyprices[]" placeholder="{{__('admin.purchase')}} {{ __('admin.price') }}">
                                        </div>
                                        <div class="col-2">
                                          <label for="price">{{__('admin.sales')}} {{ __('admin.price') }}</label>
                                          <input type="text" class="form-control price" name="saleprices[]" placeholder="{{__('admin.sales')}} {{ __('admin.price') }}">
                                        </div>
                                        <div class="col-1">
                                          <br />
                                          <button type="button" class="add_item_row btn btn-inverse-success btn-icon">
                                            <i class="mdi mdi-plus"></i>
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group" id="stckprod">
                                      <div class="row">
                                        <div class="col-3">
                                          <label for="productmeasure">{{ __('admin.Product_Measurement') }}</label>
                                          <input list="product_measure" name="size" id="productmeasure">
                                          <datalist id="product_measure">
                                            <option value="Gram">{{ __('Gram') }}</option>
                                            <option value="Kilogram">{{ __('Kilogram') }}</option>
                                            <option value="Litre">{{ __('Litre') }}</option>
                                            <option value="Pound">{{ __('Pound') }}</option>
                                            <option value="Pcs">{{ __('Pcs') }}</option>
                                          </datalist>
                                        </div>
                                        <div class="col-3">
                                          <label for="quantity">{{ __('admin.quantity') }}</label>
                                          <input type="text" class="form-control quantity" name="qty" placeholder="{{ __('admin.quantity') }}">
                                        </div>
                                        <div class="col-3">
                                          <label for="price">{{__('admin.purchase')}} {{ __('admin.price') }}</label>
                                          <input type="text" class="form-control price" name="buyprice" placeholder="{{__('admin.purchase')}} {{ __('admin.price') }}">
                                        </div>
                                        <div class="col-3">
                                          <label for="price">{{__('admin.sales')}} {{ __('admin.price') }}</label>
                                          <input type="text" class="form-control price" name="saleprice" placeholder="{{__('admin.sales')}} {{ __('admin.price') }}">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="batchno">{{ __('admin.batchno') }}</label>
                                        <input type="text" class="form-control" id="batchno" name="batchno" placeholder="{{ __('admin.batchno') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="slno">{{ __('admin.slno') }}
                                          <span>
                                            {{ __('(eg. 10011; 10012; 10013; 10014 etc)') }}
                                          </span>
                                        </label>
                                        <input type="text" class="form-control" id="slno" name="slno" placeholder="{{ __('admin.slno') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="expirydate">{{ __('admin.expirydate') }}</label>
                                        <input type="date" class="form-control" id="expirydate" name="expirydate" placeholder="{{ __('admin.expirydate') }}">
                                    </div>
                                    <button type="submit" class="btn btn-rounded btn-primary btn-sm me-2">{{ __('admin.save_now') }}</button><br><br>
                                    <a onclick="history.back()" class="btn btn-sm btn-rounded btn-secondary">{{ __('admin.cancel') }}</a>
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
      $("#size-check").change(function() {
          if(this.checked) {
              $("#size-display").show();
              $("#stckprod").hide();
          }
          else
          {
              $("#size-display").hide();
              $("#stckprod").show();

          }
      });

      // add new item row
      $(document).on("click", ".add_item_row", function(){
        let $row = $(this).closest('.row');
        let $clone = $row.clone();
        $clone.find(':text').val('');
        $row.after($clone);
        $(this).addClass('remove_row').removeClass('add_item_row');
        $(this).addClass('btn-inverse-danger').removeClass('btn-inverse-success');
        $(this).find('i').addClass('mdi-delete').removeClass('mdi-plus');
      });
      // remove item row
      $(document).on("click", ".remove_row", function(){
        let $row = $(this).closest('.row');
        $row.remove();
      });
    </script>
  </body>
</html>