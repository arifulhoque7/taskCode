<?php

namespace Modules\Post\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Modules\Post\Entities\Post;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PostDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($row) {

                $status = '';

                if ($row->status == 1) {
                    $status .= '<span class="badge badge-success-soft sale-badge-ft-13">Active</span>';
                } else {
                    $status .= '<span class="badge badge-danger-soft sale-badge-ft-13">Deactive</span>';
                }

                return $status;
            })
            ->editColumn('user_id', function ($row) {

                return $row?->user?->name ?? 'N/A';
            })
            ->editColumn('is_published', function ($query) {
                return $this->statusBtn($query);
            })
            ->addColumn('action', function ($query) {
                $action = '';

                if ($query->user_id == Auth::id()) {
                    $action .= '<a href="#" class="btn btn-primary-soft btn-sm me-1" onclick="showEditModal(' . $query->id . ')" title="Edit"><i class="fa fa-edit"></i></a>';
                    $action .= '<a href="#" class="btn btn-danger-soft btn-sm" onclick="delete_modal(\'' . route(config('theme.rprefix') . '.destroy', $query->id) . '\',\'post-table\')"  title="Delete"><i class="fa fa-trash"></i></a>';
                }

                return $action;
            })
            ->setRowId('id')
            ->rawColumns(['status', 'action', 'is_published'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Post $model): QueryBuilder
    {
        return $model->newQuery()
        ->when(\auth()->user()->id, function ($q) {
            if(\auth()->user()->hasRole('Administrator')){
                return $q;
            }else{
                return $q->where('user_id', \auth()->user()->id);
            }
        });
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('post-table')
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
            Column::make('title')->title(__('Title'))->defaultContent('N/A'),
            Column::make('description')->title(__('Description'))->defaultContent('N/A'),
            Column::make('user_id')->title(__('Posted By'))->defaultContent('N/A'),
            Column::make('publish_time')->title(__('Publish Time'))->defaultContent('N/A'),
            Column::make('is_published')->title(__('Published'))->defaultContent('N/A'),
            Column::make('status')->title(__('Status'))->defaultContent('N/A'),
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
        return 'Post_' . date('YmdHis');
    }
    private function statusBtn($post): string
    {

        $status = '<select class="form-control select-basic-single" name="is_published" ';
        $status .= ($post->isFreeMembership()? 'disabled' : '').' onchange="publishStatusUpdate(this,\'' . route(config('theme.rprefix') . '.publish-status-update', [$post->id, $post->status]) . '\',\'#post-table\')" >';
        foreach (Post::publishStatusList() as $key => $value) {
            $status .= "<option value='$key' " . selected($key, $post->is_published) . ">$value</option>";
        }
        $status .= '</select>';

        return $status;
    }
}
