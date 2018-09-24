<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = [
            'today'    => Task::where('user_id', Auth::user()->id)->whereDate('deadline', \Carbon\Carbon::today())->orderBy('updated_at', 'DESC')->get(),
            'tomorrow' => Task::where('user_id', Auth::user()->id)->whereDate('deadline', \Carbon\Carbon::tomorrow())->orderBy('updated_at', 'DESC')->get(),
            'soon'     => Task::where('user_id', Auth::user()->id)->whereDate('deadline', '>', \Carbon\Carbon::tomorrow())->orderBy('updated_at', 'DESC')->get(),
            'overdue'  => Task::where('user_id', Auth::user()->id)->whereDate('deadline', '<', \Carbon\Carbon::today())->orderBy('updated_at', 'DESC')->get()
        ];
        return view('tasks', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $this->validate($request, [
            'body' => 'required|string|min:5|max:100',
            'deadline' => 'required|date'
        ]);

        // Store into database
        $task = new Task;
        $task->body = $request->input('body');
        $task->deadline = $request->input('deadline');
        $task->user_id = Auth::user()->id;
        $task->save();
        return response()->json([
            'status' => 'success',
            'task_id' => $task->id
        ], 200);
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
        // return $id;
        $task = Task::findOrFail($id);
        $sections = array('');
        $this->validate($request, [
            'to' => 'required|string|in:today,tomorrow,soon,overdue'
        ]);
        switch($request->input('to')){
            case 'today':
                $task->deadline = \Carbon\Carbon::today();
                $task->save();
            break;
            case 'tomorrow':
                $task->deadline = \Carbon\Carbon::tomorrow();
                $task->save();
            break;
            case 'overdue':
                $task->deadline = \Carbon\Carbon::yesterday();
                $task->save();
            break;
            case 'soon':
                $task->deadline = \Carbon\Carbon::today()->addDays(2);
                $task->save();
            break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }
}
