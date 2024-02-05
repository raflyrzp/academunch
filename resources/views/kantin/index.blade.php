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
                    <div class="col-md-6 mt-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg1">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon">
                                        <i class="ti-wallet"></i>
                                        Pemasukan
                                    </div>
                                    <h2>Rp. {{ number_format($pemasukan, 0, ',', '.') }},00</h2>
                                </div>

                                {{-- <canvas id="seolinechart1" height="50"></canvas> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg2">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon">
                                        <i class="ti-wallet"></i>
                                        Pemasukan Hari Ini
                                    </div>
                                    <h2>Rp. {{ number_format($pemasukanHariIni, 0, ',', '.') }},00</h2>
                                </div>

                                {{-- <canvas id="seolinechart1" height="50"></canvas> --}}
                            </div>
                        </div>
                    </div>

                    <!-- data table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Permintaan Pembelian</h4>
                                <div class="data-tables">
                                    <table id="table2" class="table table-bordered table-hover">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>No.</th>
                                                <th>Invoice</th>
                                                <th>siswa</th>
                                                <th>Produk</th>
                                                <th>Total Harga</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaksis as $i => $groupedTransaksi)
                                                @php
                                                    $firstTransaksi = App\Models\Transaksi::where('invoice', $groupedTransaksi->invoice)->first();
                                                    $produks = App\Models\Transaksi::where('invoice', $groupedTransaksi->invoice)->get();
                                                @endphp
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>{{ $firstTransaksi->invoice }}</td>
                                                    <td>{{ $firstTransaksi->user->nama }}</td>
                                                    <td>
                                                        @foreach ($produks as $produk)
                                                            <li>{{ $produk->produk->nama_produk . ' (' . $produk->kuantitas . ')' }}
                                                            </li>
                                                        @endforeach
                                                    </td>
                                                    <td>Rp.
                                                        {{ number_format($groupedTransaksi->total_harga, 2, ',', '.') }}
                                                    </td>
                                                    <td>{{ $firstTransaksi->status }}</td>
                                                    <td class="col-2">
                                                        @if ($firstTransaksi->status === 'dipesan')
                                                            <form
                                                                action="{{ route('konfirmasi.transaksi', $firstTransaksi->invoice) }}"
                                                                method="post" style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-success btn-sm"><i
                                                                        class="ti-check"></i></button>
                                                            </form>

                                                            <form
                                                                action="{{ route('tolak.transaksi', $firstTransaksi->invoice) }}"
                                                                method="post" style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                                        class="ti-close"></i></button>
                                                            </form>
                                                        @elseif($firstTransaksi->status === 'dikonfirmasi')
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm col-12">{{ $firstTransaksi->status }}</button>
                                                        @else
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm col-12">{{ $firstTransaksi->status }}</button>
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
