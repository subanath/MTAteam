<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\InvitedUser;
use Auth;

class EventController extends Controller
{

    public function removeInvitedUsers(Request $request)
    {
        $invitedUser = InvitedUser::find($request->id);
        $invitedUser->delete();
        echo 1;
    }

    public function getInvitedUsers(Request $request)
    {
        
        $events = Event::with(['invitedUsers.user'])->find($request->eventid);
       
        echo json_encode($events);
    }
    public function listEvents()
    {
        $events = Event::all(); // Fetch events data from Event model

        return view('events.index', ['events' => $events]);
    }
    public function createEvents()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view('events.create',['users' => $users]);
    }

    public function saveEvents(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'eventName' => 'required|max:255',
            'startDate' => 'required|date|before_or_equal:endDate',
            'endDate' => 'required|date',
        ]);

        // Create a new event
        $event = new Event;
        $event->eventName = $request->input('eventName');
        $event->startDate = $request->input('startDate');
        $event->endDate = $request->input('endDate');
        $event->user_id = Auth::id(); // Assuming user is logged in
        $event->save();
        if ($request->has('invited_users')) {
            $invitedUsers = $request->input('invited_users');
            foreach ($invitedUsers as $id) {
                // Save invited user to the invited_users table
                $invitedUser = new InvitedUser();
                $invitedUser->event_id = $event->id; // Assuming the event_id is the foreign key in the invited_users table
                $invitedUser->user_id = $id;
                $invitedUser->save();

             
            }
        }

        return redirect()->route('listEvents')->with('success', 'Event created successfully!');
    }
}
