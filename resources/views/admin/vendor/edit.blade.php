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
                  <h3 class="page-title"> {{ __('admin.vendor') }} </h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('vendor')}}" class="btn btn-sm btn-rounded btn-secondary">{{__('admin.back')}}</a></li>
                    </ol>
                  </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form class="forms-sample" method="POST" action="{{ route('edit-vendor', $vendor->id) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputName1">{{ __('admin.name') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName1" name="name" value="{{$vendor->name}}" placeholder="{{ __('admin.name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName2">{{ __('admin.mobile') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName2" name="mobile" value="{{$vendor->mobile}}" placeholder="{{ __('admin.mobile') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName6">{{ __('admin.email') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName6" name="email" value="{{$vendor->email}}" placeholder="{{ __('admin.email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName7">{{ __('admin.address') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName7" name="address" value="{{$vendor->address}}" placeholder="{{ __('admin.address') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName4">{{ __('admin.opening_balance') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName4" name="opening_balance" value="{{abs($vTrnx[0]->amount)}}" placeholder="{{ __('admin.opening_balance') }}">
                                        <input type="hidden" name="old_opening_balance" value="{{abs($vTrnx[0]->amount)}}">
                                        <input type="hidden" name="old_opening_balance_id" value="{{abs($vTrnx[0]->id)}}">
                                        <input type="hidden" name="balance" value="{{$vendor->balance}}">
                                    </div>
                              
                                    <button type="submit" class="btn btn-rounded btn-gradient-primary btn-sm me-2">{{ __('admin.update') }}</button><br><br>
                                    <button class="btn btn-rounded btn-gradient-secondary btn-sm">{{ __('admin.cancel') }}</button>
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