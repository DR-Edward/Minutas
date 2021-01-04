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
        $participantes = [2, 3, 4];
        $userId = \Auth::id();


        $amigos = User::whereHas('myFriends', function ($q) use($userId){
            $q->where('solicitante_id', $userId);
        })
        ->orWhereHas('friendOf', function ($q) use($userId){
            $q->where('solicitado_id', $userId);
        })
        ->get()
        ->makeVisible('friends')
        ->first()
        ->friends
        ;

        $id_array = array_map(function ($element) {
            return $element['id'];
        }, $amigos); 

        return array_intersect($id_array, $participantes);
        return array_diff_assoc($participantes, $id_array);

        
        // return User::
        // where('id', '!=', $userId)
        // ->whereHas('myFriends', function($q) use ($userId, $participantes) {
        //     $q->where('amigos.solicitante_id', $userId)
        //         ->whereIn('amigos.solicitado_id', $participantes);
        // })
        // ->orWhereHas('friendOf', function($q) use ($userId, $participantes) {
        //     $q->where('solicitante_id', $userId)
        //     ->whereIn('amigos.solicitado_id', $participantes); 
        // })
        // ->where('id', '!=', $userId)
        // ->with(['myFriends', 'friendOf'])
        // ->get()
        // ->makeVisible(['myFriends', 'friendOf'])
        ;

        //este se ve prometedor
        // $amigos = Amigo::where(function($q) use($participantes, $userId) {
        //         $q->where('aceptada', true)
        //             ->where('solicitante_id', $userId)
        //             ->whereIn('solicitado_id', $participantes);
        //     })
        //     ->orWhere(function($q) use($participantes, $userId){
        //         $q->where('aceptada', true)
        //             ->where('solicitado_id', $userId)
        //             ->whereIn('solicitante_id', $participantes);
        //     })
        //     ->get();
        
        
        // return $amigos;


        // return User::where('id', '!=', $userId)
        //     ->whereHas('myFriends', function ($q) use ($participantes, $userId) {
        //         $q->where('amigos.solicitante_id', $userId)
        //             ->whereIn('amigos.solicitado_id', $participantes);
        //     })
        //     ->orWhereHas('friendOf')
        //     ->with(['myFriends', 'friendOf'])
        //     ->get()
        //     ->makeVisible(['myFriends', 'friendOf'])
        //     ;





//este es el original de este endpoint
        // return User::whereHas('myFriends', function ($q) use($userId){
        //         $q->where('solicitante_id', $userId);
        //     })
        //     ->orWhereHas('friendOf', function ($q) use($userId){
        //         $q->where('solicitado_id', $userId);
        //     })
        //     ->get()
        //     ->makeVisible('friends');
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
