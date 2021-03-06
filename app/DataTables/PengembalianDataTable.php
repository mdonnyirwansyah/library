<?php

namespace App\DataTables;

use App\Models\Pengembalian;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PengembalianDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('nis', function ($data) {
                return $data->peminjaman->anggota->nis;
            })
            ->addColumn('anggota', function ($data) {
                return $data->peminjaman->anggota->nama;
            })
            ->addColumn('jenis_kelamin', function ($data) {
                return $data->peminjaman->anggota->jenis_kelamin;
            })
            ->addColumn('kelas', function ($data) {
                return $data->peminjaman->anggota->kelas->kelas;
            })
            ->addColumn('sudah', function ($data) {
                $filter = $data->buku->filter(function ($item) {
                    return $item->pivot->status == 1;
                });

                if (count($filter) > 0) {
                    return $filter->implode('judul', ', ');
                } else {
                    return '-';
                }
            })
            ->addColumn('belum', function ($data) {
                $filter = $data->buku->filter(function ($item) {
                    return $item->pivot->status == 0;
                });

                if (count($filter) > 0) {
                    return $filter->implode('judul', ', ');
                } else {
                    return '-';
                }
            })
            ->addColumn('action', function ($data) {
                return '
                    <a data-toggle="tooltip" data-placement="top" title="Edit" href="'.route('pengembalian.edit', $data).'" class="btn btn-icon">
                        <i class="fas fa-pen text-info"></i>
                    </a>
                    <button data-toggle="tooltip" data-placement="top" title="Hapus" onClick="deleteRecord('.$data->id.')" id="delete-'.$data->id.'" delete-route="'.route('pengembalian.destroy', $data).'" class="btn btn-icon">
                        <i class="fas fa-trash text-danger"></i>
                    </button>
                ';
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d');
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Pengembalian $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Pengembalian $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('pengembalian-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy([1, 'ASC']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->searchable(false)->title('No')->width(50),
            Column::make('kode'),
            Column::make('created_at')->title('Tanggal'),
            Column::computed('nis')->title('NIS'),
            Column::computed('anggota')->title('Nama'),
            Column::computed('jenis_kelamin'),
            Column::computed('kelas'),
            Column::computed('sudah'),
            Column::computed('belum'),
            Column::computed('action')->title('Aksi')->width(85),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Pengembalian_' . date('YmdHis');
    }
}
