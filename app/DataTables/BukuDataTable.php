<?php

namespace App\DataTables;

use App\Models\Buku;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BukuDataTable extends DataTable
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
            ->addColumn('kategori', function ($data) {
                if ($data->kategori_id) {
                    return $data->kategori->kategori;
                } else {
                    return '-';
                }
            })
            ->addColumn('action', function ($data) {
                return '
                    <a data-toggle="tooltip" data-placement="top" title="Edit" href="'.route('buku.edit', $data).'" class="btn btn-icon">
                        <i class="fas fa-pen text-info"></i>
                    </a>
                    <button data-toggle="tooltip" data-placement="top" title="Hapus" onClick="deleteRecord('.$data->id.')" id="delete-'.$data->id.'" delete-route="'.route('buku.destroy', $data).'" class="btn btn-icon">
                        <i class="fas fa-trash text-danger"></i>
                    </button>
                ';
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Buku $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Buku $model)
    {
        return $model->orderBy('kategori_id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('buku-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy([3, 'ASC']);
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
            Column::make('judul'),
            Column::computed('kategori'),
            Column::make('pengarang'),
            Column::make('penerbit'),
            Column::make('tahun'),
            Column::make('stok'),
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
        return 'Buku_' . date('YmdHis');
    }
}
