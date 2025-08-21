<!DOCTYPE html>
<html lang="en">
<head>
  @include('admin._head')
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

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

    .dt-button.btn-success {
      background-color: #1bcfb4 !important;
      color: #fff !important;
      border: none !important;
    }
    .dt-button.btn-success:hover, .dt-button.btn-success:focus {
      background-color: #1bcfb4 !important;
      color: #fff !important;
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
            <h3 class="page-title">{{__('admin.all_sales')}}</h3>
            <div>
              <a href="{{route('sales')}}" class="btn btn-rounded btn-sm btn-success">{{__('admin.back')}}</a>
             
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
                    <form action="{{route('sales-report')}}" method="GET" class="mb-3 screen-only">
                      @csrf
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{__('admin.start_date')}}</label>
                            <div class="col-sm-9">
                              <input type="date" value="{{@$_GET['start_date'] ? $_GET['start_date'] : date('d-m-Y')}}" class="form-control" name="start_date">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{__('admin.end_date')}}</label>
                            <div class="col-sm-9">
                              <input type="date" value="{{@$_GET['end_date'] ? $_GET['end_date'] : date('d-m-Y')}}" class="form-control" name="end_date">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{__('admin.customer')}}</label>
                            <div class="col-sm-9">
                              <select name="customer_id" style="width: 100%">
                                <option value="all">All</option>
                                @foreach($customer as $row)
                                  <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{__('admin.inv_no')}}</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" value="{{@$_GET['inv_id']}}" name="inv_id">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        @if(Auth::user()->role == 'Super Admin')
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">{{__('admin.status')}}</label>
                              <div class="col-sm-9">
                                <select name="status" style="width: 100%">
                                  <option value="all" {{@$_GET['status'] == 'all' ? 'selected' : ''}}>All</option>
                                  <option value="1" {{@$_GET['status'] == '1' ? 'selected' : ''}}>Active</option>
                                  <option value="0" {{@$_GET['status'] == '0' ? 'selected' : ''}}>Deleted</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        @else
                          <input type="hidden" name="status" value="1">
                        @endif
                        <div class="col-md-3">
                          <div class="form-group row">
                            <button name="get_data" class="btn btn-success">{{__('Search')}}</button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <!-- Table -->
                    <div>
                      <table id="salesTable" class="table table-striped">
                        <thead>
                          <tr class="bg-dark">
                            <th>{{__('admin.sl')}}</th>
                            <th>{{__('admin.inv_no')}}</th>
                            <th>{{__('admin.date')}}</th>
                            <th>{{__('admin.customer_name')}}</th>
                            <th>{{__('admin.product_name')}}</th>
                            <th>{{__('admin.quantity')}}</th>
                            <th>{{__('admin.price')}}</th>
                            <th>{{__('admin.receive_amount')}}</th>
                            <th>{{__('admin.due_amount')}}</th>
                            <th>{{__('admin.total')}}</th>
                            <th class="screen-only">{{__('admin.action')}}</th>
                            <th class="screen-only note">{{__('admin.note')}}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php 
                            $page_qty_total = 0; $page_rcv_total = 0; $page_due_total = 0; $page_total = 0;
                            $pq = 0; $price = 0;
                            if(isset($_GET['page']) && $_GET['page']>0) $n = 1 + (($_GET['page'] - 1) * 10); else $n = 1;
                          @endphp
                          @if(count($datas) > 0)
                            @foreach($datas as $row)
                              <tr class="{{$row->status ? '' : 'text-light bg-danger'}}">
                                <td><a href="{{route('sales-invoice', $row->id)}}">{{$n++}}</a></td>
                                <td><a href="{{route('sales-invoice', $row->id)}}">{{$row->order_id}}</a></td>
                                <td>{{date('d-m-Y', strtotime($row->date))}}</td>
                                <td><a href="{{route('sales-invoice', $row->id)}}">{{$row->customer_name}}</a></td>
                                <td>
                                  @foreach(json_decode($row->products) as $p)
                                    {{$p->product_name}}<br>
                                    {{@$p->product_details}}
                                    @php
                                      $pq += @$p->quantity ? $p->quantity : 0;
                                      $price += @$p->price ? $p->price : 0;
                                      $page_qty_total += @$p->quantity;
                                    @endphp
                                  @endforeach
                                </td>
                                <td>{{$pq}}</td>
                                <td>{{number_format($price, 2)}}</td>
                                <td>
                                  @foreach(json_decode($row->payment) as $p)
                                    @foreach($account as $ac)
                                      @if($p->pid == $ac->id && $ac->type != 'Due')
                                        {{number_format($p->receive_amount, 2)}}<br>
                                        @php $page_rcv_total += $p->receive_amount; @endphp
                                      @endif
                                    @endforeach
                                  @endforeach
                                </td>
                                <td>
                                  @foreach(json_decode($row->payment) as $p)
                                    @foreach($account as $ac)
                                      @if($p->pid == $ac->id && $ac->type == 'Due')
                                        {{number_format($p->receive_amount, 2)}}<br>
                                        @php $page_due_total += $p->receive_amount; @endphp
                                      @endif
                                    @endforeach
                                  @endforeach
                                </td>
                                <td>
                                  {{number_format($row->total, 2)}}
                                  @php
                                    $page_total += $row->total;
                                    $pq = 0; $price = 0;
                                  @endphp
                                </td>
                                <td class="screen-only">
                                  @if($row->status == '1')
                                    @if(hasModuleAccess('Sales_Edit'))
                                      <a href="{{route('sales-trnx-edit', $row->id)}}" class="btn btn-warning btn-rounded btn-sm">{{__('admin.edit')}}</a> 
                                    @endif
                                    @if(hasModuleAccess('Sales_Delete'))
                                      <a href="{{route('sales-trnx-delete', $row->id)}}" class="btn btn-danger btn-rounded btn-sm" onclick="return confirm('Are you sure, you want to delete?')">{{__('admin.delete')}}</a>
                                    @endif
                                  @endif
                                </td>
                                <td class="screen-only note">{{$row->note}}</td>
                              </tr>
                            @endforeach
                          @else
                            <tr>
                              <td class="text-center">{{__('admin.no_data_found')}}</td>
                              <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            </tr>
                          @endif
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5" class="text-right">Page Total: </td>
                            <td>{{$page_qty_total}}</td>
                            <td></td>
                            <td>{{number_format($page_rcv_total, 2)}}</td>
                            <td>{{number_format($page_due_total, 2)}}</td>
                            <td>{{number_format($page_total, 2)}}</td>
                            <td class="screen-only note" colspan="2"></td>
                          </tr>
                          @if(count($total)>0)
                            <tr>
                              <td colspan="7" class="text-right">Total: </td>
                              <td>{{number_format($total[0]->total - $total[0]->total_due, 2)}}</td>
                              <td>{{number_format($total[0]->total_due, 2)}}</td>
                              <td>{{number_format($total[0]->total, 2)}}</td>
                              <td class="screen-only note" colspan="2"></td>
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
    function openForm(){
        $('#addForm').removeClass('d-none');
    }
    function printDiv(divId) {
      var printContents = document.getElementById(divId).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
      location.reload(); // restore scripts/events
    }

    // DataTables integration
    $(document).ready(function() {
      $('#salesTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
          {
            extend: 'copy',
            text: 'Copy',
            className: 'btn btn-rounded btn-sm btn-success'
          },
          {
            extend: 'csv',
            text: 'CSV',
            className: 'btn btn-rounded btn-sm btn-success'
          },
          {
            extend: 'excel',
            text: 'Excel',
            className: 'btn btn-rounded btn-sm btn-success'
          },
          {
            extend: 'pdf',
            text: 'PDF',
            className: 'btn btn-rounded btn-sm btn-success'
          },
          {
            extend: 'print',
            text: 'Print',
            className: 'btn btn-rounded btn-sm btn-success',
            exportOptions: {
              columns: ':not(.screen-only):not(.note)'
            },
            customize: function ( win ) {
              // Add company header to print
              $(win.document.body)
                .prepend(`
                  <div style="display:flex;justify-content:space-between;margin-bottom:20px;border-bottom:1px solid #ccc;padding-bottom:15px;">
                    <div style="flex:2;display:flex;align-items:flex-start;">
                      <div style="margin-right:15px;">
                        <img src='/admin/assets/images/logo.PNG' alt='Akash Global Trading' style='height:90px;width:auto;'>
                      </div>
                      <div style='font-family:Brush Script MT,cursive;'>
                        <h2 style='font-size:45px;margin:0;font-weight:normal;'>Akash Global Trading</h2>
                        <p style='font-size:25px;margin:0;font-style:italic;'>Importers, Exporters & General Suppliers</p>
                      </div>
                    </div>
                    <div style='flex:1;text-align:left;font-size:14px;'>
                      <p style='margin:0;'>8/1 Iswar Das Lane, Sutrapur, Dhaka-1100</p>
                      <p style='margin:0;'>Cell: 01755595883</p>
                      <p style='margin:0;'>Email: apon_tel@yahoo.com</p>
                      <p style='margin:0;'>Website: www.akashglobaltrading.com</p>
                    </div>
                  </div>
                `);
            }
          }
        ],
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100, 200],
        order: []
      });
    });
  </script>
  <!-- DataTables JS -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  </script>
</body>
</html>
