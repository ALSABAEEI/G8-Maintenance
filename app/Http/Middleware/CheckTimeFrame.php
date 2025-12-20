<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TimeFrame;
use Carbon\Carbon;

class CheckTimeFrame
{
    public function handle(Request $request, Closure $next, $eventType)
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Fetch the timeframe for the given event type
        $timeframe = TimeFrame::where('Event_Type', $eventType)
            ->where('Start_Date', '<=', $currentDate)
            ->where('End_Date', '>=', $currentDate)
            ->first();

        // If no active timeframe is found, block access
        if (!$timeframe) {
            return redirect()->back()->with('error', "The '$eventType' event is not available at this time.");
        }

        return $next($request);
    }
}
