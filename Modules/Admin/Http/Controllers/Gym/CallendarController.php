<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Event;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use View;
class CallendarController extends Controller
{
    
     public function index()
            {
                $events = [];
                $data = Event::all();               
                if($data->count()) {
                    foreach ($data as $key => $value) {
                        $events[] = Calendar::event(
                            $value->title,                             
                            false,
                            new \DateTime($value->start_date),
                            new \DateTime($value->end_date.' +1 day'),                         
                            $value->id,
                         [
                             'color' => $value->color,
                           'description'=> $value->description,
                         ]
                        );
                    }
                                    
                    }
                $calendar = Calendar::addEvents($events)
                        ->setCallbacks(
                           ['eventClick' => 'function(calEvent, jsEvent, view) {
                            $("#modalTitle").html(calEvent.title);
                           $("#modalBody").html(calEvent.description);
                           $("#eventUrl").attr("href",calEvent.linkurl);
                           $("#calendar").modal();
                           }']
                        );
                 $this->layoutData['content'] = View::make('admin::settings.callendar',
                         array(
                    'calendar' => $calendar,
        ));
                
}


}
