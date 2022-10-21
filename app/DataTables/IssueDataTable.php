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
            })
            ->addColumn('ip', function(Issue $issue){
                return 'Reportado desde la ip '.$issue->ip_issue_sender;
            })
            ->addColumn('Acciones', function(Issue $issue){
                return
                    Auth::check() && auth()->user()->hasRoles(['administrador']) ?
                    '<div class="btn-group d-none">'.
                        '<a class="btn btn-primary btn-sm" href="'.route('directorios.edit', $issue->directorio->id).'">Ir y Corregir</a>'.
                        '<a class="btn btn-outline-danger btn-sm" href="#" onclick="document.getElementById(\'delete-user-'.$issue->id.'\').submit()">Descartar</a>'.
                    '</div>'.
                    '<form class="d-none" id="delete-user-'.$issue->id.'" action="'.route('issues.destroy', $issue->id).'" method="post">'.
                        method_field('delete').
                        csrf_field().
                    '</form>' :
                    '<div class="btn-group d-none">'.
                        '<a class="btn btn-success btn-sm" href="'.route('login').'">Iniciar Sesión</a>'.
                    '</div>'
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
        return $model->newQuery();
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
                    ->dom('lfrtip')
                    ->orderBy(1)
                    ->parameters([
                        'initComplete' => "function() {
                            $('#issuedatatable-table > tbody > tr').hover(
                                function(){
                                    $(this).find('div.btn-group').removeClass('d-none');
                                },
                                function(){
                                    $(this).find('div.btn-group').addClass('d-none');
                                }
                            );
                        }",
                    ])
    //                 ->buttons(
    //                     Button::make('create'),
    //                     Button::make('export'),
    //                     Button::make('print'),
    //                     Button::make('reset'),
    //                     Button::make('reload')
    //                 );
                        ;
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
            Column::make('Acciones'),
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
