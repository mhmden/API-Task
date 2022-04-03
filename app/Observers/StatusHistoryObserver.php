<?php

namespace App\Observers;

use App\Models\Todo;
use App\Models\TodoStatusHistory;

class StatusHistoryObserver // Todo
{
    /**
     * Handle the Todo "created" event.
     *
     * @param  \App\Models\Todo  $todo
     * @return void
     */
    public function created(Todo $todo)
    {
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
        if($todo->isDirty('status_id')){
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

    public function saved(Todo $todo)
    {
        // dd('saved');
        // TodoStatusHistory::create([
        //     'todos_id' => $todo->id,
        //     'status_id' => $todo->status->id,
        // ]);
    }

    public function saving(Todo $todo)
    {
        // dd('saving');
        // // TodoStatusHistory::create([

        // // ]);
    }
}
