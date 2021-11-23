<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Cetak Laporan &mdash; {{ config('app.name') }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="{{ public_path('css/app.css') }}">
        <style type="text/css" media="all">
            .header-laporan {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            table, thead, tr, th {
                border: none;
            }
            .logo-1 {
                width: 70px;
                object-fit: fill;
            }
            .logo-2 {
                width: 130px;
                object-fit: fill;
            }
            .logo-3 {
                width: 150px;
                object-fit: fill;
            }
            .wrapper-left {
                width: 12%;
                display: flex;
                justify-content: flex-start;
                align-items: center;
            }
            .wrapper-center {
                width: 58%;
            }
            .wrapper-center h4 {
                font-weight: bold;
            }
            .wrapper-center p {
                font-weight: lighter;
            }
            .wrapper-right-1 {
                width: 15%;
                display: flex;
                justify-content: flex-end;
                align-items: center;
            }
            .wrapper-right-2 {
                width: 15%;
                display: flex;
                justify-content: flex-end;
                align-items: center;
            }
            hr {
                color: black;
                border: 1px solid black;
            }
            h5 {
                font-weight: bold;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <h5 class="text-center text-dark">Laporan Anggota Perpustakaan</h5>
            <h6 class="text-center text-dark mb-5">Kelas</h6>
            <div class="table-responsive">
                <table class="table table-bordered" style="width: 100%">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Kelas</th>
                          </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
