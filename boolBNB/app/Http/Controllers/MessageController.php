<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //visualizzare messaggi del mittente
        $id = Auth::user()->id;
        $allMessages = Message::where('sender_id','=', $id);
        return view('messages.index', compact('allMessages'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $id = Auth::user()->id;
        $newMessage = new Message;
        $newMessage->sender_id = $id;
        $newMessage->fill($data);
        $newMessage->save();

        return redirect()->route('messages.index');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
      $foundMessage = Message::find($message->id);

      if(!empty($foundMessage))
      {
        return view('messages.show', compact($message));
      }

      else
      {
        return redirect()->route('messages.index');
      }

    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {

        $foundMessage = Message::find($message->id);

        if(!empty($foundMessage))
        {
          $foundMessage->delete();
        }

        return redirect()->route('messages.index');

    }
}
