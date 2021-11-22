<?php

namespace App\DataTables;

use App\Models\Peminjaman;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
class PeminjamanDataTable extends DataTable
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
                return $data->anggota->nis;
            })
            ->addColumn('tahun', function ($data) {
                return $data->tahun_pelajaran->tahun;
            })
            ->addColumn('anggota', function ($data) {
                return $data->anggota->nama;
            })
            ->addColumn('jenis_kelamin', function ($data) {
                return $data->anggota->jenis_kelamin;
            })
            ->addColumn('kelas', function ($data) {
                return $data->anggota->kelas->kelas;
            })
            ->addColumn('buku', function ($data) {
                return $data->buku->implode('judul', ', ');
            })
            ->addColumn('action', function ($data) {
                $id = strtotime($data->created_at);

                return '
                    <a data-toggle="tooltip" data-placement="top" title="Edit" href="'.route('peminjaman.edit', $data).'" class="btn btn-icon">
                        <i class="fas fa-pen text-info"></i>
                    </a>
                    <button data-toggle="tooltip" data-placement="top" title="Hapus" onClick="deleteRecord('.$id.')" id="delete-'.$id.'" delete-route="'.route('peminjaman.destroy', $data).'" class="btn btn-icon">
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
     * @param \App\Models\Peminjaman $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Peminjaman $model)
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
                    ->setTableId('peminjaman-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy([1, 'DESC']);
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
            Column::computed('tahun')->title('Tahun Pelajaran'),
            Column::make('created_at')->title('Tanggal'),
            Column::make('id')->title('ID'),
            Column::computed('nis')->title('NIS'),
            Column::computed('anggota')->title('Nama'),
            Column::computed('jenis_kelamin'),
            Column::computed('kelas'),
            Column::computed('buku'),
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
        return 'Peminjaman_' . date('YmdHis');
    }
}
