@extends('layout.main')

@section('content')
    @if (auth()->user()->nama === 'Adel' && !session('tampil'))
        {{-- <link rel="stylesheet" href="{{ asset('assets/js/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" />

        <script src="{{ asset('assets/js/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });

            Toast.fire({
                icon: "info",
                title: "Halo cintaku, manisku, blaem-blaemku❤️",
            });

            </script> --}}

        <div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="promoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <section class="p-3"
                            style="background-image: url({{ asset('assets/images/bg/adel.jpg') }}); background-size:cover; width:100%; height:60vh; background-position:100% center;">
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                style="position: absolute; top: 10px; right: 10px;"></button>
                            <div class="container">
                                <div class="row">
                                    <h1 class="text-white ">Halo Cintaku, Manisku, Blaem-blaemku❤️</h1>
                                    <h1 class="col-12 text-center" style="top:160px; left:80px; font-size:4rem;">❤️</h1>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var promoModal = new bootstrap.Modal(document.getElementById('promoModal'));

                var closeButton = document.querySelector('#promoModal .btn-close');
                closeButton.addEventListener('click', function() {
                    promoModal.hide();
                });

                var delayTime = 1000;

                setTimeout(function() {
                    promoModal.show();
                }, delayTime);
            });
        </script>
        {{ session(['tampil' => true]) }}
    @endif
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
                <!-- seo fact area start -->
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-7 col-sm-12 mt-5 mb-3">
                            <div class="card">
                                <div class="seo-fact sbg1">
                                    <div class="p-4 d-flex justify-content-between align-items-center mb-3">
                                        <div class="seofct-icon">
                                            <h2><i class="ti-wallet"></i>
                                                Saldo</h2>
                                        </div>
                                        <h2>Rp. {{ number_format($wallet->saldo, 0, ',', '.') }},00</h2>
                                    </div>
                                    <div class="float-right">
                                        <button type="button" class="btn btn-light my-3 mr-3 float-right"
                                            data-toggle="modal" data-target="#topupModal"><i class="ti-plus"></i> Top
                                            Up</button>

                                        <button type="button" class="btn btn-light my-3 mr-3 float-right"
                                            data-toggle="modal" data-target="#tariktunaiModal"><i class="ti-archive"></i>
                                            Tarik
                                            Tunai</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 mt-5 mb-3">
                            <div class="card">
                                <div class="seo-fact sbg3" style="min-height: 13.5em">
                                    <div class="p-4 d-flex justify-content-between align-items-center mb-3">
                                        <div class="seofct-icon">
                                            <h2><i class="ti-upload"></i>
                                                Pengeluaran</h2>
                                        </div>
                                    </div>
                                    <div class="ml-4 mt-4 center">
                                        <h2>Rp. {{ number_format($pengeluaran, 2, ',', '.') }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 mb-3 mb-lg-0">
                            <div class="card">
                                <div class="seo-fact sbg1">
                                    <div class="p-4 d-flex justify-content-between align-items-center">
                                        <div class="seofct-icon">Rekening</div>
                                        <h2>
                                            {{ implode(' ', str_split(str_replace(',', '', $wallet->rekening), 4)) }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content area end -->

    <div class="modal fade" id="topupModal" tabindex="-1" role="dialog" aria-labelledby="topupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="topupModalLabel">Top Up</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('topup.request') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rekening">Rekening</label>
                            <input id="rekening" name="rekening" type="text" placeholder="" class="form-control"
                                required value="{{ $wallet->rekening }}">
                        </div>

                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="text" id="nominal" class="form-control" placeholder="" name="nominal"
                                required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Top Up</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tariktunaiModal" tabindex="-1" role="dialog" aria-labelledby="tariktunaiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tariktunaiModalLabel">Tarik Tunai</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('withdrawal.request') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input id="rekening" name="rekening" type="hidden" placeholder="" class="form-control"
                                required value="{{ $wallet->rekening }}">
                        </div>

                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="text" id="nominal" class="form-control" placeholder="" name="nominal"
                                required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tarik Tunai</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
