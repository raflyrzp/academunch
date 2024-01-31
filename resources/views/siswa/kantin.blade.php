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
            @if ($bestSeller)
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0"
                                            src="{{ asset('storage/produk/' . $bestSeller->foto) }}"
                                            alt="{{ $bestSeller->nama_produk }}"
                                            style="max-height: 35em; object-fit:cover;" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small mb-1 py-1 px-2 text-white"
                                            style="background: red; width:fit-content;">
                                            BEST
                                            SELLER
                                        </div>
                                        <h1 class="display-5 fw-bolder">{{ $bestSeller->nama_produk }}</h1>
                                        <div class="fs-5 mb-5">
                                            <span>{{ $bestSeller->desc }}</span>
                                        </div>
                                        <p>Tersedia : {{ $bestSeller->stok }}</p>
                                        <p class="lead mb-3">Rp. {{ number_format($bestSeller->harga, 0, ',', '.') }},00
                                        </p>
                                        <div class="d-flex">
                                            <button class="btn btn-outline-dark flex-shrink-0" type="button"
                                                data-toggle="modal" data-target='#addToCart{{ $bestSeller->id }}'>
                                                <i class="ti-shopping-cart"></i> Tambah ke Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="font-weight-bold">Produk</h4>
                            <div
                                class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center mt-5">
                                @foreach ($produks as $produk)
                                    <div class="col-3 mb-5">
                                        <div class="card h-100"
                                            style="box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;">
                                            <img class="card-img-top" src="{{ asset('storage/produk/' . $produk->foto) }}"
                                                alt="{{ $produk->nama_produk }}"
                                                style="max-height: 15em; object-fit: cover;" />
                                            <div
                                                class="card-img-overlay text-white top-0 right-0 p-0 m-0 col-5 text-center">
                                                <p class="text-white p-1" style="background-color: rgba(0, 0, 0, 0.7)">
                                                    {{ $produk->kategori->nama_kategori }}</p>
                                            </div>
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <h5 class="fw-bolder mb-3">{{ $produk->nama_produk }}</h5>
                                                    <p class="mb-3">Tersedia : {{ $produk->stok }}</p>
                                                    <h5>Rp. {{ number_format($produk->harga, 0, ',', '.') }},00</h5>
                                                </div>
                                            </div>
                                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                                <div class="text-center"><button class="btn btn-outline-dark mt-auto"
                                                        data-toggle="modal" data-target="#addToCart{{ $produk->id }}"><i
                                                            class="ti-shopping-cart"></i> Tambah ke Keranjang</button></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($produks as $produk)
            <div class="modal fade" id="addToCart{{ $produk->id }}" tabindex="-1" role="dialog"
                aria-labelledby="addToCartModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="addToCartModalLabel">Tambah ke Keranjang</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('addToCart', $produk->id) }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="id_produk" value="{{ $produk->id }}">
                                <input type="hidden" name="harga" value="{{ $produk->harga }}">
                                <div class="form-group">
                                    <label for="jumlah_produk">Qty</label>
                                    <input type="number" id="jumlah_produk" class="form-control" min="1"
                                        max="{{ $produk->stok }}" name="jumlah_produk" value="1" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Batal</span>
                                </button>
                                <button type="submit" class="btn btn-primary ms-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Tambah</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection
