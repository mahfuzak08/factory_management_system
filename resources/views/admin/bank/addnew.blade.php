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
                  <h3 class="page-title"> {{ __('admin.accounts') }} </h3>
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
                                <form class="forms-sample" method="POST" action="{{ route('save-account') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputName1">{{ __('admin.account_name') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName1" name="name" placeholder="{{ __('admin.account_name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName5">{{ __('admin.account_type') }}</label>
                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="type" id="exampleInputName51" value="Cash" checked="true"> {{__('admin.cash')}} <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="type" id="exampleInputName52" value="Due"> {{__('admin.due')}} <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName2">{{ __('admin.bank_name') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName2" name="bank_name" placeholder="{{ __('admin.bank_name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName6">{{ __('admin.bank_address') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName6" name="bank_address" placeholder="{{ __('admin.bank_address') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName7">{{ __('admin.bank_acc_no') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName7" name="acc_no" placeholder="{{ __('admin.bank_acc_no') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName3">{{ __('admin.currency') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName3" name="currency" placeholder="{{ __('admin.BDT') }}" value="{{ __('admin.BDT') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName4">{{ __('admin.opening_balance') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName4" name="opening_balance" placeholder="{{ __('admin.opening_balance') }}">
                                    </div>
                              
                                    <button type="submit" class="btn btn-rounded btn-gradient-primary btn-sm me-2">{{ __('admin.save_now') }}</button><br><br>
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