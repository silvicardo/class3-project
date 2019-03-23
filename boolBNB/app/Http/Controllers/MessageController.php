<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //variabile per conservare l'utente
    // che passa sul controller
    //e il suo ruolo
    protected $currentUser;

    //middleware permessi sul costruttore
    public function __construct(){

      $this->currentUser = null;

      //1.se non sei loggato puoi accedere solo ad index e a show
      $this->middleware('auth'); //NON PASSATO? REGISTER O LOGIN

      //tutti gli user registrati hanno permesso di
      //gestire la propria messaggistica,
      //esplicitiamo comunque questa possibilità
      $this->middleware('permission:manage-owner|manage-guest');

      //In caso non si soddisfino le proprietà si riviene
      //mandati alla pagina 403:forbidden

      //Popoliamo la var user del controller
      //per non dover ripetere la ricerca ogni volta
      $this->middleware(function ($request, $next) {

        $this->currentUser = Auth::user();

        $this->currentUser->role = $this->currentUser->roles()->first()->name;

        return $next($request);

      });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //visualizzare messaggi del mittente

      $allMessages = Message::where('sender_id','=', $this->currentUser->id);
      if (empty($allMessages->count() === 0)){

        dd('no messaggi');
        $id = $this->currentUser->id;
        return view("${$this->currentUser->role}.profile", compact('id'));
      }
        return view('admin.messages.index', compact('allMessages'));

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
