<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
      protected $currentUser;

      public function __construct(){

        //1.se non sei loggato puoi accedere solo ad index e a show
        $this->middleware('auth')->except(['index', 'show']); //NON PASSATO? REGISTER O LOGIN


        //if user non ha un ruolo Auth::user() null
        //escludere le rotte index e show e farle vedere comunque

        //al netto del middleware Auth

        //2.Puoi accedere a index e show se hai i permessi per
        //vedere e ricercare (sia ospite che proprietario)
        $this->middleware([
                            'permission:view-apartment',
                            'permission:search-apartment'
                          ])->except(['index', 'show']);;

        //3.Solo i proprietari hanno i set dei permessi
        //per fare modifiche
        $this->middleware([
                            'permission:create-apartment',
                            'permission:edit-apartment',
                            'permission:delete-apartment',
                          ])->except(['index', 'show']);

      //In caso non si soddisfino le proprietà si riviene
      //mandati alla pagina 403:forbidden
      }



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
