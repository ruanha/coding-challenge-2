<?php

namespace App\Http\Controllers;

use App\Entry;
use DateTime;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function __construct()
    {

    }

    public function start(Request $request)
    {        
        $startTime = new DateTime();
        $entry = Entry::create([
            'start' => $startTime,
        ]);
        $entry->project_id = $request->get('project_id');
        $entry->save();

        return response()->json([
            'status' => 'success',
            'entry' => $entry
        ]);
    }

    public function stop(Request $request)
    {
        $endTime = new DateTime();
        $entry = Entry::where('project_id', $request->get('project_id'))
            ->where('end', null)
            ->update(['end' => $endTime]);

        return response()->json([
            'status' => 'success',
            'entry' => $entry
        ]);
    }

    public function delete(Request $request)
    {
        Entry::where('id', $request->get('id'))->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }
}
