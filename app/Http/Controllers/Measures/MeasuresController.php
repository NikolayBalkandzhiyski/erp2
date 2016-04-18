<?php

namespace App\Http\Controllers\Measures;

use App\Http\Requests\MeasuresRequest;
use App\Measures;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MeasuresController extends Controller
{
    /**
     *redirect of not auth
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $measures = Measures::paginate(10);

        $title = trans('measures.measures_list');

        return view('measures.measures' , compact('measures','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('measures.create');

        return view('measures.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateMeasures|MeasuresRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeasuresRequest $request)
    {
        $input = new Measures($request->all());

        $input->ip = $request->ip();

        Auth::user()->measures()->save($input);

        return redirect('/measures');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $measure = Measures::findOrFail($id);

        $title = trans('measures,edit');

        return view('measures.edit', compact('measure','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MeasuresRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(MeasuresRequest $request, $id)
    {
        $measure = Measures::findOrFail($id);

        $input = $request->all();
        $input['ip'] = $request->ip();
        $input['user_id'] = Auth::id();

        $measure->update($input);

        return redirect('/measures');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('measures')->where('id', '=', $id)->delete();

        return redirect('/measures');
    }
}
