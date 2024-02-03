<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $title }} - Academunch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/icon/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css"
        media="all" />

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/js/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/js/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />


    <!-- others css -->
    <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/default-css.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <!-- modernizr css -->
    <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>
    @if (session('success'))
        <link rel="stylesheet" href="{{ asset('assets/js/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" />

        <script src="{{ asset('assets/js/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });

            Toast.fire({
                icon: "success",
                title: "{{ session('success') }}",
            });
        </script>
    @endif

    @if (session('error'))
        <link rel="stylesheet" href="{{ asset('assets/js/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" />

        <script src="{{ asset('assets/js/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });

            Toast.fire({
                icon: "error",
                title: "{{ session('error') }}",
            });
        </script>
    @endif

    <!-- page container area start -->
    <div class="page-container">
        @php
            $role = auth()->user()->role;
        @endphp
        @if ($role === 'admin')
            @include('partials.sidebar_admin')
        @elseif ($role === 'bank')
            @include('partials.sidebar_bank')
        @elseif ($role === 'kantin')
            @include('partials.sidebar_kantin')
        @elseif ($role === 'siswa')
            @include('partials.sidebar_siswa')
        @endif
        @yield('content')

        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright {{ now()->format('Y') }}. All right reserved. Made by <a
                        href="https://instagram.com/rabbzp_">Rafly Rabbany Z.P.</a>
                </p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->


    <!-- jquery latest version -->
    <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <!-- bootstrap 4 js -->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
        zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
        ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="{{ asset('assets/js/line-chart.js') }}"></script>
    <!-- all bar chart activation -->
    <script src="{{ asset('assets/js/bar-chart.js') }}"></script>
    <!-- all pie chart -->
    <script src="{{ asset('assets/js/pie-chart.js') }}"></script>
    <!-- others plugins -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

    <script>
        $(function() {
            $("#table1")
                .DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                })
                .buttons()
                .container()
                .appendTo("#table1_wrapper .col-md-6:eq(0)");
            $("#table2").DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                responsive: true,
            });
        });
    </script>
</body>

</html>
