<?php 
namespace App\Services;

use App\Models\Activity;

class ActivityTracker
{
    public static function track(
        string $type,
        ?string $description = null,
        $subject = null
    ) {
        return Activity::create([
            'user_id' => auth()->id(),

            'session_id' => request()->session()->getId(),

            'activity_type' => $type,

            'description' => $description,

            'subject_type' => $subject
                ? get_class($subject)
                : null,

            'subject_id' => $subject?->id,

            'url' => request()->fullUrl(),

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),
        ]);
    }
}