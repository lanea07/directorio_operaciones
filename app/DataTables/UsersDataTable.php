<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('Usuario', function(User $user){
                return
                    Auth::check() && auth()->user()->hasRoles(['administrador']) ?
                    '<div class="d-flex">'.
                        '<a href="'.route('users.show', $user->id).'" class="link-primary me-auto">'.$user->name.'</a>'.
                        '<div>'.
                            '<a class="mx-1" href="'.route('users.edit', $user->id).'" title="Editar"><i class="fa-solid fa-pen text-primary"></i></a>'.
                            '<a class="mx-1" href="'.route('issues.create', ['user_id' => $user->id]).'"  title="Reportar Novedad"><i class="fa-solid fa-file-circle-plus text-warning"></i></a>'.
                            '<a class="mx-1" href="#" onclick="document.getElementById(\'delete-user-'.$user->id.'\').submit()"  title="Eliminar"><i class="fa-solid fa-trash-can text-danger"></i></a>'.
                        '</div>'.
                    '</div>'.
                    '<form class="d-none" id="delete-user-'.$user->id.'" action="'.route('users.destroy', $user->id).'" method="post">'.
                        method_field('delete').
                        csrf_field().
                    '</form>'  :
                    '<div class="d-flex">'.
                        '<a href="'.route('users.show', $user->id).'" class="link-primary me-auto">'.$user->name.'</a>'.
                        '<div>'.
                            '<a class="mx-1" href="'.route('issues.create', ['user_id' => $user->id]).'"><i class="fa-solid fa-file-circle-plus text-warning"></i></a>'.
                        '</div>'.
                    '</div>'
                    ;
            })
            ->addColumn('email', function(User $user){
                return '<a href=mailto:'.$user->email.' class="link-primary">'.$user->email.'</a>';
            })
            ->addColumn('Permisos', function(User $user){
                return mb_convert_case($user->roles->pluck('name')->implode(' - '), MB_CASE_TITLE);
            })
            ->addColumn('created_at', function(User $user){
                return $user->created_at->diffForHumans();
            })
            ->addColumn('updated_at', function(User $user){
                return $user->updated_at->diffForHumans();
            })
            ->filter(function($query){
                $request = request()->query('search');
                if ($request['value']) {
                    $query
                    ->orWhere('name', 'like', "%" . $request['value'] . "%")
                    ->orWhere('email', 'like', "%" . $request['value'] . "%")
                    ->orWhereHas('roles', function ($query) use ($request){
                        $query->where('roles.name', 'LIKE', "%" . $request['value'] . "%");
                    });
                };
            })
            ->rawColumns(['Usuario','email','Acciones']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\UsersDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        return $model
                ->newQuery()
                ->select('users.*')
                ->with(['roles'])
                ->orderBy('name', 'asc')
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
                    ->setTableId('usersdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->orderBy(1, 'asc')
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
            Column::make('Usuario'),
            Column::make('email'),
            Column::make('Permisos'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
