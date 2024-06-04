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
                  <h3 class="page-title"> {{ __('admin.employee') }} </h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('attendance')}}" class="btn btn-sm btn-rounded btn-secondary">{{__('admin.back')}}</a></li>
                    </ol>
                  </nav>
                </div>
                <div class="row">
                    <div class="col-12 col-md-8 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form class="forms-sample" method="POST" action="{{ route('save-attendance') }}">
                                    @csrf
                                    <div class="form-group">
                                      <label for="exampleInputName1">{{ __('admin.name') }}</label>
                                      <input type="text" value="{{$employee[0]->name}}" class="form-control disabled" id="exampleInputName1" name="name" placeholder="{{ __('admin.name') }}">
                                      <input type="hidden" value="{{$employee[0]->id}}" name="emp_id">
                                      <input type="hidden" value="{{!empty($attendance) ? $attendance[0]['id'] : 0}}" name="att_id">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName2">{{ __('admin.date') }}</label>
                                        <input type="date" value="{{!empty($attendance) ? $attendance[0]['date'] : date('Y-m-d')}}" class="form-control" id="exampleInputName2" name="date" placeholder="{{ __('admin.date') }}">
                                    </div>
                                    <div class="form-group row">
                                        {{-- <label class="col-sm-3 col-form-label">Membership</label> --}}
                                        <div class="col-sm-4">
                                          <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="radio" class="form-check-input" name="attType" id="attType1" value="Y" {{empty($attendance) || empty($attendance[0]['intime']) ? 'checked="true"' : ''}}> {{__('admin.fullday')}} <i class="input-helper"></i></label>
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                          <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="radio" class="form-check-input" name="attType" id="attType2" value="H"> {{__('admin.halfday')}} <i class="input-helper"></i></label>
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                          <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="radio" class="form-check-input" name="attType" id="attType3" value="T" {{!empty($attendance) && !empty($attendance[0]['intime']) ? 'checked="true"' : ''}}> {{__('admin.time')}} <i class="input-helper"></i></label>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="form-group timeshow {{empty($attendance) || empty($attendance[0]['intime']) ? 'hidden' : ''}}">
                                        <label for="exampleInputName12">{{ __('admin.intime') }}</label>
                                        <input type="datetime-local" value="{{!empty($attendance) && !empty($attendance[0]['intime']) ? $attendance[0]['intime'] : date('Y-m-d H:i')}}" class="form-control" id="exampleInputName12" name="intime" placeholder="{{ __('admin.intime') }}">
                                    </div>
                                    <div class="form-group timeshow {{empty($attendance) || empty($attendance[0]['intime']) ? 'hidden' : ''}}">
                                        <label for="exampleInputName13">{{ __('admin.outtime') }}</label>
                                        <input type="datetime-local" value="{{!empty($attendance) && !empty($attendance[0]['outtime']) ? $attendance[0]['outtime'] : date('Y-m-d H:i')}}" class="form-control" id="exampleInputName13" name="outtime" placeholder="{{ __('admin.outtime') }}">
                                    </div>
                              
                                    <button type="submit" class="btn btn-rounded btn-primary btn-sm me-2">{{ __('admin.update') }}</button><br><br>
                                    <a onclick="history.back()" class="btn btn-sm btn-rounded btn-secondary">{{ __('admin.cancel') }}</a>
                                </form>
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
      $('input[type=radio][name=attType]').change(function() {
        if (this.value == 'T') {
          $('.timeshow').show();
        }
        else{
          $('.timeshow').hide();
        }
      });
    </script>
  </body>
</html>