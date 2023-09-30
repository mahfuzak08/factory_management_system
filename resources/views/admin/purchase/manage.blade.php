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
                  <h3 class="page-title">{{__('admin.all_purchase')}}</h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('purchase')}}" class="btn btn-rounded btn-sm btn-success">{{__('admin.back')}}</a></li>
                    </ol>
                  </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                              <div class="row table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> {{__('admin.sl')}} </th>
                                            <th> {{__('admin.inv_no')}} </th>
                                            <th> {{__('admin.inv_type')}} </th>
                                            <th> {{__('admin.vendor_name')}} </th>
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
                                            <td><a href="{{route('purchase-invoice', $row->id)}}">{{$n++}}</a></td>
                                            <td><a href="{{route('purchase-invoice', $row->id)}}">{{$row->order_id}}</a></td>
                                            <td>{{$row->order_type}}</td>
                                            <td><a href="{{route('purchase-invoice', $row->id)}}">{{$row->vendor_name}}</a></td>
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