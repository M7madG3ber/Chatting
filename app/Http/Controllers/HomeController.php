<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User ;
use App\Message ;
use DB ;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $messages = Message::paginate(1) ;

        return view( 'pagination' , compact('messages' ) );
    }

    public function getAllMessages()
    {
        if( session()->get('user') !== null )
        {
            $arrayIds = [] ;
            $arrayIds[] =  auth()->user()->id ;
            $arrayIds[] =  session()->get( 'user' )->id ;

            $messages = Message::paginate(1) ;

            return view( 'pagination' , compact('messages') ) ;

            $arr = json_encode( $messages , true ) ;
            return response()->json( $arr )  ;   
        }
        $arr = json_encode( [] , true ) ;
        return response()->json( $arr )  ;   
    }

    public function deleteMessages()
    {
        $messages = DB::delete( "delete from messages where messages.from = ". auth()->user()->id . " and messages.to = " . session()->get( 'user' )->id ) ;
        $messages = DB::delete( "delete from messages where messages.from = " . session()->get( 'user' )->id ." and messages.to = " . auth()->user()->id ) ;  
    }

    public function userSession($id)
    {
        $user = User::where( 'id' , $id )->get()->first() ;

        session()->put( 'user' , $user ) ;

        return redirect( url('home') ) ;
    }

    public function sendMessage()
    {
        $m = new Message ;

        $m->from = auth()->user()->id ;

        if( session()->get( 'user' ) === null )
        {
            return "You Should Choose User" ;
        }
        $m->to = session()->get( 'user' )->id ;

        $m->text = request('text') ;

        $m->save() ;

        return "Gooooooooood" ;
    }


}