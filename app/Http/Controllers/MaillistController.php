<?php

namespace App\Http\Controllers;

use App\Maillist;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class MaillistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maillist = Maillist::paginate(5);
        return view('email.maillist',compact('maillist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Maillist  $maillist
     * @return \Illuminate\Http\Response
     */
    public function show(Maillist $maillist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Maillist  $maillist
     * @return \Illuminate\Http\Response
     */
    public function edit(Maillist $maillist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Maillist  $maillist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $maillist = Maillist::all();
        $today = Carbon::now();
        $count = 0;
        foreach ($maillist as $email){
            if ($email->status=='Active' && $today->diffInDays($email->last_login) > 4)
            {
                $email->status='Not Responsive';
                $count+=1;
                $email->save();
            }
            elseif($email->status=='Not Responsive' && $today->diffInDays($email->last_login) > 2){
                $email->status='Inactive';
                $count+=1;
                $email->save();
            }
            if($email->status=='Not Responsive' && $today->diffInDays($email->last_login) <= 2){
                $email->status='Active';
                $count+=1;
                $email->save();
            }
        }

        return redirect('/maillist')->with('status','Updated '.$count.' Email Status!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Maillist  $maillist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maillist $maillist)
    {
        //
    }

    public function test()
    {
    
        return "yes";
    }

    public function dashboard(){
        $records = Record::paginate(5);
        return view('email.dashboard',compact('records'));
    }

    public function send(Request $request){
        $maillist = Maillist::all(); // Can just grab Active and Not Responsive
        $today = Carbon::now();
        $count = 0;
        foreach ($maillist as $mail){
            if ($mail->status=="Active" && $today->diffInDays($mail->last_email_sent)>=1){
                //send email and update the last email sent date
                $mail->last_email_sent = $today;
                $mail->save();

                $mail_message = 'Hello Active User';
                $mail_subject = 'Message Subject';
                $mail_to = $mail->email;


                Mail::raw($mail_message, function ($message) use($mail_subject,$mail_to){
                    $message->subject($mail_subject)
                        ->to($mail_to);
                });

                //Add Email Record
                $record = new Record();
                $record->subject = $mail_subject;
                $record->message = $mail_message;
                $record->from = 'server email';
                $record->to = $mail_to;
                $record->time_sent = $today;
                $record->save();

                $count += 1;

            }
            elseif ($mail->status=="Not Responsive" && $today->diffInDays($mail->last_email_sent)>=3){
                $mail->last_email_sent = $today;
                $mail->save();

                $mail_message = 'Hello Active Not Responsive User';
                $mail_subject = 'Message Subject';
                $mail_to = $mail->email;


                Mail::raw($mail_message, function ($message) use($mail_subject,$mail_to){
                    $message->subject($mail_subject)
                        ->to($mail_to);
                });

                //Add Email Record
                $record = new Record();
                $record->subject = $mail_subject;
                $record->message = $mail_message;
                $record->from = 'server email';
                $record->to = $mail_to;
                $record->time_sent = $today;
                $record->save();

                $count += 1;
            }
        }

        return redirect('/maillist')->with('status','Sent '.$count.' Email!');
    }
}
