<?php

namespace App\Http\Controllers;

use App\Priority;
use App\Status;
use App\Task;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Services\TasklistService;

class TasklistController extends Controller
{
    public function tasks(Request $request)
    {
        $mode = $request->get('mode');

        $tasks = TasklistService::getModels($mode);

        $users = auth()->user()->getAvailableUsers();
        $priorities = Priority::all();
        $statuses = Status::all();


        return view('tasklist')->with(compact('tasks'))->with(compact('users'))->with(compact('statuses'))->with(compact('priorities'));
    }

    public function addTaskAjax(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'end_date' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'assigned_user_id' => 'required',
        ]);

        $task = new Task();
        $task->created_user_id = auth()->id();
        $data = $request->all();
        $task->fill($data)->save();

    }

    public function getTaskAjax(Request $request, $id)
    {
        $task = Task::find($id);
        $userId = auth()->id();
        if($task->created_user_id == $userId)
            $modify = 'all';
        elseif($task->assigned_user_id == $userId)
            $modify = 'partial';
        else
            $modify = 'no';

        $result['modify'] = $modify;
        $result['task'] = $task->toArray();

        return Response::json($result);
    }

    public function updateTaskAjax(Request $request, $id)
    {
        $task = Task::find($id);
        $userId = auth()->id();

        if($task->created_user_id == $userId)
        {
            $validatedData = $request->validate([
                'title' => 'required',
                'description' => 'required',
                'end_date' => 'required',
                'priority' => 'required',
                'status' => 'required',
                'assigned_user_id' => 'required',
            ]);
            $data = $request->all();
            $task->fill($data)->save();
        }
        elseif($task->assigned_user_id == $userId) {
            $task->status = $request->get('status');
        }
        else
            return;
        $task->save();
    }
}
