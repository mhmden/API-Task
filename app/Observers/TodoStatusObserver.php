<?php

namespace App\Observers;

use App\Models\Todo;
use App\Models\TodoStatusHistory;

class TodoStatusObserver
{
    /**
     * Handle the Todo "created" event.
     *
     * @param  \App\Models\Todo  $todo
     * @return void
     */
    public function created(Todo $todo)
    {
        //
        TodoStatusHistory::create([
            'todo_id' => $todo->id,
            'status_id' => $todo->status->id,
        ]);
    }

    /**
     * Handle the Todo "updated" event.
     *
     * @param  \App\Models\Todo  $todo
     * @return void
     */
    public function updated(Todo $todo)
    {
        //
        if ($todo->wasChanged('status_id')) { // TODO Experiment with Different Methods for this sort of work.
            TodoStatusHistory::create([
                'todo_id' => $todo->id, // This is there because it is a fillable
                'status_id' => $todo->status->id,
            ]);
        }
    }

    /**
     * Handle the Todo "deleted" event.
     *
     * @param  \App\Models\Todo  $todo
     * @return void
     */
    public function deleted(Todo $todo)
    {
        //
    }

    /**
     * Handle the Todo "restored" event.
     *
     * @param  \App\Models\Todo  $todo
     * @return void
     */
    public function restored(Todo $todo)
    {
        //
    }

    /**
     * Handle the Todo "force deleted" event.
     *
     * @param  \App\Models\Todo  $todo
     * @return void
     */
    public function forceDeleted(Todo $todo)
    {
        //
    }
}
