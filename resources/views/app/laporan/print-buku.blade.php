<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Cetak Laporan &mdash; {{ config('app.name') }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            .header {
                margin: 0 0 2em 0;
                text-align: center;
                text-transform: uppercase;
            }

            .header h3 {
                margin: 0;
            }

            .table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            .table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: center;
                background-color: #b6b6b6;
                text-transform: uppercase;
            }

            .table td, .table th {
                border: 1px solid black;
                padding: 8px;
            }
        </style>
    </head>

    <body>
        <div>
            <div class="header">
                <h3><b>Laporan Buku Perpustakaan</b></h3>
                <h3><b>SMAN 1 Bagan Sinembah</b></h3>
                <h3><b>Kategori {{ $kategori->kategori }}</b></h3>
            </div>

            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buku as $index => $item)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->pengarang }}</td>
                            <td>{{ $item->penerbit }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td>{{ $item->stok }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
