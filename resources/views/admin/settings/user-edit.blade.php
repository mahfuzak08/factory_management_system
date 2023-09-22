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
                  <h3 class="page-title"> {{ __('admin.user_management') }} </h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('user-manage')}}" class="btn btn-sm btn-rounded btn-secondary">{{__('admin.back')}}</a></li>
                    </ol>
                  </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form class="forms-sample" method="POST" action="{{ route('edit-user', $user->id) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputName1">{{ __('admin.name') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName1" name="name" value="{{$user->name}}" placeholder="{{ __('admin.name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName2">{{ __('admin.mobile') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName2" name="mobile" value="{{$user->mobile}}" placeholder="{{ __('admin.mobile') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName6">{{ __('admin.email') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName6" name="email" value="{{$user->email}}" placeholder="{{ __('admin.email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName7">{{ __('admin.role') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName7" name="role" value="{{$user->role}}" placeholder="{{ __('admin.role') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName7">{{ __('admin.address') }}</label>
                                        <input type="text" class="form-control" id="exampleInputName7" name="address" value="{{$user->address}}" placeholder="{{ __('admin.address') }}">
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
  </body>
</html>