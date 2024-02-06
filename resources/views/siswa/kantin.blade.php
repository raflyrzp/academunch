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
                                            <button class="btn btn-primary flex-shrink-0" type="button" data-toggle="modal"
                                                data-target='#addToCart{{ $bestSeller->id }}'>
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
                                        <div class="" style="border-radius:20px;">
                                            <div class="d-flex justify-content-center align-items-center position-relative"
                                                style="height: 12em; overflow: hidden; border-radius: 20px;">
                                                <img class="card-img-top  position-relative"
                                                    src="{{ asset('storage/produk/' . $produk->foto) }}"
                                                    alt="{{ $produk->nama_produk }}"
                                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 20px; z-index: 1;" />

                                                <div
                                                    style="content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius: 20px; box-shadow: rgba(204, 219, 232, 0.5) 3px 3px 6px 0px inset, rgba(255, 255, 255, 0.5) -3px -3px 6px 1px inset; z-index:999;">
                                                </div>
                                            </div>

                                            <div class="m-3">

                                                <h6 class="mb-2">{{ $produk->nama_produk }} <span
                                                        class="small float-right">{{ $produk->stok }}(pcs)</span>
                                                </h6>
                                                <p class="mb-2">{{ $produk->kategori->nama_kategori }}</p>
                                                {{-- <p class="mb-3">Tersedia : {{ $produk->stok }}</p> --}}
                                                <h5 class="mb-3">Rp. {{ number_format($produk->harga, 2, ',', '.') }}
                                                </h5>
                                                <button class="btn btn-primary btn-sm btn-block btn-rounded"
                                                    data-toggle="modal" data-target="#addToCart{{ $produk->id }}"><i
                                                        class="ti-shopping-cart"></i> Tambah ke Keranjang</button>
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
                                <p class="mb-3">Tersedia : {{ $produk->stok }} (pcs)</p>
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
