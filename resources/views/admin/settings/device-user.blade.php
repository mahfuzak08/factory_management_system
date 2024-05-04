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
                    </span> {{ __('Device Users List')}} <br />
                    Name: {{$d->name}} <br />
                    Device IP: {{$d->ip}}
                  </h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('device')}}" class="btn btn-sm btn-rounded btn-secondary">{{__('admin.back')}}</a></li>
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
                                            <th> {{__('Office ID')}} </th>
                                            <th> {{__('Name')}} </th>
                                            <th> {{__('Role')}} </th>
                                            <th> {{__('Password')}} </th>
                                            <th> {{__('RFID Card No')}} </th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                      @if(count($users) > 0)
                                        @php 
                                        $n = 1;
                                        @endphp
                                        @foreach($users as $row)
                                          @if($row['role'] < 14)
                                          <tr>
                                            <td>{{$n++}}</td>
                                            <td>{{$row['userid']}}</td>
                                            <td>{{$row['name']}}</td>
                                            <td>{{$row['role']}}</td>
                                            <td>{{$row['password']}}</td>
                                            <td>{{$row['cardno']}}</td>
                                          </tr>
                                          @endif
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