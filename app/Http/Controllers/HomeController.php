<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use App\Events\SendNotifications;
  
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
        return view('home');
    }
  
    /** 
     * Write code on Method
     *
     * @return response()
     */
    public function saveToken(Request $request)
    {
        DB::table('users')->update(['device_token'=> $request->token ]);
        return response()->json(['token saved successfully.']);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendNotification(Request $request)
    {

        $notification = new Notification;
        $notification->message = $request->body;
        $notification->save(); 

        event(new SendNotifications($notification->id , $request->body));
    

        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
        
        
        $SERVER_API_KEY = 'AAAA9q3uc1E:APA91bGfDm5UbS2Evg0t8zpNs4pYJsu4buaPofiP4kiXOV0RZyv-Je0o0CBjhcLWKIMrGF6n9Q2zf-Og10T1ZQBpDGMdi9Y3qOzmXZJAAmPSRLoUoi9lLo6szNfEQ-_nxRPC5ysN9Shp';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
        
        return $notification;
  
    }
}