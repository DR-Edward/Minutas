<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amigo;
use App\Models\User;
use App\Http\Requests\Amigo\AmigoStoreRequest;
use App\Http\Requests\Amigo\AcceptOrDeclineAmigoRequest;
use App\Http\Requests\Amigo\AmigoDeleteRequest;

class AmigoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::whereHas('myFriends', function ($q) {
                $q->where('solicitante_id', 1)
                    ->where('aceptada', true);
            })
            ->orWhereHas('friendOf', function ($q) {
                $q->where('solicitado_id', 1)
                    ->where('aceptada', true);
            })
            ->get()->makeVisible('friends');
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
    public function store(AmigoStoreRequest $request)
    {
        $newFriend = Amigo::firstOrCreate([
            'solicitante_id' => $request->user()->id,
            'solicitado_id' => $request->input('solicitado_id'),
            'aceptada' => null,
        ]);
        return $newFriend;
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
    public function update(AcceptOrDeclineAmigoRequest $request, $id)
    {
        $friend = Amigo::findOrFail($id); 
        $friend->forceFill([
            'aceptada' =>  $request->input('aceptada'),
        ])->update();

        return response()->json([
            'message_type' => __('success'),
            'message_text' => __('Information updated'),
            'data' => $friend,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AmigoDeleteRequest $request, $id)
    {
        $request->persist()->delete();

        return response()->json([
            'message_type' => __('success'),
            'message_text' => __('Your friend has been deleted.'),
            'data' => $request->persist(),
        ]);
    }
}
