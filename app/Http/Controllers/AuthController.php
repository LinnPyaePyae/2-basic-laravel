<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        return view("auth.register");

    }

    public function store(Request $request)
    {
    //    return $request;
        $request->validate([
            "name"=>"required|min:4",
            "email"=>"required|email|unique:students,email",
            "password"=>"required|min:8",
            "password_confirmation"=>"required|same:password"
        ]);

        $verify_code = rand(100000,999999);

        //mailing step
        logger("Your Verify code is ".$verify_code);

        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->verify_code = $verify_code;
        $student->user_token = md5($verify_code);
        $student->save();

        return redirect()->route("auth.login")->with("message","Register successful");

        return $request;
    }

    public function login()
    {
        return view("auth.login");

    }

    public function check(Request $request)
    {

        $request->validate([
            "email"=>"required|email|exists:students,email",
            "password"=>"required|min:8"
        ],
        [
            "email.exists" => "email or password is wrong"
        ]
    );


                                 //column_name
        $student = Student::where("email",$request->email)->first();

                        //plaintext         $hashPassword
        if(!Hash::check($request->password,$student->password)){
            return redirect()->route("auth.login")->withErrors(["email"=>"email or password is wrong"]);
        }

        session(["auth"=>$student]);

        return redirect()->route("dashboard.home");
    }

    public function logout()
    {
        session()->forget("auth");
        return redirect()->route("auth.login");
    }

    public function passwordChange()
    {
        return view("auth.change-password");

    }

    public function passwordChanging(Request $request)
    {

        // return $request;
        $request->validate([
            "current_password"=>"required|min:8",
            "password"=>"required|confirmed",
        ]);

        //custom current_password with auth user password
        if(!Hash::check($request->current_password,session('auth')->password)){
            return redirect()->back()->withErrors(['current_password'=>'Password does not match']);
        }

        //update new password
        $student = Student::find(session('auth')->id);
        $student->password = Hash::make($request->password);
        $student->update();

        //clear auth session
        session()->forget("auth");

        return redirect()->route("auth.login");

    }

    public function verify()
    {
        return view("auth.verify");

    }

    public function verifying(Request $request)
    {
        // return $request;
        $request->validate([
            "verify_code" => "required|numeric"
        ]);

        if($request->verify_code != session('auth')->verify_code){
            return redirect()->back()->withErrors(["verify_code"=>"Incorrect verify code"]);
        }

        //update email verified at
        //get one student's record
        $student = Student::find(session('auth')->id);
        $student->email_verified_at= now();
        $student->update();

        //session email verified at
        session(["auth"=>$student]);

        return redirect()->route("dashboard.home");


    }

    public function forgot()
    {
        return view('auth.forgot');
    }

    public function checkEmail(Request $request)
    {

        $request->validate([
            "email"=>"required|email|exists:students,email"
        ]);

        $student = Student::where("email",$request->email)->first();

        $link = route("auth.newPassword",["user_token"=>$student->user_token]);

        logger("Your password reset link is ".$link);

        // return $student;
        return redirect()->route('auth.login')->with("message","email reset link has been sent");

    }


    public function newPassword()
    {
        $token = request()->user_token;
        $student = Student::where("user_token",$token)->first();
        // dd($student);

        if(is_null($student)){
            return abort(403,"You are not allowed");
        }

        //sharing data & doesn't generate url
        return view('auth.new-password',['user_token'=>$student->user_token]);


    }

    public function resetPassword(Request $request)
    {

        $request->validate([
            "user_token"=>"required|exists:students,user_token",
            "password"=>"required|min:8|confirmed"
        ],[
            "user_token.exists"=>"something went wrong"
        ]);

        $student = Student::where("user_token",$request->user_token)->first();
        $student->password = Hash::make($request->password);
        $student->user_token = md5(rand(100000,999999));
        $student->update();

        // return $request;
        return redirect()->route("auth.login")->with("message","password updated");

    }

}
