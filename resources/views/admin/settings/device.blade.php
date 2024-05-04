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
                  <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                      <i class="mdi mdi-home"></i>
                    </span> {{ __('Device List')}}
                  </h3>
                  @if(hasModuleAccess('Device_Add'))
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('add-device')}}" class="btn btn-rounded btn-sm btn-success">{{__('admin.add_new')}}</a></li>
                    </ol>
                  </nav>
                  @endif
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
                                            <th> {{__('admin.name')}} </th>
                                            <th> {{__('IP')}} </th>
                                            <th> {{__('PORT')}} </th>
                                            <th> {{__('admin.status')}} </th>
                                            <th> {{__('admin.action')}} </th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                      @if(count($devices) > 0)
                                        @php 
                                        $n = 1;
                                        @endphp
                                        @foreach($devices as $row)
                                          <tr>
                                            <td>{{$n++}}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->ip}}</td>
                                            <td>{{$row->port}}</td>
                                            <td>{{$row->status}}</td>
                                            <td>
                                              @if(hasModuleAccess('Device_Delete'))
                                                @if($row->status == 'Disconnected')
                                                <a href="{{ URL::route('device', ['id' => $row->id, 'type' => 'active']) }}" class="btn btn-info btn-rounded btn-sm">{{__('admin.active')}}</a>
                                                @else
                                                <a href="{{ URL::route('device', ['id' => $row->id, 'type' => 'getUsers']) }}" class="btn btn-success btn-rounded btn-sm">{{__('Get User')}}</a>
                                                <a href="{{ URL::route('device', ['id' => $row->id, 'type' => 'inactive']) }}" class="btn btn-success btn-rounded btn-sm">{{__('Inactive')}}</a>
                                                @endif
                                                <a href="{{ URL::route('device', ['id' => $row->id, 'type' => 'edit'])}}" class="btn btn-warning btn-rounded btn-sm" onclick="return confirm('Are you sure, you want to edit this info?')">{{__('admin.edit')}}</a> 
                                                <a href="{{ URL::route('device', ['id' => $row->id, 'type' => 'delete']) }}" class="btn btn-danger btn-rounded btn-sm" onclick="return confirm('Are you sure, you want to delete it?')">{{__('admin.delete')}}</a> 
                                              @endif
                                            </td>
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