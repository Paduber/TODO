<?php
namespace App\Services;

use App\Task;
use Illuminate\Support\Facades\Auth;

class TasklistService{

    public static function getModels($mode)
    {
        switch ($mode)
        {
            case 'date':
                return self::getTasksByDate();
            case 'assigned':
                return self::getAssignedTasks();
            case 'all':
            default:
                return self::getAllTasks();
        }
    }

    private static function getAllTasks()
    {
        $tasks = Task::orderBy('updated_at', 'desc')->get();
        return $tasks;
    }

    private static function getTasksByDate()
    {
        $today = date("Y-m-d");
        $week = date("Y-m-d", strtotime("$today +1 week"));

        $todayTasks = Task::where('end_date', $today)->where('assigned_user_id', Auth::id())->get();

        $weeklyTasks = Task::where('end_date', '>', $today)->where('end_date', '<=', $week)->where('assigned_user_id', Auth::id())->get();

        $furtherTasks = Task::where('end_date', '>', $week)->where('assigned_user_id', Auth::id())->get();

        return array('Today' => $todayTasks, 'Weekly' => $weeklyTasks, 'Further' => $furtherTasks);
    }

    public static function getAssignedTasks()
    {
        $assignedUsers = \App\User::find(Auth::id())->assigned()->get();

        $tasks = array();
        foreach ($assignedUsers as $user)
        {
            $tasks[$user->surname.' '.$user->name] = Task::where('assigned_user_id', $user->id)->get();
        }

        return $tasks;
    }

}
