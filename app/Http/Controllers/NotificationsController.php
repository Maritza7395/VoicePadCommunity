<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $readNotifications = $user->readNotifications;
        $unreadNotifications = $user->unreadNotifications;
        return view('users.notifications',compact('readNotifications','unreadNotifications'));
    }

     public function unreadNotificationsData()
    {
        $user = Auth::user();
        $unreadNotifications = $user->unreadNotifications;
        return $unreadNotifications;
    }
    public function readNotificationsData()
    {
        $user = Auth::user();
        $readNotifications = $user->readNotifications;
        return $readNotifications;
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show($id)
    {
        abort(404);
    }

    public function edit($id)
    {
        abort(404);
    }

    
    public function update(Request $request, $id)
    {
        abort(404);
    }

    public function destroy($id)
    {
        DatabaseNotification::find($id)->delete();
        return back()->with('flash','Notificacion Eliminada');
    }

    public function readNotification($id){
        DatabaseNotification::findOrFail($id)->markAsRead();
        return response()->json($id);
        // return back()->with('flash','Notificacion marcada como leida');
    }   
}
