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
                        <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
                            {{ auth()->user()->nama . '(' . auth()->user()->role . ')' }} <i class="fa fa-angle-down"></i>
                        </h4>
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
                    <div class="col-md-6 mt-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg1">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon">
                                        <i class="ti-plus"></i>
                                        Top Up
                                    </div>
                                    <h2>{{ $dataTopup }}</h2>
                                </div>

                                {{-- <canvas id="seolinechart1" height="50"></canvas> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg1">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon">
                                        <i class="ti-archive"></i>
                                        Tarik Tunai
                                    </div>
                                    <h2>{{ $dataWithdrawal }}</h2>
                                </div>

                                {{-- <canvas id="seolinechart1" height="50"></canvas> --}}
                            </div>
                        </div>
                    </div>

                    <!-- data table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Permintaan Top Up</h4>
                                <div class="data-tables">
                                    <table id="table2" class="table table-bordered table-hover">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>No.</th>
                                                <th>siswa</th>
                                                <th>Rekening</th>
                                                <th>Nominal</th>
                                                <th>Kode Unik</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requestTopups as $i => $topup)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>{{ $topup->wallet->user->nama }}</td>
                                                    <td>{{ $topup->rekening }}</td>
                                                    <td>{{ $topup->nominal }}</td>
                                                    <td>{{ $topup->kode_unik }}</td>
                                                    <td>{{ $topup->status }}</td>
                                                    <td class="col-2">
                                                        @if ($topup->status === 'menunggu')
                                                            <form action="{{ route('konfirmasi.topup', $topup->id) }}"
                                                                method="post" style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-primary btn-sm"><i
                                                                        class="ti-check"></i></button>
                                                            </form>

                                                            <form action="{{ route('tolak.topup', $topup->id) }}"
                                                                method="post" style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                                        class="ti-close"></i></button>
                                                            </form>
                                                        @elseif($topup->status === 'dikonfirmasi')
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm col-12">{{ $topup->status }}</button>
                                                        @else
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm col-12">{{ $topup->status }}</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- data table end -->

                    <!-- data table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Permintaan Tarik Tunai</h4>
                                <div class="data-tables">
                                    <table id="table2" class="table table-bordered table-hover">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>No.</th>
                                                <th>siswa</th>
                                                <th>Rekening</th>
                                                <th>Nominal</th>
                                                <th>Kode Unik</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requestWithdrawals as $i => $withdrawal)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>{{ $withdrawal->wallet->user->nama }}</td>
                                                    <td>{{ $withdrawal->rekening }}</td>
                                                    <td>{{ $withdrawal->nominal }}</td>
                                                    <td>{{ $withdrawal->kode_unik }}</td>
                                                    <td>{{ $withdrawal->status }}</td>
                                                    <td class="col-2">
                                                        @if ($withdrawal->status === 'menunggu')
                                                            <form
                                                                action="{{ route('konfirmasi.withdrawal', $withdrawal->id) }}"
                                                                method="post" style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-primary btn-sm"><i
                                                                        class="ti-check"></i></button>
                                                            </form>

                                                            <form action="{{ route('tolak.withdrawal', $withdrawal->id) }}"
                                                                method="post" style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                                        class="ti-close"></i></button>
                                                            </form>
                                                        @elseif($withdrawal->status === 'dikonfirmasi')
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm col-12">{{ $withdrawal->status }}</button>
                                                        @else
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm col-12">{{ $withdrawal->status }}</button>
                                                        @endif
                                                    </td>
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
