<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tarik Tunai</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>

<body>
    <!-- laporan -->
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Laporan Tarik Tunai</h4>
                <div class="list-group list-group-flush">
                    @foreach ($withdrawals as $withdrawal)
                        <h6 class="bg-body-tertiary p-2 border-top border-bottom">
                            {{ $withdrawal->tanggal }}
                            <span class="float-right text-danger">- Rp.
                                {{ number_format($withdrawal->nominal, 2, ',', '.') }}</span>
                        </h6>
                        @php
                            if (auth()->user()->role === 'siswa') {
                                $withdrawalList = App\Models\Withdrawal::where(DB::raw('DATE(created_at)'), $withdrawal->tanggal)
                                    ->where('rekening', $wallet->rekening)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                            } else {
                                $withdrawalList = App\Models\Withdrawal::where(DB::raw('DATE(created_at)'), $withdrawal->tanggal)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                            }
                        @endphp

                        <ul class="list-group list-group-light mb-4">
                            @foreach ($withdrawalList as $list)
                                <li
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center col-12">
                                        <div class="ms-3 col-12">
                                            <p class="fw-bold mb-1">{{ $list->kode_unik }} <span
                                                    class="float-right">{{ $list->created_at }}</span>
                                            </p>
                                            <p class="text-muted mb-0">
                                                {{ $list->wallet->user->nama . ' (' . $list->wallet->rekening . ')' }}
                                            </p>
                                            <p class="text-danger mb-0">- Rp.
                                                {{ number_format($list->nominal, 2, ',', '.') }}
                                            </p>
                                            @if ($list->status == 'menunggu')
                                                <span class="text-info">
                                                    {{ strtoupper($list->status) }}
                                                </span>
                                            @elseif($list->status == 'dikonfirmasi')
                                                <span class="text-success">
                                                    {{ strtoupper($list->status) }}
                                                </span>
                                            @else
                                                <span class="text-danger">
                                                    {{ strtoupper($list->status) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- laporan -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.print();

            window.addEventListener('afterprint', function() {

                window.location.href = '{{ url()->previous() }}';
            });

        });
    </script>
</body>

</html>
