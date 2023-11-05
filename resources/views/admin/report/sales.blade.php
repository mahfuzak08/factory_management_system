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
                              <form action="{{route('sales-report')}}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">{{__('admin.start_date')}}</label>
                                            <div class="col-sm-9">
                                                <input type="date" value="{{@$_GET['start_date'] ? $_GET['start_date'] : date('Y-m-d')}}" class="form-control" name="start_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">{{__('admin.end_date')}}</label>
                                            <div class="col-sm-9">
                                                <input type="date" value="{{@$_GET['end_date'] ? $_GET['end_date'] : date('Y-m-d')}}" class="form-control" name="end_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">{{__('admin.customer')}}</label>
                                            <div class="col-sm-9">
                                                <select name="customer_id" style="width: 100%">
                                                    <option value="all">All</option>
                                                    @foreach($customer as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">{{__('admin.inv_no')}}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{@$_GET['inv_id']}}" name="inv_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                                            <th> {{__('admin.date')}} </th>
                                            <th> {{__('admin.customer_name')}} </th>
                                            {{-- <th> {{__('admin.inv_type')}} </th> --}}
                                            <th> {{__('admin.product_name')}} </th>
                                            <th> {{__('admin.quantity')}} </th>
                                            <th> {{__('admin.price')}} </th>
                                            <th> {{__('admin.receive_amount')}} </th>
                                            <th> {{__('admin.due_amount')}} </th>
                                            <th> {{__('admin.total')}} </th>
                                            <th> {{__('admin.action')}} </th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                      @php 
                                      $page_qty_total = 0;
                                      $page_rcv_total = 0;
                                      $page_due_total = 0;
                                      $page_total = 0;
                                      $pq = 0;
                                      $price = 0;
                                      if(isset($_GET['page']) && $_GET['page']>0)
                                        $n = 1 + (($_GET['page'] - 1) * 10);
                                      else
                                        $n = 1;
                                      @endphp
                                      @if(count($datas) > 0)
                                        @foreach($datas as $row)
                                          <tr>
                                            <td><a href="{{route('sales-invoice', $row->id)}}">{{$n++}}</a></td>
                                            <td><a href="{{route('sales-invoice', $row->id)}}">{{$row->order_id}}</a></td>
                                            <td>{{$row->date}}</td>
                                            <td><a href="{{route('sales-invoice', $row->id)}}">{{$row->customer_name}}</a></td>
                                            {{-- <td>{{$row->order_type}}</td> --}}
                                            <td>
                                              @foreach(json_decode($row->products) as $p)
                                                  {{$p->product_name}}
                                                  <br>
                                                  {{@$p->product_details}}
                                                  @php
                                                  $pq += @$p->quantity ? $p->quantity : 0;
                                                  $price += @$p->price ? $p->price : 0;
                                                  $page_qty_total += @$p->quantity;
                                                  @endphp
                                              @endforeach
                                            </td>
                                            <td>{{$pq}}</td>
                                            <td>{{$price}}</td>
                                            <td>
                                              @foreach(json_decode($row->payment) as $p)
                                                @foreach($account as $ac)
                                                  @if($p->pid == $ac->id && $ac->type != 'Due')
                                                    {{$ac->name}}: {{$p->receive_amount}}<br>
                                                    @php
                                                    $page_rcv_total += $p->receive_amount;
                                                    @endphp
                                                  @endif
                                                @endforeach
                                              @endforeach
                                            </td>
                                            <td>
                                              @foreach(json_decode($row->payment) as $p)
                                                @foreach($account as $ac)
                                                  @if($p->pid == $ac->id && $ac->type == 'Due')
                                                    {{$p->receive_amount}}<br>
                                                    @php
                                                    $page_due_total += $p->receive_amount;
                                                    @endphp
                                                  @endif
                                                @endforeach
                                              @endforeach
                                            </td>
                                            <td>
                                              {{$row->total}}
                                              @php
                                              $page_total += $row->total;
                                              $pq = 0;
                                              $price = 0;
                                              @endphp
                                            </td>
                                            <td>
                                              <a href="{{route('sales-trnx-edit', $row->id)}}" class="btn btn-warning btn-rounded btn-sm">{{__('admin.edit')}}</a> 
                                              <a href="{{route('sales-trnx-delete', $row->id)}}" class="btn btn-danger btn-rounded btn-sm" onclick="return confirm('Are you sure, you want to delete?')">{{__('admin.delete')}}</a>
                                            </td>
                                          </tr>
                                        @endforeach
                                      @else
                                          <tr>
                                            <td colspan="11" class="text-center">{{__('admin.no_data_found')}}</td>
                                          </tr>
                                      @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right">Total: </td>
                                            <td>{{$page_qty_total}}</td>
                                            <td></td>
                                            <td>{{$page_rcv_total}}</td>
                                            <td>{{$page_due_total}}</td>
                                            <td>{{$page_total}}</td>
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