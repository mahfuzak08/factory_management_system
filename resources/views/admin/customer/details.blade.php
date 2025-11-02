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
              <!-- Company Header (print-only) -->
              <div class="company-header no-print" style="display:none; margin-bottom:20px;">
                <div style="display:flex; gap:20px; align-items:flex-start;">
                  <div style="flex: 2; display: flex; align-items: flex-start;">
                    <div style="margin-right: 15px;">
                      <img src="{{ asset('admin/assets/images/logo.PNG') }}" alt="Akash Global Trading" style="height: 90px; width: auto;">
                    </div>
                    <div class="company-info">
                      <h2 style="margin:0;">Akash Global Trading</h2>
                      <p style="margin:0;">Importers, Exporters & General Suppliers</p>
                    </div>
                  </div>
                  <div style="flex: 1; text-align: left; font-size: 14px;">
                    <p style="margin: 0;">8/1 Iswar Das Lane, Sutrapur, Dhaka-1100</p>
                    <p style="margin: 0;">Cell: 01755595883</p>
                    <p style="margin: 0;">Email: apon_tel@yahoo.com</p>
                    <p style="margin: 0;">Website: www.akashglobaltrading.com</p>
                  </div>
                </div>
              </div>
              <!-- Server-rendered printable area (hidden on screen) -->
              <div id="print-area" style="display:none;">
                <div style="width:100%; padding:10px 20px; box-sizing:border-box;">
                  <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                    <div style="display:flex; align-items:center; gap:12px;">
                      <img src="{{ asset('admin/assets/images/logo.PNG') }}" alt="logo" style="height:70px;" />
                      <div>
                        <h2 style="margin:0;">Akash Global Trading</h2>
                        <div style="font-size:13px;">Importers, Exporters & General Suppliers</div>
                      </div>
                    </div>
                    <div style="text-align:right; font-size:13px;">
                      <div>8/1 Iswar Das Lane, Sutrapur, Dhaka-1100</div>
                      <div>Cell: 01755595883</div>
                      <div>Email: apon_tel@yahoo.com</div>
                      <div>Website: www.akashglobaltrading.com</div>
                    </div>
                  </div>

                  <hr />

                  <h1 style="margin:6px 0 12px 0; font-size:22px; text-align:center; width:100%;">Customer Details</h1>

                  <div style="display:flex; gap:20px; margin-bottom:12px;">
                    <div style="flex:1">
                      <div style="font-weight:600">Name</div>
                      <div>{{ $customer[0]->name }}</div>
                    </div>
                    <div style="flex:1">
                      <div style="font-weight:600">Mobile</div>
                      <div>{{ $customer[0]->mobile }}</div>
                    </div>
                    <div style="flex:1">
                      <div style="font-weight:600">Address</div>
                      <div>{{ $customer[0]->address }}</div>
                    </div>
                  </div>

                  <div style="display:flex; gap:20px; margin-bottom:12px;">
                    <div style="flex:1">
                      <div style="font-weight:600">Total Due</div>
                      <div>{{ number_format($customer[0]->total_due ?? 0, 2) }}</div>
                    </div>
                    <div style="flex:1">
                      <div style="font-weight:600">Total Payment</div>
                      <div>{{ number_format($customer[0]->total_pay ?? 0, 2) }}</div>
                    </div>
                    <div style="flex:1">
                      <div style="font-weight:600">Current Due</div>
                      <div>{{ number_format($customer[0]->cy_due ?? 0, 2) }}</div>
                    </div>
                  </div>

                  <h4 style="margin-top:10px; margin-bottom:6px;">Transactions</h4>
                  <table style="width:100%; border-collapse:collapse; font-size:13px;">
                    <thead>
                      <tr>
                        <th style="border:1px solid #ccc; padding:6px; text-align:left">#</th>
                        <th style="border:1px solid #ccc; padding:6px; text-align:left">Date</th>
                        <th style="border:1px solid #ccc; padding:6px; text-align:left">Account</th>
                        <th style="border:1px solid #ccc; padding:6px; text-align:left">Details</th>
                        <th style="border:1px solid #ccc; padding:6px; text-align:right">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $i = 1; $printTotal = 0; @endphp
                      @foreach($datas as $row)
                        <tr>
                          <td style="border:1px solid #eee; padding:6px">{{ $i++ }}</td>
                          <td style="border:1px solid #eee; padding:6px">{{ date('d-m-Y', strtotime($row->tranx_date)) }}</td>
                          <td style="border:1px solid #eee; padding:6px">{{ $row->bank_name }}</td>
                          <td style="border:1px solid #eee; padding:6px">{{ $row->note }}</td>
                          <td style="border:1px solid #eee; padding:6px; text-align:right">{{ number_format($row->amount, 2) }}</td>
                        </tr>
                        @php $printTotal += $row->amount; @endphp
                      @endforeach
                      <tr>
                        <td colspan="4" style="border:1px solid #ccc; padding:6px; text-align:right; font-weight:600">Total</td>
                        <td style="border:1px solid #ccc; padding:6px; text-align:right; font-weight:600">{{ number_format($printTotal, 2) }}</td>
                      </tr>
                    </tbody>
                  </table>
                  
                  <!-- Print footer -->
                  <div id="print-footer" style="margin-top:18px; font-size:12px; color:#333;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                      <div>Akash Global Trading  8/1 Iswar Das Lane, Sutrapur, Dhaka-1100</div>
                      <div>Printed on: {{ now()->format('d-m-Y H:i') }}</div>
                    </div>
                  </div>
                </div>
              </div>
                <div class="page-header d-flex align-items-center justify-content-between">
                  <div>
                    <h3 class="page-title">{{__('admin.customer')}}</h3>
                  </div>
                  <div class="page-actions">
                    <a href="{{route('customer')}}" class="btn btn-sm btn-rounded btn-secondary">{{__('admin.back')}}</a>
                    <button class="btn btn-sm btn-primary ms-2" onclick="printCustomer()">{{__('Print')}}</button>
                  </div>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="forms-sample">
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input1" class="col-sm-3 col-form-label">{{__('admin.name')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input1" value="{{$customer[0]->name}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input2" class="col-sm-3 col-form-label">{{__('admin.mobile')}}</label>
                                      <div class="col-sm-9">
                                        <input type="email" class="form-control form-control-border-off" disabled="true" id="input2" value="{{$customer[0]->mobile}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input3" class="col-sm-3 col-form-label">{{__('admin.address')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input3" value="{{$customer[0]->address}}">
                                      </div>
                                    </div>
                                    {{-- <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input4" class="col-sm-3 col-form-label">{{__('admin.email')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input4" value="{{$customer[0]->email}}">
                                      </div>
                                    </div> --}}
                                    @php
                                    $customer[0]->total_due = $customer[0]->total_due >= 0 ? $customer[0]->total_due : 0;
                                    $customer[0]->cy_due = $customer[0]->cy_due >= 0 ? $customer[0]->cy_due : 0;
                                    @endphp
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input5" class="col-sm-3 col-form-label text-warning">{{__('admin.total_due')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input5" value="{{number_format($customer[0]->total_due, 2)}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input5" class="col-sm-3 col-form-label text-warning">{{__('admin.total_payment')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input5" value="{{number_format($customer[0]->total_pay, 2)}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input5" class="col-sm-3 col-form-label">{{__('admin.current_due')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input5" value="{{number_format($customer[0]->cy_due, 2)}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input5" class="col-sm-3 col-form-label">{{__('admin.current_payment')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" id="input5" value="{{number_format($customer[0]->cy_pay, 2)}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label class="col-sm-3 col-form-label">{{__('admin.quantity')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-border-off" disabled="true" value="{{number_format($quantity)}}">
                                      </div>
                                    </div>
                                    @if($customer[0]->cy_due == 0 && $customer[0]->cy_pay >= 0)
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <button class="btn btn-danger me-2 float-end">{{__('admin.payment')}}</button>
                                    </div>
                                    @endif
                                  </div>
                                </div>
                                <div class="col-md-6 d-none d-md-block" id="addForm">
                                  @if(hasModuleAccess('Customer_Transection_Add'))
                                  <form class="forms-sample" method="POST" action="{{ route('save-customer-amount') }}">
                                    @csrf
                                    <input type="hidden" name="ref_id" value="{{$customer[0]->id}}" />
                                    <input type="hidden" name="ref_type" value="customer" />
                                    <input type="hidden" name="redirect_url" value="customer_details/{{$customer[0]->id}}" />
                                    <input type="hidden" name="type" value="deposit" />
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input6" class="col-sm-3 col-form-label">{{__('admin.date')}}</label>
                                      <div class="col-sm-9">
                                        <input type="date" name="tranx_date" class="form-control" id="input6" required>
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input7" class="col-sm-3 col-form-label">{{__('admin.received_by')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" class="form-control" name="note" id="input7" placeholder="{{__('admin.received_by')}}">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input8" class="col-sm-3 col-form-label">{{__('admin.enter_your_amount')}}</label>
                                      <div class="col-sm-9">
                                        <input type="text" name="amount" placeholder="{{__('admin.enter_your_amount')}}" required class="form-control" id="input8">
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                      <label for="input9" class="col-sm-3 col-form-label">{{__('admin.account_name')}}</label>
                                      <div class="col-sm-9">
                                        <select class="form-select" name="account_id" id="input9">
                                          @foreach($banks as $bank)
                                          <option value="{{$bank->id}}">{{$bank->name}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group form-group-margin-bottom-off row">
                                        <label for="input9" class="col-sm-3 col-form-label">{{__('admin.do_you_want_to_send_sms')}}</label>
                                        <div class="col-sm-9">
                                          <select class="form-select" name="sms_flag" id="input10">
                                            <option value="no">{{__('admin.no')}}</option>
                                            <option value="yes">{{__('admin.yes')}}</option>
                                          </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2 float-end">{{ __('admin.save_now') }}</button>
                                  </form>
                                  @endif
                                  <div class="col-md-6">
                                    @if(hasModuleAccess('Customer_Edit'))
                                      <br><br><br><br>
                                      <a href="{{route('edit-customer', $customer[0]->id)}}" class="btn btn-warning">{{__('admin.edit')}}</a> 
                                    @endif
                                    @if(hasModuleAccess('Customer_Delete'))
                                      <a href="{{route('delete-customer', $customer[0]->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure, you want to delete?')">{{__('admin.delete')}}</a> 
                                    @endif
                                  </div>
                                </div>
                                <div class="col-md-6 d-block d-md-none text-center">
                                  <br />
                                  <a onclick="openForm()" class="btn btn-sm btn-rounded btn-info">{{__('admin.add_new')}}</a>
                                </div>
                                <div class="col-12">
                                  <br />
                                  <hr />
                                  <br />
                                  <form action="{{route('customer-details', $customer[0]->id)}}" method="GET">
                                    @csrf
                                    @php 
                                    $sv = isset($_GET['search']) ? $_GET['search'] : '';
                                    @endphp
                                    <div class="row">
                                      <input type="text" name="search" class="col-12 col-md-10" value="{{$sv}}" placeholder="{{__('admin.what_you_want_to_find')}}">
                                      <button type="submit" class="col-12 col-md-2 btn btn-info">{{__('admin.find')}}</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              <br />
                              <hr />
                              <div class="row table-responsive">
                                @php 
                                $total = 0;
                                @endphp
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{__('admin.sl')}}</th>
                                            <th>{{__('admin.date')}}</th>
                                            <th>{{__('admin.account_name')}}</th>
                                            <th>{{__('admin.details')}}</th>
                                            <th class="text-right">{{__('admin.enter_your_amount')}}</th>
                                            <th>{{__('admin.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if(count($datas) > 0)
                                        @php 
                                        if(isset($_GET['page']) && $_GET['page']>0)
                                          $n = 1 + (($_GET['page'] - 1) * 10);
                                        else
                                          $n = 1;
                                        @endphp
                                        @foreach($datas as $row)
                                          <tr>
                                            <td>{{$n++}}</td>
                                            <td>{{date('d-m-Y', strtotime($row->tranx_date))}}</td>
                                            <td>{{$row->bank_name}}</td>
                                            <td>{{$row->note}}</td>
                                            <td class="text-right">{{number_format($row->amount, 2)}}</td>
                                            <td>
                                              @if($row->ref_tranx_type != 'sales_order')
                                                @if(hasModuleAccess('Customer_Transection_Edit'))
                                                  <a href="{{route('customer-trnx-edit', $row->id)}}" class="btn btn-warning btn-rounded btn-sm">{{__('admin.edit')}}</a> 
                                                @endif
                                                @if(hasModuleAccess('Customer_Transection_Delete'))
                                                  <a href="{{route('customer-trnx-delete', $row->id)}}" class="btn btn-danger btn-rounded btn-sm" onclick="return confirm('Are you sure, you want to delete?')">{{__('admin.delete')}}</a>
                                                @endif
                                              @endif
                                            </td>
                                          </tr>
                                          @php 
                                          $total += $row->amount;
                                          @endphp
                                        @endforeach
                                      @else
                                          <tr>
                                            <td colspan="6" class="text-center">{{__('admin.no_data_found')}}</td>
                                          </tr>
                                      @endif
                                    </tbody>
                                    <tfoot>
                                      <tr>
                                        <td colspan="4">Total</td>
                                        <td class="text-right">{{number_format($total, 2)}}</td>
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
    <style>
      /* Improved print styles for a clean, WYSIWYG-like printout */
      @media print {
        /* Hide chrome */
        .navbar, .sidebar, .breadcrumb, .page-footer, .no-print, .btn, .pagination, .form-control, .form-select { display: none !important; }

        /* Make the content full width */
        body, html { background: #fff; color: #000; }
        .content-wrapper, .main-panel { margin: 0; padding: 0; width: 100%; }
        .card { border: none; box-shadow: none; background: transparent; }
        .card .card-body { padding: 0; }

        /* Company header shown in print */
        .company-header { display: block !important; visibility: visible; margin-bottom: 12px; }
        .company-header img { height: 90px; width: auto; }
        .company-header h2 { margin: 0; font-size: 20px; }
        .company-header p { margin: 0; font-size: 13px; }

        /* Form groups as key/value rows */
        .forms-sample .form-group { display: flex; align-items: center; margin-bottom: 6px; }
        .forms-sample .form-group label.col-sm-3 { flex: 0 0 28%; max-width: 28%; font-weight: 600; }
        .forms-sample .form-group .col-sm-9 { flex: 1; max-width: 72%; }
        input[disabled], textarea[disabled] { border: none !important; background: transparent !important; box-shadow: none !important; padding: 0; margin: 0; }

        /* Table formatting */
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #ddd !important; padding: 6px !important; }
        .table thead { background: #f5f5f5; }

        /* Ensure page margins */
        @page { margin: 12mm; }
        /* Footer fixed at bottom of printed page */
        #print-footer { width:100%; position:relative; }
        tr, td, th { page-break-inside: avoid; }
      }
    </style>

    <script>
      function openForm(){
        $('#addForm').removeClass('d-none');
      }

      function printCustomer(){
        try{
          var printArea = document.getElementById('print-area');
          if(!printArea){ alert('Printable area not found'); return; }

          // Clone the printable area and append to document.body so hiding other nodes won't hide it
          var clone = printArea.cloneNode(true);
          clone.id = '__print_clone';
          clone.style.display = 'block';
          document.body.appendChild(clone);

          // Hide all other top-level body children except the clone
          var bodyChildren = Array.from(document.body.children);
          var toRestore = [];
          bodyChildren.forEach(function(ch){
            if(ch.id !== '__print_clone'){
              toRestore.push({el: ch, old: ch.style.display});
              ch.style.display = 'none';
            }
          });

          setTimeout(function(){
            try{ window.print(); }catch(e){ console.error(e); alert('Print failed'); }

            // restore original layout
            toRestore.forEach(function(t){ try{ t.el.style.display = t.old; }catch(e){} });
            var cl = document.getElementById('__print_clone'); if(cl) cl.parentNode.removeChild(cl);
          }, 350);

        }catch(e){ console.error(e); alert('Unable to print.'); }
      }
    </script>
  </body>
</html>