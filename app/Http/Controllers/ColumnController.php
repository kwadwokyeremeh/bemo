<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

        $columns = Column::with('cards')->get();

        return response()->json($columns);
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
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->input();
        Validator::make($data, [
            'title' => 'required|unique:columns|max:255',
            'order' => 'required|numeric',
        ]);

        $column = (new Column([
            'title' => $data['title'],
            'order' => $data['order'],
        ]))->save();

        return response()->json($column);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function show(Column $column)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function edit(Column $column)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Column  $column
     * @return JsonResponse
     */
    public function update(Request $request, Column $column): JsonResponse
    {
        $data = $request->input();

        foreach ($data as $column) {
            foreach ($column['cards'] as $index => $card) {
                $card = Card::find($card['id']);
                $card->column_id = $column['id'];
                $card->order = $index + 1;
                $card->save();
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Column  $column
     * @return JsonResponse
     */
    public function destroy(Request $request, Column $column)
    {
        $data = $request->input();

        // Validate request.
        Validator::make($data, [
            'column_id' => 'required|exists:columns,id',
        ]);

        $column = Column::findOrFail($data['column_id']);
        $column->delete();

        return response()->json(['success' => true]);
    }

}
