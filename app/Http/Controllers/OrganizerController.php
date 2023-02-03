<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = Http::log()->withToken(\Cache::get('token'))->get(env('APP_API_URL').'/api/v1/organizers', [
            'page' => $request->get('page'),
            'perPage' => 10
        ]);

        $responseBody = json_decode($response->body());

        if($response->failed()){
            return $this->returnFailedResponse($response->status(), $responseBody);
        }

        $paging = new Paginator($responseBody->data, $responseBody->meta->pagination->total, 10, $request->get('page'), [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('admin.organizers.index')->with(['organizers' => $responseBody->data, 'meta' => $responseBody->meta, 'pagination' => $paging]);
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
