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
                                <h4 class="header-title">Tabel Produk</h4>
                                <div class="data-tables">
                                    <table id="table2" class="table table-bordered table-hover">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>No.</th>
                                                <th>Produk</th>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                                <th>Stok</th>
                                                <th>Kategori</th>
                                                <th>Desc</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($produks as $i => $produk)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td class="text-center"><img
                                                            src="{{ asset('./storage/produk/' . $produk->foto) }}"
                                                            alt="{{ $produk->nama_produk }}" style="max-width: 100px;"></td>
                                                    <td>{{ $produk->nama_produk }}</td>
                                                    <td>Rp. {{ number_format($produk->harga, 0, ',', '.') }},00</td>
                                                    <td>{{ $produk->stok }}</td>
                                                    <td>{{ $produk->kategori->nama_kategori }}</td>
                                                    <td>{{ $produk->desc }}</td>
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
