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
            <section class="row py-3">
                <div class="col-12 my-5">
                    <div class="row align-items-center">
                        <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0"
                                src="{{ asset('storage/produk/' . $bestSeller->foto) }}" alt="..." /></div>
                        <div class="col-md-6">
                            <div class="small mb-1 py-1 px-2 text-white" style="background: red; width:fit-content;">
                                BEST
                                SELLER
                            </div>
                            <h1 class="display-5 fw-bolder">{{ $bestSeller->nama_produk }}</h1>
                            <div class="fs-5 mb-5">
                                <span> Rp. {{ number_format($bestSeller->harga, 0, ',', '.') }},00</span>
                            </div>
                            <p class="lead mb-3">{{ $bestSeller->desc }}</p>
                            <div class="d-flex">
                                <button class="btn btn-outline-dark flex-shrink-0" type="button" data-toggle="modal"
                                    data-target='#addToCart{{ $bestSeller->id }}'>
                                    <i class="ti-shopping-cart"></i> Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Related items section-->
            <section class="py-3 bg-light">
                <div class="container px-4 px-lg-5 mt-5">
                    <h2 class="fw-bolder mb-4">Products</h2>
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                        @foreach ($produks as $produk)
                            <div class="col-3 mb-5">
                                <div class="card h-100">
                                    <!-- Product image-->
                                    <img class="card-img-top" src="{{ asset('storage/produk/' . $produk->foto) }}"
                                        alt="{{ $produk->nama_produk }}" />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <h5 class="fw-bolder mb-3">{{ $produk->nama_produk }}</h5>
                                            <p class="mb-3">{{ $produk->kategori->nama_kategori }}</p>
                                            <h5>Rp. {{ number_format($produk->harga, 0, ',', '.') }},00</h5>
                                        </div>
                                    </div>
                                    <!-- Product actions-->
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
            </section>
        </div>
    </div>
    <!-- main content area end -->
    @foreach ($produks as $produk)
        <div class="modal fade" id="addToCart{{ $produk->id }}" tabindex="-1" role="dialog"
            aria-labelledby="addToCart{{ $produk->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addToCart{{ $produk->id }}Label">Tambah ke Keranjang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('addToCart', $produk->id) }}" method="post">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="id_produk" value="{{ $produk->id }}">
                            <input type="hidden" name="harga_produk" value="{{ $produk->harga }}">
                            <p>{{ $produk->stok }} available</p>
                            <div class="mb-3">
                                <label for="jumlah_produk" class="col-form-label">Qty :</label>
                                <input type="number" name="jumlah_produk" class="form-control" id="jumlah_produk"
                                    value="1" min="1" max="{{ $produk->stok }}">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
