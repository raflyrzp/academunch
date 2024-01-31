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

        <div class="main-content-inner">
            <div class="row">
                <div class="col-lg-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="invoice-area">
                                <div class="invoice-head">
                                    <div class="row">
                                        <div class="iv-left col-6">
                                            <span>ACADEMUNCH</span>
                                        </div>
                                        <div class="iv-right col-6 text-md-right">
                                            <span>{{ $invoice }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="invoice-address">
                                            <h3>Invoice</h3>
                                            <h5>{{ auth()->user()->nama }}</h5>
                                            <p>{{ auth()->user()->email }}</p>
                                            <p>Status :
                                                {{ $selectedProducts->first()->status !== null ? strtoupper($selectedProducts->first()->status) : 'DIPESAN' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <ul class="invoice-date">
                                            <li>Tanggal : {{ now()->format('d F Y') }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="invoice-table table-responsive mt-5">
                                    <table class="table table-bordered table-hover text-right">
                                        <thead>
                                            <tr class="text-capitalize">
                                                <th scope="col">Produk</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Total Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($selectedProducts as $selectedProduct)
                                                <tr>
                                                    <td style="vertical-align: middle;">
                                                        {{ $selectedProduct->produk->nama_produk }}</td>
                                                    <td style="vertical-align: middle;">
                                                        Rp.{{ number_format($selectedProduct->produk->harga, 0, ',', '.') }},00
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        @if ($selectedProduct->jumlah_produk !== null)
                                                            {{ $selectedProduct->jumlah_produk }}
                                                        @else
                                                            {{ $selectedProduct->kuantitas }}
                                                        @endif
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        Rp.{{ number_format($selectedProduct->total_harga, 0, ',', '.') }},00
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">Total Seluruh Harga :</td>
                                                <td>Rp.{{ number_format($totalHarga, 0, ',', '.') }},00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="invoice-buttons">
                                <div class="float-left">
                                    <a href="javascript:history.back()">Kembali</a>

                                </div>
                                <div class="float-right">
                                    @if ($selectedProducts->first()->status === 'dipesan')
                                        <form action="{{ route('batal.transaksi', $invoice) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <a href="" class="invoice-btn bg-danger">
                                                <button type="submit"
                                                    class="border-0 bg-transparent text-white font-weight-bold">Batal
                                                </button></a>
                                        </form>
                                    @endif
                                    <a href="#" class="invoice-btn" id="printInvoiceBtn">Cetak Invoice</a>
                                </div>
                            </div>
                        </div>
                        @if ($selectedProducts->first()->status === null)
                            <p class="ml-4 mb-3">Silahkan pergi ke halaman Riwayat Transaksi jika ingin membatalkan
                                transaksi</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content area end -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var printBtn = document.getElementById('printInvoiceBtn');

            printBtn.addEventListener('click', function() {
                window.location.href = '{{ route('cetak.transaksi') }}';
            });
        });
    </script>
@endsection
