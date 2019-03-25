<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

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
      $messages = Message::where('sender_id','=', $this->currentUser->id)->get();

      if ($messages->isEmpty()){

        return view("admin.{$this->currentUser->role}.profile",
                    [
                      'currentUser' => $this->currentUser,
                      'alert' => 'Non hai messaggi'
                    ]
                    );
      }

      return view('admin.messages.index', compact('messages'));

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
                      'currentUser' => $this->currentUser,
                      'title' => ($this->currentUser->role === 'owner') ? "Invia un messaggio all'ospite" : 'Richiedi informazioni',
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
        $newMessage->sender_id = $this->currentUser->id;
        $newMessage->fill($data);
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
