<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        //Validate request
        $data = $request->input();
         Validator::make($data, [
             'column_id' => 'required|exists:columns,id',
             'title' => 'required|string',
             'description' => 'nullable|string',
             'order' => 'required|numeric',
         ])->validate();

        // Add card to database.
        $card = (new Card([
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'order' => $data['order'],
            'column_id' => $data['column_id'],
        ]))->save();


        // Return Json response
        return response()->json($card);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return Response
     */
    public function edit(Card $card)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Card $card
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Card $card): JsonResponse
    {
        // Validate rules to update card.
        $data = $request->input();
        Validator::make($data,[
            'card_id' => 'required|exists:cards,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'order' => 'required|numeric'
        ])->validate();

        $card = Card::findorFail($data['card_id']);

        $card->title = $data['title'];
        $card->description = $data['description'];
        $card->order =  $data['order'];
        $card->save();

        return response()->json($card);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return Response
     */
    public function destroy(Card $card)
    {
        //
    }

}
