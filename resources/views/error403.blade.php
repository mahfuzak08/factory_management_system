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
            <div class="content-wrapper d-flex align-items-center text-center error-page bg-primary">
                <div class="row flex-grow">
                  <div class="col-lg-7 mx-auto text-white">
                    <div class="row align-items-center d-flex flex-row">
                      <div class="col-lg-6 text-lg-right pr-lg-4">
                        <h1 class="display-1 mb-0">403</h1>
                      </div>
                      <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                        <h2>{{__('admin.Sorry')}}!</h2>
                        <h3 class="font-weight-light">{{__('admin.not_allowed')}}</h3>
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