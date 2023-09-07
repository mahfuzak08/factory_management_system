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
                  <h3 class="page-title">{{__('admin.account_details')}}</h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('bank_account')}}" class="btn btn-sm btn-rounded btn-secondary">{{__('admin.back')}}</a></li>
                    </ol>
                  </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <b>{{__('admin.account_name')}}:</b> {{$bank->name}}<hr />
                                  <b>{{__('admin.balance')}}:</b> {{$balance}} {{$bank->currency}}<hr />
                                  <b>{{__('admin.bank_name')}}:</b> {{$bank->bank_name}}<hr />
                                  <b>{{__('admin.account_type')}}:</b> {{$bank->type}}<hr />
                                  <b>{{__('admin.bank_address')}}:</b> {{$bank->bank_address}}<hr />
                                  <b>{{__('admin.bank_acc_no')}}:</b> {{$bank->acc_no}}<hr />
                                </div>
                                <div class="col-md-6 d-none d-md-block" id="addForm">
                                  <form class="forms-sample" method="POST" action="{{ route('save-amount') }}">
                                    @csrf
                                    <input type="hidden" name="account_id" value="{{$bank->id}}" />
                                    <div class="form-group row">
                                      <div class="col-sm-6">
                                        <input type="text" class="form-control" name="name" value="{{ $bank->name }}" disabled="true">
                                      </div>
                                      <div class="col-sm-6">
                                        <input type="text" class="form-control" name="tranx_date" value="{{date('Y-m-d')}}">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label for="exampleInputName5" class="col-sm-4 col-form-label">{{ __('admin.tranx_type') }}</label>
                                      <div class="col-sm-4">
                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="type" id="exampleInputName51" value="deposit" checked="true"> {{__('admin.deposit')}} <i class="input-helper"></i></label>
                                        </div>
                                      </div>
                                      <div class="col-sm-4">
                                        <div class="form-check">
                                          <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="type" id="exampleInputName52" value="withdrawal"> {{__('admin.withdrawal')}} <i class="input-helper"></i></label>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-sm-6">
                                        <input type="number" class="form-control" name="amount" value="" placeholder="{{__('admin.enter_your_amount')}}">
                                      </div>
                                      <div class="col-sm-6">
                                        <input type="text" class="form-control" name="note" value="" placeholder="{{__('admin.details')}}">
                                      </div>
                                    </div>
                                    <button type="submit" class="btn btn-rounded btn-gradient-primary btn-sm me-2">{{ __('admin.save_now') }}</button>
                                  </form>
                                </div>
                                <div class="col-md-6 d-block d-md-none text-center">
                                  <br />
                                  <a onclick="openForm()" class="btn btn-sm btn-rounded btn-info">{{__('admin.add_new')}}</a>
                                </div>
                                <div class="col-12">
                                  <br />
                                  <hr />
                                  <br />
                                  <form action="{{route('account-details', $bank->id)}}" method="GET">
                                    @csrf
                                    @php 
                                    $sv = isset($_GET['search']) ? $_GET['search'] : '';
                                    @endphp
                                    
                                    <input type="text" name="search" class="col-12 col-md-9" value="{{$sv}}" placeholder="{{__('admin.what_you_want_to_find')}}">
                                    <button name="filter_btn" class="col-12 col-md-2 btn btn-sm btn-rounded btn-primary">{{__('admin.find')}}</button>
                                  </form>
                                </div>
                              </div>
                              <br />
                              <hr />
                              <div class="row table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Ref. ID</th>
                                            <th>Ref. Type</th>
                                            <th>Note</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if(count($datas) > 0)
                                        @php 
                                        if(isset($_GET['page']) && $_GET['page']>0)
                                          $n = 1 + (($_GET['page'] - 1) * 10);
                                        else
                                          $n = 1;
                                        @endphp
                                        @foreach($datas as $row)
                                          <tr>
                                            <td>{{$n++}}</td>
                                            <td>{{$row->tranx_date}}</td>
                                            <td>{{$row->ref_id}}</td>
                                            <td>{{$row->ref_type}}</td>
                                            <td>{{$row->note}}</td>
                                            <td>{{$row->amount}}</td>
                                          </tr>
                                        @endforeach
                                      @else
                                          <tr>
                                            <td colspan="6" class="text-center">{{__('admin.no_data_found')}}</td>
                                          </tr>
                                      @endif
                                    </tbody>
                                </table>
                              </div>
                              {{ $datas->onEachSide(3)->links() }}
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