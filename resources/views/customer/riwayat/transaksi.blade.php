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
                            <li><a href="index.html">Home</a></li>
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
            <div class="sales-report-area sales-style-two">
                <div class="row">
                    <!-- laporan -->
                    <div class="col-md-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Riwayat Transaksi</h4>
                                <div class="list-group list-group-flush">
                                    @foreach ($transaksis as $transaksi)
                                        <h6 class="bg-body-tertiary p-2 border-top border-bottom">
                                            {{ $transaksi->tanggal }}
                                            <span class="float-right">Rp.
                                                {{ number_format($transaksi->total_harga, 2, ',', '.') }}</span>
                                        </h6>
                                        @php
                                            $transaksiList = App\Models\Transaksi::select('invoice', 'tgl_transaksi')
                                                ->where(DB::raw('DATE(tgl_transaksi)'), $transaksi->tanggal)
                                                ->where('id_user', auth()->id())
                                                ->groupBy('invoice', 'tgl_transaksi')
                                                ->orderBy('tgl_transaksi', 'desc')
                                                ->get();
                                        @endphp

                                        <ul class="list-group list-group-light mb-4">
                                            @foreach ($transaksiList as $list)
                                                @php
                                                    $totalHarga = App\Models\Transaksi::where('invoice', $list->invoice)->sum('total_harga');
                                                @endphp
                                                <a href="{{ route('customer.transaksi.detail', $list->invoice) }}">
                                                    <li
                                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center col-12">
                                                            <div class="ms-3 col-12">
                                                                <p class="fw-bold mb-1">{{ $list->invoice }} <span
                                                                        class="float-right">{{ $list->tgl_transaksi }}</span>
                                                                </p>
                                                                <p class="text-muted mb-0">Rp.
                                                                    {{ number_format($totalHarga, 2, ',', '.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </a>
                                            @endforeach
                                        </ul>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- laporan -->
                </div>
            </div>
        </div>
    </div>
    <!-- main content area end -->
@endsection
