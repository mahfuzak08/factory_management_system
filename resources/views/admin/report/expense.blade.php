<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin._head')
    
     <style>
    /* Screen + Print base */
    body { font-family: Arial, sans-serif; color:#333; margin:0; padding:0; }
    #printArea { background:#fff; padding:0; margin:0; width:100%; }

    .company-header{
      display:flex; justify-content:space-between;
      margin-bottom:20px; border-bottom:1px solid #ccc; padding-bottom:15px;
    }
    .company-info h2{
      font-family:'Brush Script MT', cursive; font-size:45px; margin:0; font-weight:normal;
    }
    .company-info p{
      font-family:'Brush Script MT', cursive; font-size:25px; margin:0; font-style:italic;
    }

    .bg-dark {
      background-color:#343a40; color:#fff;
    }

    table {
      width:100% !important;
      border-collapse: collapse;
      margin:0;
    }
    table th, table td {
      border: 1px solid #ddd;
      padding: 5px;
      text-align: left;
      vertical-align: top;
    }

    /* Print only */
    @media print {
      .no-print { display:none !important; }
      .screen-only { display:none !important; }
      #printArea, #printArea * { visibility: visible; }
      #printArea {
        position:absolute; left:0; top:0; width:100%; background:#fff; padding:0;
      }
      @page { size: A4 landscape; margin:5mm; }
      .bg-dark{
        -webkit-print-color-adjust:exact; print-color-adjust:exact;
        background-color:#343a40 !important; color:#fff !important;
      }
      a { text-decoration:none; color:#000; }
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
            <div class="page-header d-flex justify-content-between align-items-center no-print">
              <h3 class="page-title">{{__('admin.expense')}}</h3>
              <div>
                <button onclick="printDiv('printArea')" class="btn btn-primary btn-sm btn-rounded">
                  {{__('print')}}
                </button>
              </div>
            </div>

            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">

                    <!-- ✅ PRINTABLE AREA START -->
                    <div id="printArea">

                      <!-- Company Header -->
                      <div class="company-header">
                        <div style="flex: 2; display: flex; align-items: flex-start;">
                          <div style="margin-right: 15px;">
                            <img src="/admin/assets/images/logo.PNG" alt="Akash Global Trading" style="height: 90px; width: auto;">
                          </div>
                          <div class="company-info">
                            <h2>Akash Global Trading</h2>
                            <p>Importers, Exporters & General Suppliers</p>
                          </div>
                        </div>
                        <div style="flex: 1; text-align: left; font-size: 14px;">
                          <p style="margin: 0;">8/1 Iswar Das Lane, Sutrapur, Dhaka-1100</p>
                          <p style="margin: 0;">Cell: 01755595883</p>
                          <p style="margin: 0;">Email: apon_tel@yahoo.com</p>
                          <p style="margin: 0;">Website: www.akashglobaltrading.com</p>
                        </div>
                      </div>

                      <!-- Filters / Search Form - Screen only -->
                      <form action="{{route('expense-report')}}" method="GET" class="mb-3 screen-only">
                        @csrf
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">{{__('admin.start_date')}}</label>
                              <div class="col-sm-9">
                                <input type="date" value="{{date('d-m-Y')}}" class="form-control" name="start_date">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">{{__('admin.end_date')}}</label>
                              <div class="col-sm-9">
                                <input type="date" value="{{date('d-m-Y')}}" class="form-control" name="end_date">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">{{__('admin.expense_name')}}</label>
                              <div class="col-sm-9">
                                <select name="expense_type" style="width: 100%">
                                  <option value="all">All</option>
                                  @foreach($expense as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group row">
                              <button name="get_data" class="btn btn-success">Search</button>
                            </div>
                          </div>
                        </div>
                      </form>

                      <!-- Table -->
                      <div class="row table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr class="bg-dark">
                              <th>{{__('admin.sl')}}</th>
                              <th>{{__('admin.date')}}</th>
                              <th>{{__('admin.id')}}</th>
                              <th>{{__('admin.expense_name')}}</th>
                              <th>{{__('admin.account_name')}}</th>
                              <th>{{__('admin.amount')}}</th>
                              <th>{{__('admin.details')}}</th>
                              <th class="screen-only">{{__('admin.action')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php 
                              $page_total = 0;
                              if(isset($_GET['page']) && $_GET['page']>0)
                                $n = 1 + (($_GET['page'] - 1) * 10);
                              else
                                $n = 1;
                            @endphp
                            @if(count($datas) > 0)
                              @foreach($datas as $row)
                                <tr>
                              
                                  <td>{{$n++}}</td>
                                  <td>{{date('d-m-Y', strtotime($row->trnx_date))}}</td>
                                  <td>{{$row->id}}</td>
                                  <td>{{$row->expense_name}}</td>
                                  <td>{{$row->acc_name}}</td>
                                  <td>
                                    {{number_format($row->amount, 2)}}
                                    @php 
                                      $page_total += $row->amount;
                                    @endphp
                                  </td>
                                  <td>{{$row->title}} {{$row->details}}</td>
                                  <td class="screen-only">
                                    @if(hasModuleAccess('Expense_Transection_Edit'))
                                      <a href="{{route('expense-trnx-edit', $row->id)}}" class="btn btn-warning btn-rounded btn-sm">{{__('admin.edit')}}</a> 
                                    @endif
                                    @if(hasModuleAccess('Expense_Transection_Delete'))
                                      <a href="{{route('expense-trnx-delete', $row->id)}}" class="btn btn-danger btn-rounded btn-sm" onclick="return confirm('Are you sure, you want to delete?')">{{__('admin.delete')}}</a>
                                    @endif
                                  </td>
                                </tr>
                              @endforeach
                            @else
                              <tr>
                                <td colspan="8" class="text-center">{{__('admin.no_data_found')}}</td>
                              </tr>
                            @endif
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="5" class="text-right">Page Total: </td>
                              <td>{{number_format($page_total, 2)}}</td>
                              <td class="screen-only" colspan="2"></td>
                            </tr>
                            @if($etotal > 0)
                              <tr>
                                <td colspan="5" class="text-right">Total</td>
                                <td>{{number_format($etotal, 2)}}</td>
                                <td class="screen-only" colspan="2"></td>
                              </tr>
                            @endif
                          </tfoot>
                        </table>
                      </div>

                      {{ $datas->onEachSide(3)->links() }}
                    </div>
                    <!-- ✅ PRINTABLE AREA END -->

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
    function printDiv(divId) {
      var printContents = document.getElementById(divId).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
      location.reload(); // restore scripts/events
    }
    </script>
  </body>
</html>