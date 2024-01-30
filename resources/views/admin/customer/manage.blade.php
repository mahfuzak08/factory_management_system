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
                  <h3 class="page-title">{{__('admin.customer')}}</h3>
                  @if(hasModuleAccess('Customer_Add'))
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('add-new-customer')}}" class="btn btn-rounded btn-sm btn-success">{{__('admin.add_new')}}</a></li>
                    </ol>
                  </nav>
                  @endif
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                              <form action="{{route('customer')}}" method="GET">
                                @csrf
                                @php 
                                $sv = isset($_GET['search']) ? $_GET['search'] : '';
                                @endphp
                                <div class="row">
                                  <input type="text" name="search" class="col-12 col-md-10" value="{{$sv}}" placeholder="{{__('admin.what_you_want_to_find')}}">
                                  <button type="submit" class="col-12 col-md-2 btn btn-info">{{__('admin.find')}}</button>
                                </div>
                              </form>
                              <div class="row table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> {{__('admin.sl')}} </th>
                                            <th> {{__('admin.name')}} </th>
                                            <th> {{__('admin.mobile')}} </th>
                                            <th> {{__('admin.address')}} </th>
                                            <th> {{__('admin.total_due')}} </th>
                                            <th> {{__('admin.total_payment')}} </th>
                                            <th> {{__('admin.total')}} </th>
                                            <th> {{__('admin.action')}} </th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                      @if(count($datas) > 0)
                                        @php 
                                        $d = 0;
                                        $r = 0;
                                        if(isset($_GET['page']) && $_GET['page']>0)
                                          $n = 1 + (($_GET['page'] - 1) * 10);
                                        else
                                          $n = 1;
                                        @endphp
                                        @foreach($datas as $row)
                                          @php
                                          $d += $row->due;
                                          $r += $row->receive;
                                          @endphp
                                          <tr>
                                            <td>{{$n++}}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->mobile}}</td>
                                            <td>{{$row->address}}</td>
                                            <td>{{number_format($row->due, 2)}}</td>
                                            <td>{{number_format($row->receive, 2)}}</td>
                                            <td>{{number_format(($row->due + $row->receive), 2)}}</td>
                                            <td>
                                              <a href="{{route('customer-details', $row->id)}}" class="btn btn-info btn-rounded btn-sm">{{__('admin.details')}}</a> 
                                              @if(hasModuleAccess('Customer_Edit'))
                                              <a href="{{route('edit-customer', $row->id)}}" class="btn btn-warning btn-rounded btn-sm">{{__('admin.edit')}}</a> 
                                              @endif
                                              @if(hasModuleAccess('Customer_Delete'))
                                              <a href="{{route('delete-customer', $row->id)}}" class="btn btn-danger btn-rounded btn-sm" onclick="return confirm('Are you sure, you want to delete?')">{{__('admin.delete')}}</a> 
                                              @endif
                                            </td>
                                          </tr>
                                        @endforeach
                                      @else
                                          <tr>
                                            <td colspan="7" class="text-center">{{__('admin.no_data_found')}}</td>
                                          </tr>
                                      @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">Total</td>
                                            <td class="text-right">{{number_format($d, 2)}}</td>
                                            <td class="text-right">{{number_format($r, 2)}}</td>
                                            <td class="text-right">{{number_format(($d + $r), 2)}}</td>
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