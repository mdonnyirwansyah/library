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
                <h3><b>Laporan Pengembalian Buku SMAN 1 Bagan Sinembah</b></h3>
                <h3><b>Tahun Pelajaran {{ $tahun_pelajaran->tahun }}</b></h3>
                <h3><b>Kelas {{ $kelas->kelas }}</b></h3>
            </div>

            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th width="6%">Kode</th>
                            <th width="10%">Tanggal</th>
                            <th width="10%">NIS</th>
                            <th width="23%">Nama</th>
                            <th width="3%">L/P</th>
                            <th>Sudah</th>
                            <th>Belum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengembalian as $index => $item)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                            <td>{{ $item->peminjaman->anggota->nis }}</td>
                            <td>{{ $item->peminjaman->anggota->nama }}</td>
                            <td>{{ Str::substr($item->peminjaman->anggota->jenis_kelamin, 0, 1) }}</td>
                            <td>
                                <?php
                                    $filter = $item->buku->filter(function ($buku) {
                                        return $buku->pivot->status == 1;
                                    });

                                    if (count($filter) > 0) {
                                        $sudah = $filter->implode('judul', ', ');
                                        echo $sudah;
                                    } else {
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $filter = $item->buku->filter(function ($buku) {
                                        return $buku->pivot->status == 0;
                                    });

                                    if (count($filter) > 0) {
                                        $belum = $filter->implode('judul', ', ');
                                        echo $belum;
                                    } else {
                                        echo '-';
                                    }
                                ?>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
