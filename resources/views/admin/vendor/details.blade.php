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
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="forms-sample">
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input1" class="col-sm-3 col-form-label">{{__('admin.name')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input1" value="{{$vendor[0]->name}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input2" class="col-sm-3 col-form-label">{{__('admin.mobile')}}</label>
                                      <div class="col-sm-9">
                                        <input type="email" class="form-control form-control-border-off" disabled="true" id="input2" value="{{$vendor[0]->mobile}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input3" class="col-sm-3 col-form-label">{{__('admin.address')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input3" value="{{$vendor[0]->address}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input4" class="col-sm-3 col-form-label">{{__('admin.email')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input4" value="{{$vendor[0]->email}}">
                                      </div>
                                    </div>
                                    @php
                                    $vendor[0]->total_due = $vendor[0]->total_due >= 0 ? $vendor[0]->total_due : 0;
                                    $vendor[0]->cy_due = $vendor[0]->cy_due >= 0 ? $vendor[0]->cy_due : 0;
                                    @endphp
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input5" class="col-sm-3 col-form-label">{{__('admin.balance')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input5" value="{{number_format($vendor[0]->total_due, 2)}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label class="col-sm-3 col-form-label">{{__('admin.total_payment')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" value="{{number_format($vendor[0]->total_pay * -1, 2)}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label class="col-sm-3 col-form-label">{{__('admin.total')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" value="{{number_format($vendor[0]->total_due + ($vendor[0]->total_pay * -1), 2)}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input5" class="col-sm-3 col-form-label">{{__('admin.current_due')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input5" value="{{number_format($vendor[0]->cy_due, 2)}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label class="col-sm-3 col-form-label">{{__('admin.current_payment')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" value="{{number_format($vendor[0]->cy_pay * -1, 2)}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label class="col-sm-3 col-form-label">{{__('admin.total')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" value="{{number_format($vendor[0]->cy_due + ($vendor[0]->cy_pay * -1), 2)}}">
                                      </div>
                                    </div>
                                    @if($vendor[0]->cy_due == 0 && ($vendor[0]->cy_pay)*-1 >= 0)
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <button class="btn btn-danger me-2 float-end">{{__('admin.payment')}}</button>
                                    </div>
                                    @endif
                                  </div>
                                </div>
                                <div class="col-md-6 d-none d-md-block" id="addForm">
                                  @if(hasModuleAccess('Vendor_Transection_Add'))
                                  <form class="forms-sample" method="POST" action="{{ route('save-vendor-amount') }}">
                                    @csrf
                                    <input type="hidden" name="ref_id" value="{{$vendor[0]->id}}" />
                                    <input type="hidden" name="ref_type" value="vendor" />
                                    <input type="hidden" name="redirect_url" value="vendor_details/{{$vendor[0]->id}}" />
                                    <input type="hidden" name="type" value="withdraw" />
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input6" class="col-sm-3 col-form-label">{{__('admin.date')}}</label>
                                      <div class="col-sm-9">
                                        <input type="date" name="tranx_date" class="form-control" id="input6" value="{{date('d-m-Y')}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input7" class="col-sm-3 col-form-label">{{__('admin.received_by')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control" name="note" id="input7" placeholder="{{__('admin.received_by')}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input8" class="col-sm-3 col-form-label">{{__('admin.enter_your_amount')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" name="amount" placeholder="{{__('admin.enter_your_amount')}}" required class="form-control" id="input8">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input9" class="col-sm-3 col-form-label">{{__('admin.account_name')}}</label>
                                      <div class="col-sm-9">
                                        <select class="form-select" name="account_id" id="input9" aria-label="Default select example">
                                          @foreach($banks as $bank)
                                          <option value="{{$bank->id}}">{{$bank->name}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2 float-end">{{ __('admin.save_now') }}</button>
                                  </form>
                                  @endif
                                </div>
                                <div class="col-md-6 d-block d-md-none text-center">
                                  <br />
                                  <a onclick="openForm()" class="btn btn-sm btn-rounded btn-info">{{__('admin.add_new')}}</a>
                                </div>
                                <div class="col-12">
                                  <br />
                                  <hr />
                                  <br />
                                  <form action="{{route('vendor-details', $vendor[0]->id)}}" method="GET">
                                    @csrf
                                    @php 
                                    $sv = isset($_GET['search']) ? $_GET['search'] : '';
                                    @endphp
                                    <div class="row">
                                      <input type="text" name="search" class="col-12 col-md-10" value="{{$sv}}" placeholder="{{__('admin.what_you_want_to_find')}}">
                                      <button type="submit" class="col-12 col-md-2 btn btn-info">{{__('admin.find')}}</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              <br />
                              <hr />
                              <div class="row table-responsive">
                                @php 
                                $total = 0;
                                @endphp
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{__('admin.sl')}}</th>
                                            <th>{{__('admin.date')}}</th>
                                            <th>{{__('admin.account_name')}}</th>
                                            <th>{{__('admin.details')}}</th>
                                            <th class="text-right">{{__('admin.enter_your_amount')}}</th>
                                            <th>{{__('admin.action')}}</th>
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
                                            <td>{{date('d-m-Y', strtotime($row->tranx_date))}}</td>
                                            <td>{{$row->bank_name}}</td>
                                            <td>{{$row->note}}</td>
                                            <td class="text-right">{{number_format($row->amount, 2)}}</td>
                                            <td>
                                              @if($row->ref_tranx_type != 'purchase_order')
                                                @if(hasModuleAccess('Vendor_Transection_Edit'))
                                                  <a href="{{route('vendor-trnx-edit', $row->id)}}" class="btn btn-warning btn-rounded btn-sm">{{__('admin.edit')}}</a> 
                                                @endif
                                                @if(hasModuleAccess('Vendor_Transection_Delete'))
                                                  <a href="{{route('vendor-trnx-delete', $row->id)}}" class="btn btn-danger btn-rounded btn-sm" onclick="return confirm('Are you sure, you want to delete?')">{{__('admin.delete')}}</a>
                                                @endif
                                              @endif
                                            </td>
                                          </tr>
                                          @php 
                                          $total += $row->amount;
                                          @endphp
                                        @endforeach
                                      @else
                                          <tr>
                                            <td colspan="6" class="text-center">{{__('admin.no_data_found')}}</td>
                                          </tr>
                                      @endif
                                    </tbody>
                                    <tfoot>
                                      <tr>
                                        <td colspan="4">Total</td>
                                        <td class="text-right">{{number_format($total, 2)}}</td>
                                        <td></td>
                                      </tr>
                                    </tfoot>
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