<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Minuta;
use App\Models\User;
use App\Http\Requests\Minuta\MinutaStoreRequest;
use App\Http\Requests\Minuta\MinutaUpdateRequest;

class MinutaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = \Auth::id();
        return Minuta::where('usuario_id', $userId)
            ->orWhereHas('minutas_participantes', function ($q) use ($userId) {
                $q->where('usuario_id', $userId);
            })
            ->paginate(10);
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
    public function store(MinutaStoreRequest $request)
    {
        $response = Minuta::storeOrUpdate($request->persist()['in'], $request->persist()['out'], $request->all());

        return response()->json([
            'message_type' => __('success'),
            'message_text' => __('Your Minuta has been created:Notes.', ['Notes' => count($response['not_friends']) > 0 ? __(', Some friends can not be joined') : '']),
            'data' => $response['data'],
            'not_friends' => $response['not_friends']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Minuta::findOrFail($id);
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
    public function update(MinutaUpdateRequest $request, $id)
    {
        $response = Minuta::storeOrUpdate($request->persist()['in'], $request->persist()['out'], $request->all(), $id);

        return response()->json([
            'message_type' => __('success'),
            'message_text' => __('Your Minuta has been updated:Notes.', ['Notes' => count($response['not_friends']) > 0 ? __(', Some friends can not be joined') : '']),
            'data' => $response['data'],
            'not_friends' => $response['not_friends']
        ]);
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
