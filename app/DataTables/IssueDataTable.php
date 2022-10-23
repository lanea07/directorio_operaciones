<?php

namespace App\DataTables;

use App\Models\Issue;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class IssueDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('Contacto', function (Issue $issue){
                return '<a href="'.route('issues.show', $issue->id).'" class="link-primary">'.$issue->directorio->nombre.'</a>';
                return
                Auth::check() && auth()->user()->hasRoles(['administrador']) ?
                '<div class="d-flex">'.
                    '<a href="'.route('issues.show', $issue->id).'" class="link-primary me-auto">'.$issue->directorio->nombre.'</a>'.
                    '<div>'.
                        '<a class="mx-1 link-primary" href="'.route('issues.edit', $issue->id).'" title="Ir y Corregir"><i class="fa-solid fa-pen "></i></a>'.
                        '<a class="mx-1 link-danger" href="#" onclick="document.getElementById(\'delete-issue-'.$issue->id.'\').submit()"  title="Descartar"><i class="fa-solid fa-trash-can "></i></a>'.
                    '</div>'.
                '</div>'.
                '<form class="d-none" id="delete-issue-'.$issue->id.'" action="'.route('issues.destroy', $issue->id).'" method="post">'.
                    method_field('delete').
                    csrf_field().
                '</form>'  :
                '<div class="d-flex">'.
                    '<a href="'.route('issues.show', $issue->id).'" class="link-primary">'.$issue->directorio->nombre.'</a>'.
                    '<div>'.
                        '<a class="mx-1 link-warning" href="'.route('issues.create', ['issue_id' => $issue->id]).'"><i class="fa-solid fa-file-circle-plus "></i></a>'.
                    '</div>'.
                '</div>'
                ;
            })
            ->addColumn('created_at', function(Issue $issue){
                return $issue->created_at->diffForHumans();
            })
            ->addColumn('ip', function(Issue $issue){
                return 'Reportado desde la ip '.$issue->ip_issue_sender;
            })
            ->addColumn('valid_id', function(Issue $issue){
                return $issue->valid_id ?
                        'Pendiente' :
                        'Solucionado'
                        ;
            })
            ->rawColumns(['Contacto', 'Acciones']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Issue $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Issue $model): QueryBuilder
    {
        return request('valid_0') ?
            $model
                ->newQuery()
                ->orderBy('created_at', 'asc') :
            $model
                ->where('valid_id', 1)
                ->newQuery()
                ->orderBy('created_at', 'asc')
                ;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('issuedatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('
                        <"d-flex"
                            <"mx-2"B>
                            <"m-2"l>
                            <"toggler m-2">
                            <"m-2 ms-auto"f>
                        >
                        <tr>
                        <"d-flex"
                            <"mx-2"i>
                            <"mx-2 ms-auto"p>
                        >'
                    )
                    ->orderBy(1)
                    ->parameters([
                        'responsive' => true,
                        'buttons' => [
                            [
                                'extend' => 'excelHtml5',
                                'className' => 'btn btn-sm btn-success m-2',
                                'text' => '<i class="fas fa-file-excel fa-lg"></i><span class="ml-2">A Excel</span>',
                            ]
                        ],
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('Contacto'),
            Column::make('ip'),
            Column::make('created_at'),
            Column::make('valid_id'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Issue_' . date('YmdHis');
    }
}
