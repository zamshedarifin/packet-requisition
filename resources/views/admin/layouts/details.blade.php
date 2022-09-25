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
            @if($requisitionData)
            <main>
                <div class="container-fluid px-4">
                    <h2 class="mt-4">Packet Requisition <span class="text-primary">{{$requisitionData->showroom_name}}</span></h2>
                    @if($requisitionData->challan_number)
                    <h6>#Challan_Number: <span class="text-danger">{{$requisitionData->challan_number}} </span> </h6>
                    @endif

                    <div class="container mt-5">
                        @if (\Session::has('success'))
                            <div class="alert alert-success" >
                                <strong>Well done!</strong> Status Has been updated Successfully.
                            </div>
                        @endif
                            <form method="POST" action="{{route('admin.requsition-details',$requisitionData->id)}}">
                                @csrf

                                <input type="hidden" name="showroom" value="{{$requisitionData->showroom_name}}">
                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header">
                                                <span>Pride Requisition List</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-4">
                                                        <label class="" for="pride_packet_quantity_small">Pride Small Packet</label>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="pride_small_packet_current_quantity">Physical Quantity</label>
                                                            <input type="text" disabled value="{{$requisitionData->pride_small_packet_current_quantity}}" class="form-control" name="pride_small_packet_current_quantity" id="pride_small_packet_current_quantity" placeholder="Small">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="pride_packet_quantity_small">Request Quantity</label>
                                                            <input type="text" value="{{$requisitionData->pride_packet_quantity_small}}" disabled class="form-control" name="pride_packet_quantity_small" id="pride_packet_quantity_small" placeholder="Small">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="pride_packet_quantity_small">Approve Quantity</label>
                                                            <input type="text" class="form-control" value="{{$requisitionData->pride_approved_quantity_small}}" name="pride_packet_approve_quantity_small" id="pride_packet_quantity_small" placeholder="Small">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col mt-4">
                                                        <label class="" for="pride_packet_quantity_medium">Pride Medium Packet</label>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="pride_medium_packet_current_quantity">Physical Quantity</label>
                                                            <input type="text" disabled value="{{$requisitionData->pride_medium_packet_current_quantity}}" class="form-control" name="pride_medium_packet_current_quantity" id="pride_medium_packet_current_quantity" placeholder="Medium">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="pride_packet_quantity_medium">Request Quantity</label>
                                                            <input type="text" value="{{$requisitionData->pride_packet_quantity_medium}}" disabled class="form-control" name="pride_packet_quantity_medium" id="pride_packet_quantity_medium" placeholder="Medium">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="pride_packet_quantity_medium">Approve Quantity</label>
                                                            <input type="text" class="form-control" value="{{$requisitionData->pride_approved_quantity_medium}}" name="pride_packet_approve_quantity_medium" id="pride_packet_quantity_medium" placeholder="Medium">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col mt-4">
                                                        <label class="" for="pride_packet_quantity_large">Pride Large Packet</label>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="pride_large_packet_current_quantity">Physical Quantity</label>
                                                            <input type="text" disabled value="{{$requisitionData->pride_large_packet_current_quantity}}" class="form-control" name="pride_large_packet_current_quantity" id="pride_large_packet_current_quantity" placeholder="Large">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="pride_packet_quantity_large">Request Quantity</label>
                                                            <input type="text" value="{{$requisitionData->pride_packet_quantity_large}}" disabled class="form-control" name="pride_packet_quantity_large" id="pride_packet_quantity_large" placeholder="Large">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="pride_packet_quantity_large">Approve Quantity</label>
                                                            <input type="text"  class="form-control" value="{{$requisitionData->pride_approved_quantity_large}}" name="pride_packet_approve_quantity_large" id="pride_packet_quantity_large" placeholder="Large">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header">
                                                <span>Urban Truth Requisition</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-4">
                                                        <label class="" for="urban_truth_packet_quantity">Urban Truth Small Packet</label>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="urban_truth_packet_current_quantity">Physical Quantity</label>
                                                            <input type="text" value="{{$requisitionData->urban_truth_packet_current_quantity}}" disabled class="form-control" name="urban_truth_packet_current_quantity" id="urban_truth_packet_current_quantity" placeholder="Quantity">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="urban_truth_packet_quantity">Request Quantity</label>
                                                            <input type="text" value="{{$requisitionData->urban_truth_packet_quantity}}" disabled class="form-control" name="urban_truth_packet_quantity" id="urban_truth_packet_quantity" placeholder="Quantity">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="urban_truth_packet_quantity">Approve Quantity</label>
                                                            <input type="text" class="form-control" value="{{$requisitionData->urban_truth_approved_quantity}}" name="urban_truth_approve_quantity" id="urban_truth_packet_quantity" placeholder="Quantity">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col" style="text-align: right;">
                                        <div class="card" style="border: none">
                                            <div class="card-body">
                                                <input type="submit" class="btn btn-primary" value="Approve">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                    </div>
                </div>

                <div class="container">
                    <h2>Warehouse Stock qty</h2>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="bg-secondary text-white">SL</th>
                            <th class="bg-primary text-white">Size </th>
                            <th class="bg-success text-white">Qty</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>1.</td>
                            <td>Pride Small</td>
                            <td>{{round($pktQty['smallPkt']->Stock)}}</td>
                        </tr>

                        <tr>
                            <td>2.</td>
                            <td>Pride Medium</td>
                            <td>{{round($pktQty['mediumPkt']->Stock)}}</td>
                        </tr>

                        <tr>
                            <td>3.</td>
                            <td>Pride Large</td>
                            <td>{{round($pktQty['largePkt']->Stock)}}</td>
                        </tr>

                        <tr>
                            <td>4.</td>
                            <td>Urban Truth</td>
                            <td>{{round($pktQty['utPkt']->Stock)}}</td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-center" style="font-weight: bold">Grand Total</td>
                            <td style="font-weight: bold"> {{round($pktQty['smallPkt']->Stock + $pktQty['mediumPkt']->Stock + $pktQty['largePkt']->Stock + $pktQty['utPkt']->Stock)}}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </main>
            @endif
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
