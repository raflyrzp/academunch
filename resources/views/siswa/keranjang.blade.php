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

        <section class="h-100 h-custom" style="background-color: #eee;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col">
                        <div class="card">
                            <div class="card-body p-4">

                                <div class="row">

                                    <div class="col-lg-8">
                                        <h5 class="mb-3">Keranjang</h5>
                                        <hr>

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <p class="mb-1">Lihat ini...</p>
                                                <p class="mb-0">Kamu mempunyai {{ $keranjangs->count() }} jenis produk,
                                                    Ayo Checkout!!</p>
                                            </div>
                                        </div>

                                        @foreach ($keranjangs as $keranjang)
                                            <div class="card mb-3"
                                                style="box-shadow: rgb(204, 219, 232) 3px 3px 6px 0px inset, rgba(255, 255, 255, 0.5) -3px -3px 6px 1px inset;">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div>
                                                                <img src="{{ asset('storage/produk/' . $keranjang->produk->foto) }}"
                                                                    class="img-fluid rounded-3" alt="Shopping item"
                                                                    style="width: 65px;">
                                                            </div>
                                                            <div class="ml-3">
                                                                <h5>{{ $keranjang->produk->nama_produk }}</h5>
                                                                <p class="small mb-0">
                                                                    Rp.
                                                                    {{ number_format($keranjang->produk->harga, 2, ',', '.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div style="width: 100px;">
                                                                <h5 class="fw-normal mb-0">{{ $keranjang->jumlah_produk }}
                                                                    (pcs)
                                                                </h5>
                                                            </div>
                                                            <div style="width: 150px;">
                                                                <h5 class="mb-0">Rp.
                                                                    {{ number_format($keranjang->total_harga, 2, ',', '.') }}
                                                                </h5>
                                                            </div>
                                                            <form action="{{ route('keranjang.destroy', $keranjang->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    style="background: transparent; border: none; padding: 0;"
                                                                    onclick="return confirm('Anda yakin ingin menghapus produk ini?')">
                                                                    <a href="" class="text-danger"><i
                                                                            class="ti-trash"></i></a>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-lg-4">

                                        <div class="card bg-dark text-white rounded-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <h5 class="mb-0">Checkout</h5>
                                                </div>
                                                <p class="small text-white">Saldo</p>
                                                <p class="text-white">Rp. {{ number_format($wallet->saldo, 2, ',', '.') }}
                                                </p>

                                                <hr class="my-4 bg-white">

                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-2 text-white">Subtotal</p>
                                                    <p class="mb-2 text-white">Rp.
                                                        {{ number_format($totalHarga, 2, ',', '.') }}</p>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-2 text-white">Diskon</p>
                                                    <p class="mb-2 text-white">0%</p>
                                                </div>

                                                <div class="d-flex justify-content-between mb-4">
                                                    <p class="mb-2 text-white">Total</p>
                                                    <p class="mb-2 text-white">Rp.
                                                        {{ number_format($totalHarga, 2, ',', '.') }}</p>
                                                </div>


                                                <form action="{{ route('checkout') }}" method="post">
                                                    @csrf
                                                    @if ($totalHarga > $wallet->saldo)
                                                        <button type="submit" class="btn btn-primary btn-block btn-lg"
                                                            disabled>
                                                            <div class="d-flex justify-content-center">
                                                                <span>SALDO KAMU TIDAK CUKUP</span>
                                                            </div>
                                                        </button>
                                                    @else
                                                        <button type="submit" class="btn btn-primary btn-block btn-lg">
                                                            <div class="d-flex justify-content-between">
                                                                <span>Rp.
                                                                    {{ number_format($totalHarga, 2, ',', '.') }}</span>
                                                                <span>CHECKOUT</span>
                                                            </div>
                                                        </button>
                                                    @endif
                                                </form>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


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
