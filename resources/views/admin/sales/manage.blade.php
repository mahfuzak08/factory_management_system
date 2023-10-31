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
                  <h3 class="page-title">{{__('admin.all_sales')}}</h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('sales')}}" class="btn btn-rounded btn-sm btn-success">{{__('admin.back')}}</a></li>
                    </ol>
                  </nav>
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
                                                    {{-- @foreach($expense as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach --}}
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
                                            <th> {{__('admin.inv_no')}} </th>
                                            <th> {{__('admin.inv_type')}} </th>
                                            <th> {{__('admin.customer_name')}} </th>
                                            <th> {{__('admin.quantity')}} </th>
                                            <th> {{__('admin.receive_amount')}} </th>
                                            <th> {{__('admin.due_amount')}} </th>
                                            <th> {{__('admin.total')}} </th>
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
                                            <td><a href="{{route('sales-invoice', $row->id)}}">{{$row->order_id}}</a></td>
                                            <td>{{$row->order_type}}</td>
                                            <td><a href="{{route('purchase-invoice', $row->id)}}">{{$row->customer_name}}</a></td>
                                            <td>
                                              @foreach(json_decode($row->products) as $p)
                                                  {{$p->quantity}}
                                              @endforeach
                                            </td>
                                            <td>
                                              @foreach(json_decode($row->payment) as $p)
                                                @foreach($account as $ac)
                                                  @if($p->pid == $ac->id && $ac->type != 'Due')
                                                    {{$ac->name}}: {{$p->receive_amount}}<br>
                                                  @endif
                                                @endforeach
                                              @endforeach
                                            </td>
                                            <td>
                                              @foreach(json_decode($row->payment) as $p)
                                                @foreach($account as $ac)
                                                  @if($p->pid == $ac->id && $ac->type == 'Due')
                                                    {{$p->receive_amount}}<br>
                                                  @endif
                                                @endforeach
                                              @endforeach
                                            </td>
                                            <td>{{$row->total}}</td>
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
    <script>
      function openForm(){
        $('#addForm').removeClass('d-none');
      }
    </script>
  </body>
</html>