<?php

namespace Modules\Dormitory\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Dormitory\Entities\StudentDormitory;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StudentDormDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

        ->editColumn('user_id', function ($model) {
            return $model->student?->name;
        })

        ->editColumn('dormitories_id', function ($model) {
            return $model->dorm?->dormitory_name;
        })

        ->editColumn('room_id', function ($model) {
            return $model->room?->room_number;
        })


        ->addColumn('action', function ($query) {
            return '<a href="#" class="btn btn-primary-soft btn-sm me-1" onclick="showEditModal('.$query->id.')" title="Edit"><i class="fa fa-edit"></i></a>'.
                '<a href="#" class="btn btn-danger-soft btn-sm" onclick="delete_modal(\''.route(config('theme.rprefix').'.destroy', $query->id).'\',\'student-dorm-table\')"  title="Delete"><i class="fa fa-trash"></i></a>';
        })
        ->setRowId('id')
        ->rawColumns(['action'])
        ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     */
    public function query(StudentDormitory $model): QueryBuilder
    {
        
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('student-dorm-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>")
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
            ])
            ->buttons([
                Button::make('reset')->className('btn btn-success box-shadow--4dp btn-sm-menu'),
                Button::make('reload')->className('btn btn-success box-shadow--4dp btn-sm-menu'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(__('SI'))->searchable(false)->orderable(false)->width(30)->addClass('text-center'),
            Column::make('user_id')->title(__('Student Name'))->defaultContent('N/A'),
            Column::make('dormitories_id')->title(__('Dormitory Name'))->defaultContent('N/A'),
            Column::make('room_id')->title(__('Room No'))->defaultContent('N/A'),
        
            Column::computed('action')
                ->title(__('Action'))
                ->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Dormitories_'.date('YmdHis');
    }
}
