<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin._head')
    <style>
        .submodule{
            margin-left: 50px;
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
                <div class="page-header">
                  <h3 class="page-title"> {{ __('admin.role_management') }} </h3>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('role-manage')}}" class="btn btn-sm btn-rounded btn-secondary">{{__('admin.back')}}</a></li>
                    </ol>
                  </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form class="forms-sample" method="POST" action="{{ route('save-role') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$role->id}}">
                                    <div class="form-group">
                                        <label for="exampleInputName1">{{ __('admin.name') }}</label>
                                        <input type="text" value="{{$role->name}}" class="form-control" id="exampleInputName1" name="name" placeholder="{{ __('admin.name') }}">
                                    </div>
                                    <div class="row">
                                        @php
                                        $modules = explode(",", json_decode($role->module, true));
                                        @endphp
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputName5">{{ __('admin.module_list') }}</label>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Inventory') ? 'checked' : ''}} value="Inventory"> {{__('Inventory')}} <i class="input-helper"></i></label>
                                            </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Inventory_Edit') ? 'checked' : ''}} value="Inventory_Edit"> {{__('Inventory Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Sales') ? 'checked' : ''}} value="Sales"> {{__('Sales')}} <i class="input-helper"></i></label>
                                            </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('All_Sales') ? 'checked' : ''}} value="All_Sales"> {{__('All Sales')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Sales_Edit') ? 'checked' : ''}} value="Sales_Edit"> {{__('Sales Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Sales_Delete') ? 'checked' : ''}} value="Sales_Delete"> {{__('Sales Delete')}} <i class="input-helper"></i></label>
                                                </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Customer') ? 'checked' : ''}} value="Customer"> {{__('Customer')}} <i class="input-helper"></i></label>
                                            </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Customer_Add') ? 'checked' : ''}} value="Customer_Add"> {{__('Customer Add')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Customer_Details') ? 'checked' : ''}} value="Customer_Details"> {{__('Customer Details')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Customer_Edit') ? 'checked' : ''}} value="Customer_Edit"> {{__('Customer Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Customer_Delete') ? 'checked' : ''}} value="Customer_Delete"> {{__('Customer Delete')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Customer_Transection_Add') ? 'checked' : ''}} value="Customer_Transection_Add"> {{__('Customer Transection Add')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Customer_Transection_Edit') ? 'checked' : ''}} value="Customer_Transection_Edit"> {{__('Customer Transection Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Customer_Transection_Delete') ? 'checked' : ''}} value="Customer_Transection_Delete"> {{__('Customer Transection Delete')}} <i class="input-helper"></i></label>
                                                </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Purchase') ? 'checked' : ''}} value="Purchase"> {{__('Purchase')}} <i class="input-helper"></i></label>
                                            </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('All_Purchase') ? 'checked' : ''}} value="All_Purchase"> {{__('All Purchase')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Purchase_Edit') ? 'checked' : ''}} value="Purchase_Edit"> {{__('Purchase Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Purchase_Delete') ? 'checked' : ''}} value="Purchase_Delete"> {{__('Purchase Delete')}} <i class="input-helper"></i></label>
                                                </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Vendor') ? 'checked' : ''}} value="Vendor"> {{__('Vendor')}} <i class="input-helper"></i></label>
                                            </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Vendor_Add') ? 'checked' : ''}} value="Vendor_Add"> {{__('Vendor Add')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Vendor_Details') ? 'checked' : ''}} value="Vendor_Details"> {{__('Vendor Details')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Vendor_Edit') ? 'checked' : ''}} value="Vendor_Edit"> {{__('Vendor Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Vendor_Delete') ? 'checked' : ''}} value="Vendor_Delete"> {{__('Vendor Delete')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Vendor_Transection_Add') ? 'checked' : ''}} value="Vendor_Transection_Add"> {{__('Vendor Transection Add')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Vendor_Transection_Edit') ? 'checked' : ''}} value="Vendor_Transection_Edit"> {{__('Vendor Transection Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Vendor_Transection_Delete') ? 'checked' : ''}} value="Vendor_Transection_Delete"> {{__('Vendor Transection Delete')}} <i class="input-helper"></i></label>
                                                </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Settings') ? 'checked' : ''}} value="Settings"> {{__('Settings')}} <i class="input-helper"></i></label>
                                            </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Language_Settings') ? 'checked' : ''}} value="Language_Settings"> {{__('Language Settings')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('User_Settings') ? 'checked' : ''}} value="User_Settings"> {{__('User Settings')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Role_Settings') ? 'checked' : ''}} value="Role_Settings"> {{__('Role Settings')}} <i class="input-helper"></i></label>
                                                </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Employee') ? 'checked' : ''}} value="Employee"> {{__('Employee')}} <i class="input-helper"></i></label>
                                            </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Employee_Details') ? 'checked' : ''}} value="Employee_Details"> {{__('Employee Details')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Employee_Add') ? 'checked' : ''}} value="Employee_Add"> {{__('Employee Add')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Employee_Edit') ? 'checked' : ''}} value="Employee_Edit"> {{__('Employee Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Employee_Delete') ? 'checked' : ''}} value="Employee_Delete"> {{__('Employee Delete')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Employee_Transection_Add') ? 'checked' : ''}} value="Employee_Transection_Add"> {{__('Employee Transection Add')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Employee_Attendance') ? 'checked' : ''}} value="Employee_Attendance"> {{__('Employee Attendance')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Employee_Report') ? 'checked' : ''}} value="Employee_Report"> {{__('Employee Report')}} <i class="input-helper"></i></label>
                                                </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Expense') ? 'checked' : ''}} value="Expense"> {{__('Expense')}} <i class="input-helper"></i></label>
                                            </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Expense_Add') ? 'checked' : ''}} value="Expense_Add"> {{__('Expense Add')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Expense_Details') ? 'checked' : ''}} value="Expense_Details"> {{__('Expense Details')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Expense_Edit') ? 'checked' : ''}} value="Expense_Edit"> {{__('Expense Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Expense_Delete') ? 'checked' : ''}} value="Expense_Delete"> {{__('Expense Delete')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Expense_Transection_Add') ? 'checked' : ''}} value="Expense_Transection_Add"> {{__('Expense Transection Add')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Expense_Transection_Edit') ? 'checked' : ''}} value="Expense_Transection_Edit"> {{__('Expense Transection Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Expense_Transection_Delete') ? 'checked' : ''}} value="Expense_Transection_Delete"> {{__('Expense Transection Delete')}} <i class="input-helper"></i></label>
                                                </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Accounts') ? 'checked' : ''}} value="Accounts"> {{__('Accounts')}} <i class="input-helper"></i></label>
                                            </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Accounts_Add') ? 'checked' : ''}} value="Accounts_Add"> {{__('Accounts Add')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Accounts_Details') ? 'checked' : ''}} value="Accounts_Details"> {{__('Accounts Details')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Accounts_Edit') ? 'checked' : ''}} value="Accounts_Edit"> {{__('Accounts Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Accounts_Delete') ? 'checked' : ''}} value="Accounts_Delete"> {{__('Accounts Delete')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Accounts_Transection_Add') ? 'checked' : ''}} value="Accounts_Transection_Add"> {{__('Accounts Transection Add')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Accounts_Transection_Edit') ? 'checked' : ''}} value="Accounts_Transection_Edit"> {{__('Accounts Transection Edit')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Accounts_Transection_Delete') ? 'checked' : ''}} value="Accounts_Transection_Delete"> {{__('Accounts Transection Delete')}} <i class="input-helper"></i></label>
                                                </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Report') ? 'checked' : ''}} value="Report"> {{__('Report')}} <i class="input-helper"></i></label>
                                            </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Sales_Report') ? 'checked' : ''}} value="Sales_Report"> {{__('Sales_Report')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Purchase_Report') ? 'checked' : ''}} value="Purchase_Report"> {{__('Purchase_Report')}} <i class="input-helper"></i></label>
                                                </div>
                                                <div class="form-check submodule">
                                                    <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="module[]" {{hasModuleAccess('Expense_Report') ? 'checked' : ''}} value="Expense_Report"> {{__('Expense_Report')}} <i class="input-helper"></i></label>
                                                </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-rounded btn-primary btn-sm me-2">{{ __('admin.save_now') }}</button><br><br>
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