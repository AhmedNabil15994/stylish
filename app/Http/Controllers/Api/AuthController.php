<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Mail\ResetMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','reset','checkCode','socialLogin']]);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"auth"},
     *      path="/auth/register",
     *      summary="register",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Parameter(
     *         name="f_name",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="mahmoud",
     *      ),@SWG\Parameter(
     *         name="l_name",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="mohamed",
     *      ),@SWG\Parameter(
     *         name="phone",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="01208971865",
     *      ),@SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="mahmoudnada5050@gmail.com",
     *      ),@SWG\Parameter(
     *         name="device_token",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="device_token",
     *      ),
     *      @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="123456",
     *      ),
     *      @SWG\Response(response=200, description="token"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     */

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'username' => Str::slug($request->f_name.'-'.$request->l_name.'-'.rand(000,999)),
            'phone' => $request->phone,
            'email' => $request->email,
            'device_token' => $request->device_token,
            'password' => bcrypt($request->password),
        ]);

        $token = auth()->login($user);
        return $this->respondWithToken($token);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"auth"},
     *      path="/auth/login",
     *      summary="login",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="mahmoudnada5050@gmail.com",
     *      ),
     *      @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="123456",
     *      ),
     *      @SWG\Response(response=200, description="token"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function socialLogin(Request $request){
        $type_id = $request->type; 
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $accountId = $request->id;
        $device_token = $request->device_token;
        $image = $request->image;
        if ($type_id == 1) {
            $column_id = 'facebook_id';
            $column_img = 'facebook_img';
            $type_text = 'facebook';
        }elseif ($type_id == 2) {
            $column_id = 'google_id';
            $column_img = 'google_img';
            $type_text = 'google';
        }elseif ($type_id == 3) {
            $column_id = 'twitter_id';
            $column_img = 'twitter_img';
            $type_text = 'twitter';
        }

        if(empty($email)){
            $email = $accountId.'@'.$type_text.'.com';
        }

        $userObj = User::where('email',$email)->orWhere($column_id,$accountId)->first();

        if ($userObj) {
            if($accountId != ''){
                $userObj->$column_id  = $accountId;
            }
            $userObj->$column_img = $image;
            $userObj->device_token = $device_token;
            $userObj->save();
            $password = $userObj->password;
        } else {
            $name_arr = explode(' ', $name, 2);
            $password = \Hash::make('social-password');
            $userObj = new User();
            $userObj->f_name = $name_arr[0];
            $userObj->l_name = isset($name_arr[1]) ? $name_arr[1] : ''; 
            $userObj->username = '';
            $userObj->phone = $phone;
            $userObj->email = $email;
            $userObj->password    = $password;
            $userObj->device_token =  $device_token;
            $userObj->code =  null;
            $userObj->status =  1;
            $userObj->$column_id  = $accountId;
            $userObj->$column_img = $image;
            $userObj->created_at = date('Y-m-d H:i:s');
            $userObj->save();
        }
        
        if (! $token = auth()->login($userObj)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     *
     * @SWG\Get(
     *      tags={"auth"},
     *      path="/auth/logout",
     *      summary="logout currently logged in user",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Response(response=200, description="Successfully logged out"),
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"auth"},
     *      path="/auth/refresh",
     *      summary="refreshes expired token",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Response(response=200, description="token"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"auth"},
     *      path="/auth/reset-password",
     *      summary="reset password",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="mahmoudnada5050@gmail.com",
     *      ),
     *      @SWG\Response(response=200, description="token"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
       $user = User::where('status',1)->where('email',$request->email)->first();
       if ($user)
       {
           $code = rand(000000,999999);
           $expire_at = Carbon::now()->addHour();
          try
          {
              Mail::to($request->email)->send(new ResetMail($code,$expire_at));
              $user->update([
                  'code'=>$code,
                  'expire_at'=>$expire_at,
              ]);
              return response()->json(['data'=>__('translate.send_successfully')],200);
          }catch (\Exception $exception)
          {
              return response()->json(['data'=>__('translate.mail_failed')],400);
          }
       }
        return response()->json(['data'=>__('translate.disActive_account')],400);
    }

    /**
     *
     * @SWG\Post(
     *      tags={"auth"},
     *      path="/auth/check-code",
     *      summary="check-code",
     *      security={
     *          {"jwt": {}}
     *      },
     *      @SWG\Parameter(
     *         name="code",
     *         in="formData",
     *         required=true,
     *         type="string",
     *         format="string",
     *      ),
     *      @SWG\Response(response=200, description="token"),
     *      @SWG\Response(response=400, description="Unauthorized"),
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkCode(Request $request)
    {
        $user = User::where('code',$request->code)->where('expire_at','>=',Carbon::now())->first();
        if ($user)
        {
            $token = auth()->login($user);
            return $this->respondWithToken($token);
        }
        return response()->json(['data'=>__('translate.wrong_code')],400);
    }
}
