<?php

namespace App\Http\Controllers;

use App\DataTables\IssueDataTable;
use App\Events\IssueCreated;
use App\Http\Requests\SaveIssueRequest;
use App\Models\Directorio;
use App\Models\Issue;
use Illuminate\Http\Request;

class IssuesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['create','store']]);
        $this->middleware('roles:administrador', ['except' => ['create','store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IssueDataTable $dataTable)
    {
        return $dataTable->render("gerencias.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Issue $issue)
    {
        $directorio = Directorio::find(request()->query('directorio_id'));
        return view('issues.create',[
            'issue' => new Issue,
            'directorio' => $directorio,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveIssueRequest $request)
    {
        $issue = $request->validated();
        $issue = Issue::create($issue);
        $issueCount = Issue::all()->count();
        broadcast(new IssueCreated($issueCount));
        return redirect()->route('directorios.index')->with('status', 'Novedad reportada.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        return view('issues.show', [
            'issue' => $issue,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        return 'Destroyed';
    }

    // public function ajax(){
    //     return 1;
    // }
}
