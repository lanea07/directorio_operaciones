<?php

namespace App\DataTables;

use App\Models\Directorio;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class DirectorioDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', '')
            ->addColumn('nombre', function(Directorio $directorio){
                return '<a href="'.route('directorios.show', $directorio->id).'" class="link-primary">'.$directorio->nombre.'</a>';
            })
            ->addColumn('correo', function(Directorio $directorio){
                return '<a href="mailto:'.$directorio->correo.'" class="link-primary">'.$directorio->correo.'</a>';
            })
            ->addColumn('Acciones', function(Directorio $directorio){
                return
                    Auth::check() && auth()->user()->hasRoles(['administrador']) ?
                    '<div class="btn-group d-none">'.
                        '<a class="btn btn-outline-primary btn-sm" href="'.route('directorios.edit', $directorio->id).'">Editar</a>'.
                        '<a class="btn btn-outline-warning btn-sm" href="'.route('issues.create', ['directorio_id' => $directorio->id]).'">Reportar Novedad</a>'.
                        '<a class="btn btn-outline-danger btn-sm" href="#" onclick="document.getElementById(\'delete-user-'.$directorio->id.'\').submit()">Eliminar</a>'.
                    '</div>'.
                    '<form class="d-none" id="delete-user-'.$directorio->id.'" action="'.route('directorios.destroy', $directorio->id).'" method="post">'.
                        method_field('delete').
                        csrf_field().
                    '</form>' :
                    '<div class="btn-group d-none">'.
                        '<a class="btn btn-outline-warning btn-sm" href="'.route('issues.create', ['directorio_id' => $directorio->id]).'">Reportar Novedad</a>'.
                    '</div>'
                    ;
            })
            ->filter(function($query){
                $request = request()->query('search');
                if ($request['value']) {
                    $query
                    ->orWhere('nombre', 'like', "%" . $request['value'] . "%")
                    ->orWhere('usuario_de_red', 'like', "%" . $request['value'] . "%")
                    ->orWhereHas('area', function ($query) use ($request){
                        $query->where('areas.nombre', 'LIKE', "%" . $request['value'] . "%");
                    })
                    ->orWhereHas('dependencia', function ($query) use ($request){
                        $query->where('dependencias.nombre', 'LIKE', "%" . $request['value'] . "%");
                    });
                };
            })
            ->rawColumns(['nombre','correo','Acciones']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Directorio $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Directorio $model)
    {
        return $model
            ->with(['dependencia','area'])
            ->select('directorios.*')
            ->newQuery()
            ->orderBy('nombre', 'asc')
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
                    ->setTableId('directorio-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('lfrtip')
                    ->orderBy(1, 'asc')
                    ->parameters([
                        'drawCallback' => "function() {
                            $('#directorio-table > tbody > tr').hover(
                                function(){
                                    $(this).find('div.btn-group').removeClass('d-none');
                                },
                                function(){
                                    $(this).find('div.btn-group').addClass('d-none');
                                }
                            );
                        }",
                    ])
                    // ->buttons(
                    //     Button::make('create'),
                    //     Button::make('export'),
                    //     Button::make('print'),
                    //     Button::make('reset'),
                    //     Button::make('reload')
                    // );
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
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('dt-control'),
            Column::make('nombre'),
            Column::make('usuario_de_red'),
            Column::make('correo'),
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
        return 'Directorio_' . date('YmdHis');
    }
}
