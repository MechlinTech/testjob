<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supports;
use App\Models\Messages;
use App\Models\User;
use App\Notifications\MessageReply;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
  /**
   *  API TO ADD DATA BY USER
   *  */
  public function usermessage(Request $request)
  {        
    try {
    $message_data = $request->message;
    $user_id = Auth::user()->id;
    $data = Supports::where('user_id',$user_id)->whereIn('status',["Not Answered","In Progress"])->first();
    if(!$data){
      $support = New Supports();
      $support->user_id = $user_id;
      $support->status = 'Not Answered';
      $support_id = $support->save();
    }else{
      $data->touch();
      $support_id = $data['id'];
    }
    if($support_id){
      $messages = new Messages();
      $messages->support_id = $support_id;
      $messages->user_id = $user_id;
      $messages->message = $message_data;  
      $messages->save();  
    }
    $result['sucess'] = 'Added Comment';
    } catch (\Exception $e) {
      $result['errors'] = $e->getMessage();
    }
      return response()->json($result, 200);
  }
  /**
   *  API TO ADD DATA BY Support
   *  */
  public function supportreply(Request $request)
  {        
    try {
    $message_data = $request->message;
    $support_id = $request->support_id;
    $support_status = $request->support_status;
    $user_id = Auth::user()->id;
    $data = Supports::find($support_id);
    if($support_status == "Answered"){
      $data->status = 'Answered';
      $data->save();
    }elseif($support_status == "Spam"){
      $data->touch();
      $data->status = 'Spam';
      $data->save();
    }else{      
      $data->touch();
      $data->status = 'In progress';
      $data->save();
    }
    if($message_data){
      $messages = new Messages();
      $messages->support_id = $support_id;
      $messages->user_id = $user_id;
      $messages->message = $message_data;  
      $messages->save();  
    }

    $data = array('name'=>"You are notify to check ur message status");
    Auth::user()->notify(new MessageReply);
    $result['sucess'] = 'Support Comment/Status Added';

    } catch (\Exception $e) {
      $result['errors'] = $e->getMessage();
    }
    return response()->json($result, 200);
  }

  /**
   *  API TO GET ALL SUPPORT DATA
   *  */
  public function allSupport(Request $request)
  {
    try {
      $user_id = Auth::user()->id;
      $data = Supports::where('user_id',$user_id)->with('Messages')->get();
      return response()->json($data, 200);
    } catch (\Exception $e) {
      $result['errors'] = $e->getMessage();
      }
    return response()->json($result, 200);
  }

  /**
   *  API TO GET ALL SUPPORT DATA BY USER NAME
   *  */
  public function searchSupportByName(Request $request)
  {
    try {
      $name = $request->input('name');
      $users_by_name = User::where('name','like',"%".$name."%")->get('id');
      $user_array =array();
      foreach($users_by_name as $user){
        $user_array[] = $user['id'];
      }
      $data = Supports::WhereIn('user_id',$user_array)->with('Messages')->get();
      return response()->json($data, 200);
    } catch (\Exception $e) {
      $result['errors'] = $e->getMessage();
      }
    return response()->json($result, 200);
  }
  /**
   *  API TO GET ALL SUPPORT DATA BY STATUS
   *  */
  public function searchSupportByStatus(Request $request)
  {
    try {
      $status = $request->input('status');
      $data = Supports::where('status',$status)->with('Messages')->get();
      return response()->json($data, 200);
    } catch (\Exception $e) {
      $result['errors'] = $e->getMessage();
      }
    return response()->json($result, 200);
  }
}
