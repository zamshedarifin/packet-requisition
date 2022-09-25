@extends('layouts.app')

@section('content')
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{route('admin.dashboard')}}">Admin Panel</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">

            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i> {{Auth::guard('admin')->user()->name}}</a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{route('admin.logout')}}">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        @include('admin.layouts.nav')
        <div id="layoutSidenav_content">
            <main>
                    <div class="container-fluid px-4 mt-4">
                        <h2>Zone Wise Requisition Details</h2>
                        <table class="table table-bordered mt-5">
                            <thead>
                            <tr>
                                <th colspan="3" class="bg-secondary text-white text-center"> Primary Details</th>
                                <th colspan="2" class="bg-success text-white text-center">Small Size</th>
                                <th colspan="2" class="bg-secondary text-white text-center">Medium Size</th>
                                <th colspan="2" class="bg-success text-white text-center">Large Size</th>
                                <th colspan="2" class="bg-secondary text-white text-center">Exclusive</th>
                                <th colspan="2" class="bg-success text-white text-center">Urban Truth</th>
                                <th colspan="" class="bg-secondary text-white text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td style="font-weight: bold">SL</td>
                                <td style="font-weight: bold">Showroom name</td>
                                <td style="font-weight: bold">Zone Name</td>

                                <td class="bg-dark text-white" style="font-weight: bold; font-size: 12px;">Product Sale Qty</th>
                                <td style="font-weight: bold; background: #ff2f2f; font-size: 12px; color: #fff">Packet Sale Qty</td>

                                <td class="bg-dark text-white" style="font-weight: bold; font-size: 12px;">Product Sale Qty</td>
                                <td style="font-weight: bold; background: #ff2f2f; font-size: 12px; color: #fff">Packet Sale Qty</td>

                                <td class="bg-dark text-white" style="font-weight: bold; font-size: 12px;">Product Sale Qty</th>
                                <td style="font-weight: bold; background: #ff2f2f; font-size: 12px; color: #fff">Packet Sale Qty</td>

                                <td class="bg-dark text-white" style="font-weight: bold; font-size: 12px;">Product Sale Qty</th>
                                <td style="font-weight: bold; background: #ff2f2f; font-size: 12px; color: #fff">Packet Sale Qty</td>

                                <td class="bg-dark text-white" style="font-weight: bold; font-size: 12px;">Product Sale Qty</th>
                                <td style="font-weight: bold; background: #ff2f2f; font-size: 12px; color: #fff">Packet Sale Qty</td>
                                <td>Details</td>
                            </tr>
                            <?php
                                $i=1;
                            ?>
                            @foreach($sales as $key=>$sale)

                                @php
                                    $pktSmall = 0;
                                    $pktMedium = 0;
                                    $pktLarge = 0;
                                    $pktExclusive = 0;
                                    $pktUrban = 0;
                                    $proSmall = 0;
                                    $proMedium = 0;
                                    $proLarge = 0;
                                    $proExclusive = 0;
                                    $proUrban = 0;
                                @endphp

                                @php
                                     foreach ($sale as $product):
                                             if($product['Bag']=='392002100390'){
                                                 $proSmall+=$product['Invoiceqty'];
                                                 $pktSmall+=$product['PKTQty'];
                                             }
                                              if($product['Bag']=='391002100391'){
                                                 $proMedium+=$product['Invoiceqty'];
                                                 $pktMedium+=$product['PKTQty'];
                                             }
                                               if($product['Bag']=='390002100016'){
                                                 $proLarge+=$product['Invoiceqty'];
                                                 $pktLarge+=$product['PKTQty'];
                                             }
                                                if($product['Bag']=='219867031822'){
                                                 $proUrban+=$product['Invoiceqty'];
                                                 $pktUrban+=$product['PKTQty'];
                                             }
                                     endforeach;
                                @endphp
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$key}}</td>
                                    <td>
                                        @if(!empty($sale))
                                            {{$sale[0]['Region']}}
                                        @endif
                                    </td>

                                    <td>{{number_format($proSmall,2)}}</td>
                                    <td>{{number_format($pktSmall,2)}}</td>

                                    <td>{{number_format($proMedium,2)}}</td>
                                    <td>{{number_format($pktMedium,2)}}</td>

                                    <td>{{number_format($proLarge,2)}}</td>
                                    <td>{{number_format($pktLarge,2)}}</td>

                                    <td>0.00</td>
                                    <td>0.00</td>

                                    <td>{{number_format($proUrban,2)}}</td>
                                    <td>{{number_format($pktUrban,2)}}</td>
                                    <td>
                                        <a href="{{route('admin.zoneWiseDetails',$key)}}" class="btn btn-success btn-sm">Show</a>
                                    </td>

                                </tr>


                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Developed By Pride &copy; {{date('Y')}}</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@stop
