<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-home"></i>
      </span> {{ __('admin.dashboard')}}
    </h3>
    <nav aria-label="breadcrumb">
      <ul class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
          <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
        </li>
      </ul>
    </nav>
  </div>
  <div class="row">
    <div class="col-md-6 stretch-card grid-margin">
      <div class="card bg-gradient-info card-img-holder text-white">
        <div class="card-body">
          <img src="admin/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
          <h2 class="font-weight-normal mb-3" style="font-size: 50px;">{{__('admin.purchase')}}</h2>
          <h5 class="card-text">{{__('admin.today_total')}} {{__('admin.purchase')}} 12,45,678.00</h5>
        </div>
      </div>
    </div>
    <div class="col-md-6 stretch-card grid-margin">
      <div class="card bg-gradient-danger card-img-holder text-white">
        <div class="card-body">
          <img src="admin/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
          <h2 class="font-weight-normal mb-3" style="font-size: 50px;">{{__('admin.sales')}}</h2>
          <h5 class="card-text">{{__('admin.today_total')}} {{__('admin.sales')}} 2,46,853.00</h5>
        </div>
      </div>
    </div>
    <div class="col-md-6 stretch-card grid-margin">
      <div class="card bg-gradient-success card-img-holder text-white">
        <div class="card-body">
          <img src="admin/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
          <h2 class="font-weight-normal mb-3" style="font-size: 50px;">{{__('admin.expense')}}</h2>
          <h5 class="card-text">{{__('admin.today_total')}} {{__('admin.expense')}} 24,561.00</h5>
        </div>
      </div>
    </div>
    <div class="col-md-6 stretch-card grid-margin">
      <div class="card bg-gradient-primary card-img-holder text-white">
        <div class="card-body">
          <img src="admin/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
          <h2 class="font-weight-normal mb-3" style="font-size: 50px;">{{__('admin.employee')}}</h2>
          <h5 class="card-text">{{__('admin.today_total')}} {{__('admin.employee')}} 24</h5>
        </div>
      </div>
    </div>
  </div>
</div>