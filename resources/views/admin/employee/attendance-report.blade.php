<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin._head')
    <style>
      .nopad8px{
        padding: 0px 5px !important;
        font-size: 12px !important;
      }
      .table-responsive {
        max-height: 500px; /* Adjust this value as needed */
        overflow-y: auto;
        position: relative;
      }
      .table-responsive thead th {
        position: sticky;
        top: 0;
        background-color: #86888b; /* Same as .thead-dark background */
        color: white; /* Same as .thead-dark text color */
        z-index: 1;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
      }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      @include('admin._navbar')
      <div class="container-fluid page-body-wrapper">
        @include('admin._sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <form id="dataForm" action="{{route('emp-report')}}" method="GET">
                  @csrf
                  <div class="page-header row">
                    <div class="col-4">
                      <h3 class="page-title">{{__('admin.employee')}}</h3>
                    </div>
                    <div class="col-3">
                      <select name="empid" style="width: 100%">
                        <option value="all">All</option>
                        @for($i=0; $i<count($employee); $i++)
                          <option value="{{$employee[$i]['id']}}">{{$employee[$i]['name']}}</option>
                        @endfor
                      </select>
                    </div>
                    <div class="col-2"><input type="month" name="month" class="form-control"></div>
                    <div class="col-3"><button class="btn btn-info" type="submit">{{__('admin.old_attendance')}}</button></div>
                  </div>
                </form>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                              <div class="row table-responsive printable-content">
                                <div class="text-center">
                                  <h2>{{config('app.name')}}</h2>
                                  <h3>Employee Attendance</h3>
                                  <h3>for</h3>
                                  <h3>{{$monthYear}}</h3>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> {{__('admin.name')}} </th>
                                            @for($i=1; $i<=$totalDays; $i++)
                                                <th class="nopad8px">{{$i}}</th>
                                            @endfor
                                            <th>Total</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                      @php
                                          $sl=1;
                                      @endphp
                                      @for($n=0; $n<count($employee); $n++)
                                        <tr>
                                            <td>{{$sl++}}</td>
                                            <td>ID-{{$employee[$n]['id']}}::{{$employee[$n]['name']}}</td>
                                            @php
                                            $total = 0;
                                            @endphp
                                            @for($i=1; $i<=$totalDays; $i++)
                                                @php 
                                                $flag = false;
                                                @endphp
                                                @for($j=0; $j<count($employee[$n]['attendance']); $j++)
                                                    @if(($employee[$n]['attendance'][$j]['date'] == $inputYearMonth."-".str_pad($i, 2, '0', STR_PAD_LEFT)) && $employee[$n]['attendance'][$j]['hours'] > 0)
                                                        @php 
                                                        $flag = true;
                                                        break;
                                                        @endphp
                                                    @endif
                                                @endfor
                                                @if($flag)
                                                    @php
                                                    $total+= $employee[$n]['attendance'][$j]['hours']>=8 ? 1 : ($employee[$n]['attendance'][$j]['hours'] >= 4 ? 0.5 : 0);
                                                    @endphp
                                                    <td class="nopad8px">{{$employee[$n]['attendance'][$j]['hours']>=8 ? 'Y' : ($employee[$n]['attendance'][$j]['hours'] >= 4 ? 'H' : '')}}</td>
                                                @else
                                                    <td class="nopad8px"> </td>
                                                @endif
                                            @endfor
                                            <td class="nopad8px">
                                              {{$total}}
                                            </td>
                                        </tr>
                                      @endfor
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