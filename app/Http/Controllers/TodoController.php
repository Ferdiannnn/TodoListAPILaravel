<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cacheKey = 'todos_paginated_500';

        $cacheDurationInMinutes = 1;

        $todos = Cache::remember($cacheKey, $cacheDurationInMinutes * 60, function () {
            return Todo::paginate(500);
        });


        return response()->json([
            'data' => $todos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $todos = Todo::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        if ($request->user() == null) {
            return response()->json([
                "Message" => "Unauthorized"
            ], 401);
        } else {
            return response()->json([
                "Data" => $todos
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $todos = Todo::FindOrFail($id);
        $userID = $request->user()->id;

        if ($userID == $todos->user_id) {
            $todos->update([
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'description' => $request->description
            ]);
            return response()->json([
                'Data'=>$todos
            ],201);
        } else {
            return response()->json([
                'Message'=>"Forbidden"
            ],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $todos = Todo::FindOrFail($id);

        $userID= $todos->user_id;

        if($userID == $request->user()->id){
            $todos->delete();
             return response()->json([],204);
        } else {
            return response()->json([
                'Message'=>"forbidden"
            ],403);
        }

    }
}
