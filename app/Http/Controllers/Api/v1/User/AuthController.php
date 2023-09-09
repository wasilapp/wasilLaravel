<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class AuthController extends Controller
{
    

    
   public function register(Request  $request){ 
       $validator = Validator::make($request->all(),[
          'name'=>'required',
          'mobile' =>'required|unique:users',
          'password'=>'required'
       ]);

       if ($validator->fails())
       {
           return response(['errors'=>$validator->errors()->all()], 422);
       }
       if(User::where('mobile','LIKE','%'.$request->mobile)->first()){
           return response(['message'=>"Number is  registered"], 200);

       }
          $user  = new User();
       if($request->email){
           $this->validate($request,[
               'email'=>'required|email|unique:users',
               ]);
               
        $user->email = $request->get('email');
       }
    
       $user->name = $request->get('name');
       $user->mobile = $request->mobile;
       
       $user->password = Hash::make($request->get('password'));
       if(isset($request->fcm_token)){
           $user->fcm_token = $request->fcm_token;
       }
       $user->save();

       $accessToken = $user->createToken('authToken')->accessToken;
       return response(['user'=>$user,'token'=>$accessToken]);

   }


   public function login(Request $request){

       //sleep(3);
       $user = User::where('mobile', $request->email)->first();
 
        $data = $request->validate([
           'email'=>'required',
           'password'=>'required'
       ]);


       if(!User::where('mobile', $request->email)->exists()){
           return response(['errors'=>['This mobile is not found']],402);
       }

    //   if(User::where('blocked',1)->exists()){
    //       return response(['errors'=>['This user is deleted']],402);
    //   }


       if(!Hash::check($request->password, $user->password)) {
           return response(['errors'=>['Password is not correct']],402);
       }

       $accessToken = $user->createToken('authToken')->accessToken;
       if(isset($request->fcm_token)){
           $user = User::find($user->id);
           $user->fcm_token = $request->fcm_token;
           $user->save();
       }
       return response(['user'=> $user,'token'=>$accessToken],200);
   }


   public function updateProfile(Request $request){

       $user =  auth()->user();

       if(isset($request->password)){
           $user->password = Hash::make($request->password);
       }

       if(isset($request->avatar_image)){
           $url = "user_avatars/".Str::random(10).".jpg";
           $oldImage = $user->avatar_url;
           $data = base64_decode($request->avatar_image);
           Storage::disk('public')->put($url, $data);
           Storage::disk('public')->delete($oldImage);
           $user->avatar_url = $url;
       }

       if($user->save()){
           return response(['message'=>['Your setting has been changed'],'user'=>$user]);
       }else{
           return response(['errors'=>['There is something wrong']],402);
       }
   }

   public function verifyMobileNumber(Request $request){

       $validator = Validator::make($request->all(),[
           'mobile'=>'required',
       ]);

       if ($validator->fails())
       {
           return response(['errors'=>$validator->errors()->all()], 422);
       }

       if(User::where('mobile',$request->mobile)->exists()){
           return response(['errors'=>['Mobile number already exists']],402);

       }else{
           return response(['message'=>['You can verify with this mobile']]);
       }
   }

   public function mobileVerified(Request $request){

       $validator = Validator::make($request->all(),[
           'mobile'=>'required',
       ]);

       if ($validator->fails())
       {
           return response(['errors'=>$validator->errors()->all()], 422);
       }

       $user =  auth()->user();

       $user->mobile=$request->get('mobile');
       $user->mobile_verified=true;


       if($user->save()){
           return response(['message'=>['Your setting has been changed'],'user'=>$user],200);
       }else{
           return response(['errors'=>['There is something wrong']],402);
       }
   }
   
   public function delete(Request $request){

       $user =  auth()->user();
    
       if(isset($request->blocked)){
           $user->blocked = $request->blocked;
       }

       if($user->update()){
           return response(['message'=>['Your Account has been Deleted Successfully']]);
       }else{
           return response(['errors'=>['There is something wrong']],402);
       }
   }
    
}

