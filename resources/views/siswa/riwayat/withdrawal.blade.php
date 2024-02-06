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
                        {{-- <img class="avatar user-thumb" src="{{ asset('assets/images/author/avatar.png') }}" alt="avatar"> --}}

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
                    <!-- laporan -->
                    <div class="col-md-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Riwayat Tarik Tunai</h4>
                                <a href="{{ route('cetak.seluruh.withdrawal') }}" class="btn btn-danger mb-3"><i
                                        class="ti-printer"></i>
                                    Cetak</a>
                                <div class="list-group list-group-flush">
                                    @foreach ($withdrawals as $withdrawal)
                                        <h6 class="bg-body-tertiary p-2 border-top border-bottom">
                                            {{ $withdrawal->tanggal }}
                                            <span class="float-right text-danger">- Rp.
                                                {{ number_format($withdrawal->nominal, 2, ',', '.') }}</span>
                                        </h6>
                                        @php
                                            $withdrawalList = App\Models\Withdrawal::where(DB::raw('DATE(created_at)'), $withdrawal->tanggal)
                                                ->where('rekening', $wallet->rekening)
                                                ->orderBy('created_at', 'desc')
                                                ->get();
                                        @endphp

                                        <ul class="list-group list-group-light mb-4">
                                            @foreach ($withdrawalList as $list)
                                                <a href="{{ route('cetak.withdrawal', $list->kode_unik) }}">

                                                    <li
                                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center col-12">
                                                            <div class="ms-3 col-12">
                                                                <p class="fw-bold mb-1">{{ $list->kode_unik }} <span
                                                                        class="float-right">{{ $list->created_at }}</span>
                                                                </p>
                                                                <p class="text-danger mb-0">- Rp.
                                                                    {{ number_format($list->nominal, 2, ',', '.') }}
                                                                </p>
                                                                @if ($list->status == 'menunggu')
                                                                    <p class="badge badge-info p-2">
                                                                        {{ strtoupper($list->status) }}
                                                                    </p>
                                                                @elseif($list->status == 'dikonfirmasi')
                                                                    <p class="badge badge-success p-2">
                                                                        {{ strtoupper($list->status) }}
                                                                    </p>
                                                                @else
                                                                    <p class="badge badge-danger p-2">
                                                                        {{ strtoupper($list->status) }}
                                                                    </p>
                                                                @endif
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
            <!-- sales report area end -->
        </div>
    </div>
    <!-- main content area end -->
@endsection
