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
      @page { size: A4 portrait;; margin:5mm; }
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
            <h3 class="page-title">{{__('admin.profit_and_loss')}}</h3>
            <div>
              <button onclick="printDiv('printArea')" class="btn btn-primary btn-sm btn-rounded">{{__('print')}}</button>
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
                    <form action="{{route('profit-and-loss')}}" method="GET" class="mb-3 screen-only">
                      @csrf
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{__('admin.start_date')}}</label>
                            <div class="col-sm-8">
                              <input type="date" value="{{date('d-m-Y')}}" class="form-control" name="start_date">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{__('admin.end_date')}}</label>
                            <div class="col-sm-8">
                              <input type="date" value="{{date('d-m-Y')}}" class="form-control" name="end_date">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <button name="get_data" class="btn btn-success">Search</button>
                          </div>
                        </div>
                      </div>
                    </form>

                    <!-- Report Content -->
                    <div>
                      <h3 style="font-size: 24px; text-align: center;">{{__('admin.profit_and_loss')}}</h3>
                      <h4 style="font-size: 16px; text-align: center;">
                        {{date('d-m-Y', strtotime($start_date))}} - {{date('d-m-Y', strtotime($end_date))}}
                      </h4>
                      
                      @php
                      $pnl = $total['sales'] - $total['purchase'] - ($total['salary']*-1);
                      $te = $total['salary'] * -1;
                      $te += $total['discount'];
                      @endphp
                      
                      <table style="margin-top: 20px;">
                        <tr class="bg-dark">
                          <th>{{__('admin.Particulars')}}</th>
                          <th style="text-align: right; width: 200px;">{{__('admin.amount')}}</th>
                          <th style="text-align: right; width: 200px;">{{__('admin.amount')}}</th>
                        </tr>
                        <tr>
                          <td>{{__('admin.sales')}}</td>
                          <td style="text-align: right;"></td>
                          <td style="text-align: right;">{{number_format($total['sales'], 2)}}</td>
                        </tr>
                        <tr>
                          <td>{{__('admin.purchase')}}</td>
                          <td style="text-align: right;"></td>
                          <td style="text-align: right;">{{number_format($total['purchase'], 2)}}</td>
                        </tr>
                        <tr class="bg-dark">
                          <td>{{__('admin.expense')}}</td>
                          <td style="text-align: right;"></td>
                          <td style="text-align: right;"></td>
                        </tr>
                        @foreach($total['expense'] as $exp)
                          @php
                          $pnl -= $exp->total_amount;
                          $te += $exp->total_amount;
                          @endphp
                          <tr>
                            <td style="padding-left: 30px">{{$exp->expense_name}}</td>
                            <td style="text-align: right;">{{number_format($exp->total_amount, 2)}}</td>
                            <td style="text-align: right;"></td>
                          </tr>
                        @endforeach
                        <tr>
                          <td style="padding-left: 30px">{{__('admin.salary')}}</td>
                          <td style="text-align: right;">{{number_format($total['salary'] * -1, 2)}}</td>
                          <td style="text-align: right;"></td>
                        </tr>
                        <tr>
                          <td style="padding-left: 30px">{{__('admin.cash_discount')}}</td>
                          <td style="text-align: right;">{{number_format($total['discount'], 2)}}</td>
                          <td style="text-align: right;"></td>
                        </tr>
                        <tr>
                          <td>{{__('admin.total')}} {{__('admin.expense')}}</td>
                          <td style="text-align: right;"></td>
                          <td style="text-align: right;">{{number_format($te, 2)}}</td>
                        </tr>
                        <tr class="bg-dark">
                          <td>{{__('admin.net_income')}}</td>
                          <td style="text-align: right;"></td>
                          <td style="text-align: right;">{{number_format($pnl, 2)}}</td>
                        </tr>
                        <tr class="bg-dark">
                          <td>{{__('admin.balance_iheet_items')}}</td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>{{__('admin.accounts_receivable')}}</td>
                          <td style="text-align: right;"></td>
                          <td style="text-align: right;">{{number_format($total['sales'] - $total['receive'], 2)}}</td>
                        </tr>
                        <tr>
                          <td>{{__('admin.total_payment')}}</td>
                          <td style="text-align: right;"></td>
                          <td style="text-align: right;">{{number_format($total['receive'], 2)}}</td>
                        </tr>
                        <tr>
                          <td>{{__('admin.accounts_payable')}}</td>
                          <td style="text-align: right;"></td>
                          <td style="text-align: right;">{{number_format($total['purchase'] + $total['pay'], 2)}}</td>
                        </tr>
                        <tr>
                          <td>{{__('admin.quantity')}}</td>
                          <td style="text-align: right;"></td>
                          <td style="text-align: right;">{{number_format($quantity, 2)}}</td>
                        </tr>
                      </table>
                    </div>
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