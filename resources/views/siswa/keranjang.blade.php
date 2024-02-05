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
            <div class="row">
                <!-- table dark start -->
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Keranjang</h4>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead class="text-uppercase bg-dark">
                                            <tr class="text-white">
                                                <th scope="col"></th>
                                                <th scope="col">Produk</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Total Harga</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($keranjangs as $keranjang)
                                                <tr class="text-center">
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
                                                    <td style="vertical-align: middle;">
                                                        <!-- Change the form method to DELETE -->
                                                        <form action="{{ route('keranjang.destroy', $keranjang->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                style="background: transparent; border: none; padding: 0;"
                                                                onclick="return confirm('Anda yakin ingin menghapus produk ini?')">
                                                                <a href=""><i class="ti-trash"></i></a>
                                                            </button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-weight-bold">
                                                <td colspan="4" class="text-right">TOTAL SELURUH HARGA :
                                                </td>
                                                <td>Rp.{{ number_format($totalHarga, 0, ',', '.') }},00</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                            <div class="text-right mt-3">
                                <form action="{{ route('checkout') }}" method="post">
                                    @csrf
                                    @if ($totalHarga > $wallet->saldo)
                                        <button type="submit" class="btn btn-dark col-2 btn-flat">Beli</button>
                                    @else
                                        <button type="submit" class="btn btn-dark col-2">Beli</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- table dark end -->

            </div>
        </div>
    </div>
    <!-- main content area end -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkoutForm = document.getElementById('checkoutForm');
            const submitButton = document.getElementById('submitButton');

            submitButton.addEventListener('click', function() {
                // Lakukan submit form secara manual
                checkoutForm.submit();
            });
        });
    </script>
@endsection
