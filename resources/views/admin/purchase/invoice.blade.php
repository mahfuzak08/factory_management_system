<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin._head')
    <style>
        /* Base styles for both screen and print */
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        
        #printArea {
            background: white;
            padding: 20px;
        }
        
        .company-header {
            display: flex;
            
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 15px;
        }
        
        .company-info h2 {
            font-family: 'Brush Script MT', cursive;
            font-size: 45px;
            margin: 0;
            font-weight: normal;
        }
        
        .company-info p {
            font-family: 'Brush Script MT', cursive;
            font-size: 25px;
            margin: 0;
            font-style: italic;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .bg-dark {
            background-color: #343a40;
            color: white;
        }
        
        .text-right {
            text-align: right;
        }
        
        /* Print-specific styles */
        @media print {
            
            
            #printArea, #printArea * {
                visibility: visible;
            }
            
            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
                background: white;
            }
            
            .no-print {
                display: none !important;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
            
            /* Ensure background colors print */
            .bg-dark {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background-color: #343a40 !important;
                color: white !important;
            }
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
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title no-print">{{ __('admin.purchase_register') }}</h4>

                                    <!-- Print Area -->
                                    <div id="printArea">
                                        <!-- Company Header -->
                                        <div class="company-header" >
                                            <div style="flex: 2; display: flex; align-items: flex-start;">
                                                <div style="margin-right: 15px;">
                                                    <img src="/admin/assets/images/logo.PNG" 
                                                         alt="Akash Global Trading" 
                                                         style="height: 90px; width: auto;">
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

                                        <!-- Invoice Details -->
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                                            <div style="width: 50%;">
                                                <p style="margin: 0 0 5px 0;"><strong>{{$invoice[0]->vendor_name}}</strong></p>
                                                <p style="margin: 0;">{{$invoice[0]->mobile}},<br>{{$invoice[0]->address}}.</p>
                                            </div>
                                            <div style="width: 50%; text-align: right;">
                                                <p style="margin: 0 0 5px 0;"><strong>#INV-{{$invoice[0]->id}}</strong></p>
                                                <p style="margin: 0;">Date: {{date('d-m-Y', strtotime($invoice[0]->date))}}</p>
                                            </div>
                                        </div>

                                        <!-- Products Table -->
                                        <table>
                                            <thead>
                                                <tr class="bg-dark text-white">
                                                    <th>#</th>
                                                    <th>Description</th>
                                                    <th class="text-right">Quantity</th>
                                                    <th class="text-right">Unit cost</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $products = json_decode($invoice[0]->products);
                                                    $c=0;
                                                    $total = 0;
                                                @endphp
                                                @foreach($products as $item)
                                                @php
                                                    $total += $item->total;
                                                @endphp
                                                <tr>
                                                    <td>{{++$c}}</td>
                                                    <td>{{$item->product_name}}<br>{{@$item->product_details}}</td>
                                                    <td class="text-right">{{$item->quantity}}</td>
                                                    <td class="text-right">{{$item->price}}</td>
                                                    <td class="text-right">{{$item->total}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <!-- Totals Section -->
                                        <div style="text-align: right; margin-top: 20px;">
                                            <p style="margin: 5px 0;"><strong>Subtotal:</strong> {{$total}}</p>
                                            <p style="margin: 5px 0;"><strong>Discount:</strong> {{ $invoice[0]->discount }}</p>
                                            <h4 style="margin: 10px 0;"><strong>Total:</strong> {{ $invoice[0]->total }}</h4>
                                            <p style="margin: 5px 0;"><strong>Amount Received:</strong></p>
                                            @foreach(json_decode($invoice[0]->payment) as $p)
                                                @foreach($account as $ac)
                                                    @if($p->pid == $ac->id)
                                                        <p style="margin: 5px 0;">{{$ac->name}}: {{$p->receive_amount}}</p>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div> <!-- END printArea -->

                                    <!-- Print Button -->
                                    <div class="no-print" style="margin-top: 20px;">
                                        <button class="btn btn-primary" onclick="printDiv('printArea')">
                                            <i class="mdi mdi-printer mr-1"></i> Print
                                        </button>
                                        <a href="{{route('purchase')}}" class="btn btn-secondary">Back</a>
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