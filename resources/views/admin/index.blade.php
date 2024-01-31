@extends('layout.main')

@section('content')
    <!-- main content area start -->
    <div class="main-content">
        <!-- header area start -->
        <div class="header-area">
            <div class="row align-items-center">
                <!-- nav and search button -->
                <div class="col-md-6 col-sm-8 clearfix">
                    <div class="nav-btn pull-left">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- header area end -->
        <!-- page title area start -->
        <div class="page-title-area">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="breadcrumbs-area clearfix">
                        <h4 class="page-title pull-left">{{ $title }}</h4>
                        <ul class="breadcrumbs pull-left">
                            <li><a href="{{ route(auth()->user()->role . '.index') }}">Home</a></li>
                            <li><span>{{ $title }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 clearfix">
                    <div class="user-profile pull-right">
                        <img class="avatar user-thumb" src="{{ asset('assets/images/author/avatar.png') }}" alt="avatar">
                        <h4 class="user-name dropdown-toggle" data-toggle="dropdown">{{ auth()->user()->nama }} <i
                                class="fa fa-angle-down"></i></h4>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('logout') }}">Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page title area end -->
        <div class="main-content-inner">
            <!-- sales report area start -->
            <div class="sales-report-area sales-style-two">
                <div class="row">
                    <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
                        <div class="single-report">
                            <div class="s-sale-inner pt--30 mb-3">
                                <div class="s-report-title d-flex justify-content-between">
                                    <h4 class="header-title mb-0">Product Sold</h4>
                                    <select class="custome-select border-0 pr-3">
                                        <option selected="">Last 7 Days</option>
                                        <option value="0">Last 7 Days</option>
                                    </select>
                                </div>
                            </div>
                            <canvas id="coin_sales4" height="100"></canvas>
                        </div>
                    </div>
                    <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
                        <div class="single-report">
                            <div class="s-sale-inner pt--30 mb-3">
                                <div class="s-report-title d-flex justify-content-between">
                                    <h4 class="header-title mb-0">Gross Profit</h4>
                                    <select class="custome-select border-0 pr-3">
                                        <option selected="">Last 7 Days</option>
                                        <option value="0">Last 7 Days</option>
                                    </select>
                                </div>
                            </div>
                            <canvas id="coin_sales5" height="100"></canvas>
                        </div>
                    </div>
                    <div class="col-xl-3 col-ml-3 col-md-6  mt-5">
                        <div class="single-report">
                            <div class="s-sale-inner pt--30 mb-3">
                                <div class="s-report-title d-flex justify-content-between">
                                    <h4 class="header-title mb-0">Orders</h4>
                                    <select class="custome-select border-0 pr-3">
                                        <option selected="">Last 7 Days</option>
                                        <option value="0">Last 7 Days</option>
                                    </select>
                                </div>
                            </div>
                            <canvas id="coin_sales6" height="100"></canvas>
                        </div>
                    </div>
                    <div class="col-xl-3 col-ml-3 col-md-6 mt-5">
                        <div class="single-report">
                            <div class="s-sale-inner pt--30 mb-3">
                                <div class="s-report-title d-flex justify-content-between">
                                    <h4 class="header-title mb-0">New Coustomers</h4>
                                    <select class="custome-select border-0 pr-3">
                                        <option selected="">Last 7 Days</option>
                                        <option value="0">Last 7 Days</option>
                                    </select>
                                </div>
                            </div>
                            <canvas id="coin_sales7" height="100"></canvas>
                        </div>
                    </div>

                    <!-- data table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Tabel Pengguna</h4>
                                <div class="data-tables">
                                    <table id="table2" class="table table-bordered table-hover">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $i => $user)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>{{ $user->nama }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->role }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- data table end -->
                </div>
            </div>
            <!-- sales report area end -->
        </div>
    </div>
    <!-- main content area end -->
@endsection
