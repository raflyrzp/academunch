<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Invoice</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>

<body>
    <div class="">
        <div class="card-body m-5">
            <div class="mt-3">
                <div class="row d-flex align-items-baseline">
                    <div class="col-xl-9">
                        <p style="color: #7e8d9f; font-size: 20px">Academunch</p>
                    </div>
                </div>

                <div class="border-top">
                    <div class="col-md-12 pt-3">
                        <div class="text-center">
                            <i class="fab fa-mdb fa-4x ms-0" style="color: #5d9fc5"></i>
                            <h4 class="pt-0">Invoice</h4>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-xl-8">
                            <ul class="list-unstyled">
                                <li class="text-muted">
                                    Nama : {{ $pembeli }}
                                </li>
                                <li class="text-muted">{{ now()->format('d F Y') }}</li>
                                <li class="text-muted">{{ $invoice }}</li>
                                <li class="text-muted">Status : {{ strtoupper($status) }}
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="row my-2 mx-1 justify-content-center">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selectedProducts as $i => $selectedProduct)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td style="vertical-align: middle;">
                                            {{ $selectedProduct['nama_produk'] }}</td>
                                        <td style="vertical-align: middle;">
                                            Rp.{{ number_format($selectedProduct['produk']->harga, 0, ',', '.') }},00
                                        </td>
                                        <td style="vertical-align: middle;">
                                            {{ $selectedProduct['kuantitas'] }}
                                        </td>
                                        <td style="vertical-align: middle;">
                                            Rp.{{ number_format($selectedProduct['total_harga'], 0, ',', '.') }},00
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="">
                                    <td class="text-end" colspan="4">TOTAL SELURUH HARGA :</td>
                                    <td>Rp.{{ number_format($totalHarga, 0, ',', '.') }},00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <hr class="mt-5" />
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>Terimakasih telah berbelanja di Academunch :)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.print();

            window.addEventListener('afterprint', function() {

                window.location.href = '{{ route(auth()->user()->role . '.index') }}';
            });

        });
    </script>

</body>

</html>
