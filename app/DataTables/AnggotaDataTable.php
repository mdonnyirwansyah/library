<?php

namespace App\DataTables;

use App\Models\Anggota;
use App\Models\Kelas;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AnggotaDataTable extends DataTable
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
            ->addColumn('kelas', function ($data) {
                if ($data->kelas_id) {
                    return $data->kelas->kelas;
                } else {
                    return '-';
                }
            })
            ->addColumn('action', function ($data) {
                return '
                    <a data-toggle="tooltip" data-placement="top" title="Edit" href="'.route('anggota.edit', $data).'" class="btn btn-icon">
                        <i class="fas fa-pen text-info"></i>
                    </a>
                    <button data-toggle="tooltip" data-placement="top" title="Hapus" onClick="deleteRecord('.$data->id.')" id="delete-'.$data->id.'" delete-route="'.route('anggota.destroy', $data).'" class="btn btn-icon">
                        <i class="fas fa-trash text-danger"></i>
                    </button>
                ';
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Anggota $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Anggota $model)
    {
        return $model->with('kelas')->orderBy(Kelas::select('kelas')->whereColumn('kelas.id', 'anggota.kelas_id'));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('anggota-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy([2, 'ASC']);
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
            Column::make('nis')->title('NIS'),
            Column::make('nama'),
            Column::make('jenis_kelamin'),
            Column::computed('kelas'),
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
        return 'Anggota_' . date('YmdHis');
    }
}
