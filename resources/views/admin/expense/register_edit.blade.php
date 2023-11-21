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
                  <h3 class="page-title">{{__('admin.expense')}}</h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('expense')}}" class="btn btn-sm btn-rounded btn-secondary">{{__('admin.back')}}</a></li>
                    </ol>
                  </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-6 d-none d-md-block" id="addForm">
                                  <form class="forms-sample" method="POST" action="{{ route('save-expense-amount') }}">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{$order[0]->id}}" />
                                    <input type="hidden" name="ref_id" value="{{$order[0]->expense_id}}" />
                                    <input type="hidden" name="ref_type" value="expense" />
                                    <input type="hidden" name="redirect_url" value="expense_details/{{$order[0]->expense_id}}" />
                                    <input type="hidden" name="type" value="deposit" />
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input1" class="col-sm-3 col-form-label">{{__('admin.name')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input1" value="{{$order[0]->expense_name}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input6" class="col-sm-3 col-form-label">{{__('admin.date')}}</label>
                                      <div class="col-sm-9">
                                        <input type="date" name="tranx_date" value="{{$order[0]->trnx_date}}" class="form-control" id="input6" required>
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input8" class="col-sm-3 col-form-label">{{__('admin.enter_your_amount')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" name="amount" value="{{$order[0]->amount}}" placeholder="{{__('admin.enter_your_amount')}}" required class="form-control" id="input8">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input9" class="col-sm-3 col-form-label">{{__('admin.account_name')}}</label>
                                      <div class="col-sm-9">
                                        <select class="form-select" name="account_id" id="input9" aria-label="Default select example">
                                          @foreach($account as $bank)
                                            <option value="{{$bank->id}}" {{$order[0]->account_id == $bank->id ? 'selected' : ''}}>{{$bank->name}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input8" class="col-sm-3 col-form-label">{{__('admin.title')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" name="title" value="{{$order[0]->title}}" placeholder="{{__('admin.title')}}" class="form-control" id="input8">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input8" class="col-sm-3 col-form-label">{{__('admin.details')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" name="details" value="{{$order[0]->details}}" placeholder="{{__('admin.details')}}" class="form-control" id="input8">
                                      </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2 float-end">{{ __('admin.update') }}</button>
                                    <a href="{{route('expense-details', $order[0]->expense_id)}}" class="btn btn-secondary me-2 float-end">{{ __('admin.cancel') }}</a>
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
  </body>
</html>