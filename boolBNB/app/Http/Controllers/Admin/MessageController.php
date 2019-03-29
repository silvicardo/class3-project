<?php

namespace App\Http\Controllers\Admin;

use App\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Apartment;

class MessageController extends Controller
{



    //middleware permessi sul costruttore
    public function __construct(){

      //1.se non sei loggato puoi accedere solo ad index e a show
      $this->middleware('auth'); //NON PASSATO? REGISTER O LOGIN

      //tutti gli user registrati hanno permesso di
      //gestire la propria messaggistica,
      //esplicitiamo comunque questa possibilità
      $this->middleware('permission:manage-owner|manage-guest');

      //In caso non si soddisfino le proprietà si riviene
      //mandati alla pagina 403:forbidden

      // Auth::user()->roles()->first()->name;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $currentUser = Auth::user();
      //visualizzare messaggi del mittente
      $messages = Message::where('sender_id','=', $currentUser->id)->get();

      foreach ($messages as &$message) {

        $message['recipient_name'] = User::find(Apartment::find($message['apartment_id'])->user_id)->name;

      }

      $receivedMessages = Message::where('recipient_mail','=', $currentUser->email)->get();

      foreach ($receivedMessages as &$message) {

        $message['sender_name'] = User::find($message['sender_id'])->name;
        $message['sender_email'] = User::find($message['sender_id'])->email;

      }


      if ($messages->isEmpty() && $receivedMessages->isEmpty()){

        return view("admin.{$currentUser->roles()->first()->name}.profile",
                    [
                      'currentUser' => $currentUser,
                      'alert' => 'Non hai messaggi'
                    ]
                    );
      }

      //$messages = array_merge($messages->toArray(), $receivedMessages->toArray());

      return view('admin.messages.index', compact('messages', 'receivedMessages', 'currentUser' ));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view("admin.messages.create",
                    [
                      'currentUser' => Auth::user(),
                      'title' => (Auth::user()->roles()->first()->name === 'owner') ? "Invia un messaggio all'ospite" : 'Richiedi informazioni',
                      'action' => route('messages.store')
                    ]);
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
        $newMessage = new Message;
        $newMessage->sender_id = Auth::user()->id;
        $newMessage->recipient_mail = User::find(Apartment::find($data['apartment_id'])->user_id)->email;
        $newMessage->fill($data);
        // dd($newMessage);
        $newMessage->save();

        return redirect()->route('messages.index',['success' => 'Messaggio consegnato']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {

      dd($message->id);
      $foundMessage = Message::find($message->id);
      //dd($foundMessage);
      if(!empty($foundMessage))
      {
        return view('messages.show', ['message' => $foundMessage]);
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
    public function destroy(Request $request)
    {
        $foundMessage = Message::find($request['message_id']);
        // dd($message);
        if(!empty($foundMessage))
        {
          $foundMessage->delete();
        }

        return redirect()->route('messages.index');

    }
}
