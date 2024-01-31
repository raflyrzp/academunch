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
            <!-- sales report area start -->
            <div class="sales-report-area sales-style-two">
                <div class="row">
                    <!-- data table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Tabel Produk</h4>
                                <button type="button" class="btn btn-sm btn-primary mb-1" data-toggle="modal"
                                    data-target="#tambahModal"><i class="ti-plus"></i> Tambah</button>
                                <div class="data-tables">
                                    <table id="table1" class="table table-bordered table-hover">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>No.</th>
                                                <th>Produk</th>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                                <th>Stok</th>
                                                <th>Kategori</th>
                                                <th>Desc</th>
                                                <th>Aksi</th>
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
                                                    <td> <button type="button" class="btn btn-sm btn-primary mb-1"
                                                            data-toggle="modal"
                                                            data-target="#editModal{{ $produk->id }}"><i
                                                                class="ti-pencil"></i></button>

                                                        <button type="button" class="btn btn-sm btn-danger mb-1"
                                                            data-toggle="modal"
                                                            data-target="#deleteModal{{ $produk->id }}"><i
                                                                class="ti-trash"></i></button>
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

    @foreach ($produks as $produk)
        <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="tambahModalLabel">Tambah Produk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('produk.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_produk">Nama Produk</label>
                                <input id="nama_produk" name="nama_produk" type="text" placeholder=""
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input id="harga" name="harga" type="text" placeholder="" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input id="stok" name="stok" type="number" placeholder="" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="id_kategori">
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="desc">Desc</label>
                                <textarea class="form-control" name="desc" id="desc" cols="30" rows="10" required></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto" name="foto">
                                    <label class="custom-file-label" for="foto">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal{{ $produk->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel{{ $produk->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="editModalLabel{{ $produk->id }}">Edit Produk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('produk.update', $produk->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_produk">Nama Produk</label>
                                <input id="nama_produk" name="nama_produk" type="text" placeholder=""
                                    class="form-control" value="{{ $produk->nama_produk }}" required>
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input id="harga" name="harga" type="text" placeholder="" class="form-control"
                                    value="{{ $produk->harga }}" required>
                            </div>
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input id="stok" name="stok" type="number" placeholder="" class="form-control"
                                    value="{{ $produk->stok }}" required>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="id_kategori">
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}"
                                            @if ($produk->id_kategori == $kategori->id) selected @endif>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="desc">Desc</label>
                                <textarea class="form-control" name="desc" id="desc" cols="30" rows="10" required>{{ $produk->desc }}</textarea>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto" name="foto">
                                    <label class="custom-file-label" for="foto">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal{{ $produk->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $produk->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Hapus Produk
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Apakah anda yakin ingin menghapus produk ini?
                        </p>
                        <p>
                            Nama Produk : {{ $produk->nama_produk }}
                        </p>
                        <p>
                            Harga : {{ $produk->harga }}
                        </p>
                        <p>
                            Stok : {{ $produk->stok }}
                        </p>
                        <p>
                            kategori : {{ $produk->kategori->nama_kategori }}
                        </p>
                        <p>
                            desc : {{ $produk->desc }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>

                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger ms-1">
                                Hapus
                            </button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
