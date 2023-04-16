<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
  
  
        public function index(Request $request)
            {
                // Get all events
                $events = Event::query();

                // Perform search by keyword
                $keyword = $request->input('keyword');
                if ($keyword) {
                    $events->where(function ($query) use ($keyword) {
                        $query->where('eventName', 'LIKE', "%$keyword%");
                    });
                }

                $start_date = $request->input('start_date');
                    $end_date = $request->input('end_date');
                    if ($start_date && $end_date) {
                        $events->where(function ($query) use ($start_date, $end_date) {
                            $query->whereBetween('startDate', [$start_date, $end_date])
                                ->orWhereBetween('endDate', [$start_date, $end_date])
                                ->orWhere(function ($query) use ($start_date, $end_date) {
                                    $query->where('startDate', '<', $start_date)
                                        ->where('endDate', '>', $end_date);
                                });
                        });
                    }

                // Paginate the events
                $events = $events->paginate(2); // Change the per page limit as needed

                return view('welcome', ['events' => $events]);
            }
}
