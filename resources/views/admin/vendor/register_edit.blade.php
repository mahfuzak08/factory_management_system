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
                  <h3 class="page-title">{{__('admin.vendor')}}</h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('vendor')}}" class="btn btn-sm btn-rounded btn-secondary">{{__('admin.back')}}</a></li>
                    </ol>
                  </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-head">
                                <h3>{{__('admin.vendor')}} Transection Update</h3>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-6 d-none d-md-block" id="addForm">
                                  <form class="forms-sample" method="POST" action="{{ route('save-vendor-amount') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$order->id}}" />
                                    <input type="hidden" name="ref_id" value="{{$order->ref_id}}" />
                                    <input type="hidden" name="ref_type" value="vendor" />
                                    <input type="hidden" name="redirect_url" value="vendor_details/{{$order->ref_id}}" />
                                    <input type="hidden" name="type" value="withdraw" />
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input6" class="col-sm-3 col-form-label">{{__('admin.date')}}</label>
                                      <div class="col-sm-9">
                                        <input type="date" name="tranx_date" value={{$order->tranx_date}} class="form-control" id="input6" required>
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input7" class="col-sm-3 col-form-label">{{__('admin.Particulars')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control" name="note" id="input7" value="{{$order->note}}" placeholder="{{__('admin.Particulars')}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input8" class="col-sm-3 col-form-label">{{__('admin.enter_your_amount')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" name="amount" placeholder="{{__('admin.enter_your_amount')}}" required class="form-control" value="{{e2bn($order->amount*-1)}}" id="input8">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input9" class="col-sm-3 col-form-label">{{__('admin.account_name')}}</label>
                                      <div class="col-sm-9">
                                        <select class="form-select" name="account_id" id="input9" aria-label="Default select example">
                                          @foreach($account as $bank)
                                            @if($bank->type == 'Due' || $bank->type == 'Cash')
                                              @if($bank->name == 'Due')
                                              @else
                                                <option value="{{$bank->id}}" {{$order->account_id == $bank->id ? 'selected' : ''}} >{{$bank->name == 'Cash' ? __('admin.debit') : __('admin.credit')}}</option>
                                              @endif
                                            @endif
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2 float-end">{{ __('admin.update') }}</button>
                                    <a href="{{route('vendor-details', $order->ref_id)}}" class="btn btn-secondary me-2 float-end">{{ __('admin.cancel') }}</a>
                                  </form>
                                </div>
                              </div>
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
      function openForm(){
        $('#addForm').removeClass('d-none');
      }
    </script>
  </body>
</html>