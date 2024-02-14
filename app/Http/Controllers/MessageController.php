<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use App\Mail\ContactusMail;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $messages=Message::paginate(20);
        return view('backend.message.index')->with('messages',$messages);
    }
    public function messageFive()
    {
        $message=Message::whereNull('read_at')->limit(5)->get();
        return response()->json($message);
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
        $this->validate($request,[
            'name'=>'string|required|min:2',
            'email'=>'email|required',
            'message'=>'required|max:200',
            'subject'=>'string|required',
            'phone'=>'numeric|required'
        ]);


        // return ;

        $message=Message::create($request->all());
            // print_r($message->name);
            // die;
        $datav=array();
        $datav['url']=route('message.show',$message->id);
        $datav['date']=$message->created_at->format('F d, Y h:i A');
        $datav['name']=$message->name;
        $datav['email']=$message->email;
        $datav['phone']=$message->phone;
        $datav['message']=$message->message;
        $datav['subject']=$message->subject;
        if(isset(Auth()->user()->photo)){
            $datav['photo']=Auth()->user()->photo;

        }


        $data = [
            'name' => $message->name,
            'subject' => $message->subject,
            'phone' => $message->phone,
            'email' => $message->email,
            'body' => $message->message,
        ];
        // return $data;    
        $subject = $message->subject;
        $from_mail= $message->email;

      $aaaa = Mail::send('emails.contactus', $data, function($messageb) use ($subject, $from_mail) {
        $messageb->to(env('MAIL_ADMIN_ADDRESS'));
        $messageb->subject($subject);
        $messageb->from(env('MAIL_FROM_ADDRESS'),'DMC Motorsports');
        });

        Mail::send('emails.thanks', $data, function($messagen) use ($subject, $from_mail) {
            $messagen->to($from_mail);
            $messagen->subject('DMC Motorsports Support');
            $messagen->from(env('MAIL_FROM_ADDRESS'),'DMC Motorsports');
            });
        event(new MessageSent($datav));
        exit();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $message=Message::find($id);
        if($message){
            $message->read_at=\Carbon\Carbon::now();
            $message->save();
            return view('backend.message.show')->with('message',$message);
        }
        else{
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message=Message::find($id);
        $status=$message->delete();
        if($status){
            request()->session()->flash('success','Successfully deleted message');
        }
        else{
            request()->session()->flash('error','Error occurred please try again');
        }
        return back();
    }
}
