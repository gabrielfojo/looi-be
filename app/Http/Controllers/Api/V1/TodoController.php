<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()


    {
        return Auth::user()->todo;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|max:255',
        ]);

        $todo = new Todo;
        $todo->title = $request->title;
        $todo->body = $request->body;
        $todo->color = $request->color ?? null;
        $todo->user_id = Auth::id();
        $todo->save();

        return $todo;
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        if ($todo->user_id !== Auth::id()) {
            return response('Bad Request', 400);
        }

        return $todo;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {

        if ($todo->user_id !== Auth::id()) {
            return response('Bad Request', 400);
        }

        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|max:255',
        ]);

        $todo->title = $request->title;
        $todo->body = $request->body;
        $todo->color = $request->color ?? null;
        // $todo->user_id = 2;
        $todo->save();

        return $todo;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        if ($todo->user_id !== Auth::id()) {
            return response('Bad Request', 400);
        }

        return $todo->delete();
    }
}
