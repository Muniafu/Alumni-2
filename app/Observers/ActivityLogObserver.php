<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogObserver
{
    public function created($model)
    {
        $this->logActivity("created", $model);
    }

    public function updated($model)
    {
        $this->logActivity("updated", $model);
    }

    public function deleted($model)
    {
        $this->logActivity("deleted", $model);
    }

    protected function logActivity($action, $model)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => class_basename($model),
            'model_id' => request()->userAgent(),
            'description' => $model->toArray(),
        ]);
    }
}
