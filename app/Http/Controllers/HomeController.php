<?php

namespace Census\Http\Controllers;

use Illuminate\Http\Request;

use Census\Http\Requests;
use Census\Http\Controllers\Controller;
use Mapper;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $m = Mapper::map(42.322639, -71.072849, [
            'zoom' => 6,
            'center' => true,
            'marker' => true,
            'type' => 'ROADMAP',
        ]);
        $data['census_apikey'] = \Dotenv::findEnvironmentVariable('CENSUS_APIKEY');
        $data['map'] = $m;
        $data['id'] = 'census';
        return view('map', $data);

    }

    /* Resources from from dsnidata/census/tracts.json */
    public function tracts() {
        $file = '../dsnidata/census/tracts.json';
        $c = collect(json_decode(file_get_contents($file)));

        if ($c->isEmpty()) {
            return \Response::json((object) []);
        } else {
            return \Response::json($c);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
