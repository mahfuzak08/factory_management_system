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
                  <h3 class="page-title">{{__('admin.employee')}}</h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                          <form id="dataForm" action="{{route('emp-report')}}" method="GET">
                            @csrf
                            <input type="month" name="month" class="form-control">
                            <br>
                            <button class="btn btn-info" type="submit">{{__('admin.old_attendance')}}</button>
                            <br>
                            <button id="printButton" class="btn btn-success hidden">Print</button>
                          </form>
                        </li>
                    </ol>
                  </nav>
                </div>
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
                                                <th>{{$i}}</th>
                                            @endfor
                                          </tr>
                                    </thead>
                                    <tbody>
                                      @php
                                          $sl=1;
                                      @endphp
                                      @for($n=0; $n<count($employee); $n++)
                                        <tr>
                                            <td>{{$sl++}}</td>
                                            <td>{{$employee[$n]['name']}}</td>
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
                                                    <td>Y</td>
                                                @else
                                                    <td> </td>
                                                @endif
                                            @endfor
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