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
                  {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('add-new-customer')}}" class="btn btn-rounded btn-sm btn-success">{{__('admin.add_new')}}</a></li>
                    </ol>
                  </nav> --}}
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                              <form action="{{route('expense-report')}}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">{{__('admin.start_date')}}</label>
                                            <div class="col-sm-9">
                                                <input type="date" value="{{date('Y-m-d')}}" class="form-control" name="start_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">{{__('admin.end_date')}}</label>
                                            <div class="col-sm-9">
                                                <input type="date" value="{{date('Y-m-d')}}" class="form-control" name="end_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">{{__('admin.expense_name')}}</label>
                                            <div class="col-sm-9">
                                                <select name="expense_type" style="width: 100%">
                                                    <option value="all">All</option>
                                                    @foreach($expense as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <button name="get_data" class="btn btn-success">Search</button>
                                        </div>
                                    </div>
                                </div>
                              </form>
                              <div class="row table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> {{__('admin.sl')}} </th>
                                            <th> {{__('admin.date')}} </th>
                                            <th> {{__('admin.id')}} </th>
                                            <th> {{__('admin.expense_name')}} </th>
                                            <th> {{__('admin.account_name')}} </th>
                                            <th> {{__('admin.amount')}} </th>
                                            <th> {{__('admin.details')}} </th>
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
                                            <td><a href="{{route('sales-invoice', $row->id)}}">{{$n++}}</a></td>
                                            <td><a href="#">{{$row->trnx_date}}</a></td>
                                            <td>{{$row->id}}</td>
                                            <td>{{$row->expense_name}}</td>
                                            <td>{{$row->acc_name}}</td>
                                            <td>{{$row->amount}}</td>
                                            <td>{{$row->title}} {{$row->details}}</td>
                                          </tr>
                                        @endforeach
                                      @else
                                          <tr>
                                            <td colspan="7" class="text-center">{{__('admin.no_data_found')}}</td>
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
  </body>
</html>