<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{

    protected $guarded = ['id'];

    public function taskColor()
    {
        $date = date("Y-m-d");
        if($this->end_date < $date) {
            if ($this->status == 1 || $this->status == 2)
                return 'red';
        }

        if ($this->status == 3)
            return 'green';

        return 'grey';
    }

    public function userName()
    {
        $user = User::find($this->assigned_user_id);
        return $user->name . ' ' . $user->surname;
    }

    public function getPriorityName()
    {
        return $this->belongsTo('\App\Priority', 'priority')->first()->name;
    }

    public function getStatusName()
    {
        return $this->belongsTo('\App\Status', 'status')->first()->name;
    }
}
