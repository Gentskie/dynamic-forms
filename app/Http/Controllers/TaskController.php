<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskModel;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = TaskModel::all();
        return view('/dynamicForms')->with('tasks', $tasks);
    }
    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required',
            'cost' => 'required'
         ]);

         $count = count($request->task_name);

         for ($i=0; $i < $count; $i++) {

           TaskModel::create([
            'task_name' => $request->task_name[$i],
            'cost' => $request->cost[$i],
           ]);
         }
         return redirect()->route('tasks.index');
    }
}
