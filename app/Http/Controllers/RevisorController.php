<?php

namespace App\Http\Controllers;
use App\Mail\workWithUs;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class RevisorController extends Controller
{
    public function index(){
        $announcementToCheck = Announcement::where('user_id', '!=', Auth::id())->where('is_accepted', null)->first();
        return view('revisor.index', compact('announcementToCheck'));
    }

    public function acceptAnnouncement(Announcement $announcement){
        $announcement->setAccepted(True); #e' un metodo in announcement controller
        return redirect()->back()->with('success', 'Annuncio accettato correttamente.');
    }

    public function rejectAnnouncement(Announcement $announcement){
        $announcement->setAccepted(False);
        return redirect()->back()->with('success', 'Annuncio rifiutato correttamente.');
    }

    public function workWithUsForm(){
        
        return view('revisor.workWithUs');

    }

    public function workWithUs(Request $request){
        Mail::to('admin@presto.it')->send(new workWithUs(Auth::user(), $request));
        
        
        return redirect()->back()->with('message', 'Grazie per la tua richiesta di diventare revisore, ti risponderemo al piu\' presto');

    }

    public function makeRevisor(User $user){
        #call richiama il comando al click
        
        Artisan::call('presto:makeUserRevisor', ["email" => $user->email]);
        return redirect('/')->with('message', 'Complimenti, l\'utente e\' diventato revisore');
    }
}
