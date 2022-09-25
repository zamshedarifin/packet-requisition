@extends('layouts.app')

@section('content')
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="{{route('user.dashboard')}}">Packet Requisition</a>
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
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i>{{\Auth::user()->sales_point_name}}</a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{route('user.logout')}}">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    @include('auth.nav')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Packet Requisition {{Auth::user()->sales_point_name}}
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                            <tr>
                                <th class="bg-secondary text-white">id</th>
                                <th class="bg-secondary text-white">Showroom</th>
                                <th class="bg-secondary text-white">Shop Id</th>
                                <th class="bg-primary text-white">Pride Requisition</th>
                                <th class="bg-success text-white">Ut Requisition</th>
                                <th class="bg-secondary text-white">Status</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>id</th>
                                <th>Showroom</th>
                                <th>Shop Id</th>
                                <th>Pride Requisition</th>
                                <th>Ut Requisition</th>
                                <th>Status</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @forelse($requisitionData as $k=>$data)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$data->showroom_name}}</td>
                                <td>{{$data->showroom_external_id}}</td>
                                <td>
                                            <span class="text-success" style="font-weight: bold; margin-left: 10px;"> Small : </span> <span style="font-weight: bold;"> @if($data->pride_packet_quantity_small) {{$data->pride_packet_quantity_small }} @else -- @endif </span>
                                            <span class="text-primary" style="font-weight: bold; margin-left: 10px;"> Medium : </span> <span style="font-weight: bold;"> @if($data->pride_packet_quantity_medium) {{$data->pride_packet_quantity_medium}} @else -- @endif </span>
                                            <span class="text-danger"  style="font-weight: bold; margin-left: 10px;"> Large : </span> <span style="font-weight: bold;"> @if($data->pride_packet_quantity_large) {{$data->pride_packet_quantity_large}}  @else -- @endif </span>
                                        </td>

<td>{{$data->urban_truth_packet_quantity}}</td>
                                <td>
                                    @if($data->status == 1)
                                        <span class="bg-success p-1 rounded text-white">Approve</span>
                                    @elseif($data->status == 3)
                                        <span class="bg-primary p-1 rounded text-white">Delivered</span>
                                    @else
                                        <span class="bg-danger p-1 rounded text-white">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="alert alert-danger text-center" role="alert">
                                           Sorry! you have no request data.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
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
