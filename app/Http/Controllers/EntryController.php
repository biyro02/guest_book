<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EntryController extends Controller
{
    public function insert(Request $request)
    {
        DB::beginTransaction();
        $user = User::whereUsername($request->username)->first();
        if(!$user){
            $user = new User();
            $user->username = $request->username;
            $user->last_entry = '';
            $user->save();
            $user->refresh();
        }

        try {
            $entry = new Entry();
            $entry->subject = $request->subject;
            $entry->message = $request->message;
            $entry->user_id = $user->id;
            $entry->username = $request->username;
            $entry->save();
            DB::commit();

            return response()->json([
                'status'=>200,
                'message'=>'Your entry added successfully.',
                'entry' => [
                    'user' => $user->toArray(),
                    'subject'=> $entry->subject,
                    'message' => $entry->message,
                    'created_date'=>$entry->created_at
                ]
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();

            Log::error('Entry couldn\'t be added. Exception: ' . $throwable->getMessage());
            return response()->json(['status'=>400, 'message'=>'There is a problem, please try again later.']);
        }
    }

    public function list(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 3);

        $entries = Entry::paginate($pageSize, ['*'], 'page', $page);

        $data = [
            'count' => $entries->count(),
            'page_size' => $entries->perPage(),
            'total_pages' => $entries->lastPage(),
            'current_page_number' => $entries->currentPage(),
            'links' => [
                'next' => $entries->nextPageUrl(),
                'prev' => $entries->previousPageUrl(),
            ],
            'entries' => $entries
        ];

        return response()->json($data);
    }
}
