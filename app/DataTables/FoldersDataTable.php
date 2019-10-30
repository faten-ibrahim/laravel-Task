<?php

namespace App\DataTables;

use App\Folder;
use Yajra\DataTables\DataTables as YajraDataTables;
use Yajra\DataTables\Services\DataTable;

class FoldersDataTable extends DataTable
{

    // public function ajax()
    // {

    //     return $this->datatables
    //         ->eloquent($this->query())
    //         ->make(true);
    // }

    public function dataTable($query)
    {
        return datatables($query)->setRowId('id');
    }



    // public function html()
    // {
    //     return $this->builder()
    //         ->columns($this->getColumns())
    //         ->ajax('')
    //         ->parameters([
    //             'dom'          => 'Bfrtip',
    //             'buttons'      => ['export', 'reload'],
    //         ]);
    // }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom'          => 'Bfrtip',
            ]);
    }

    public function query()
    {
        return Folder::all();
        // return $this->applyScopes($folders);
    }

    // public function query(Folder $model)
    // {
    //     return $model->newQuery()->select('id', 'name', 'email');
    // }

    protected function getColumns()
    {
        return [
            'id',
            'folderName',
            'description',
            'created_at',
            'action',
        ];
    }

    protected function filename()
    {
        return 'folders_' . time();
    }
}
