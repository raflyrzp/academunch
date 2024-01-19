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

        <div class="main-content-inner">
            <div class="row">
                <div class="col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-area">
                                <div class="invoice-head">
                                    <div class="row">
                                        <div class="iv-left col-6">
                                            <span>CHECKOUT</span>
                                        </div>
                                        <div class="iv-right col-6 text-md-right">
                                            <span>#34445998</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="invoice-address">
                                            <h3>Checkout</h3>
                                            <h5>{{ auth()->user()->nama }}</h5>
                                            <p>{{ auth()->user()->email }}</p>
                                            <p>Rekening :</p>
                                            <p>{{ auth()->user()->wallet->rekening }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <ul class="invoice-date">
                                            <li>Invoice Date : now()</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="invoice-table table-responsive mt-5">
                                    <table class="table table-bordered table-hover text-right">
                                        <thead>
                                            <tr class="text-capitalize">
                                                <th scope="col"></th>
                                                <th scope="col">Produk</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Total Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align: middle;"> <img width="100px"
                                                        src="{{ asset('storage/produk/' . $keranjang->produk->foto) }}"
                                                        alt=""></td>
                                                <td style="vertical-align: middle;">
                                                    {{ $keranjang->produk->nama_produk }}</td>
                                                <td style="vertical-align: middle;">
                                                    Rp.{{ number_format($keranjang->produk->harga, 0, ',', '.') }},00
                                                </td>
                                                <td style="vertical-align: middle;">{{ $keranjang->jumlah_produk }}
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    Rp.{{ number_format($keranjang->total_harga, 0, ',', '.') }},00
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">total balance :</td>
                                                <td>$140</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="invoice-buttons text-right">
                                <a href="#" class="invoice-btn">print invoice</a>
                                <a href="#" class="invoice-btn">send invoice</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content area end -->
@endsection
