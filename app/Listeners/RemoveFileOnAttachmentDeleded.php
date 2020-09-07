<?php

namespace App\Listeners;

use App\Events\OnAttachmentDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class RemoveFileOnAttachmentDeleded
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OnAttachmentDeleted  $event
     * @return void
     */
    public function handle(OnAttachmentDeleted $event)
    {
        Storage::delete($event->attachment->path);
    }
}
