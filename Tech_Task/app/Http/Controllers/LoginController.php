<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App;


class LoginController
{

    //this function will create a new user into the database.
    public function create(request $re)
    {
        $re->validate([//will through an error if fields are left blank.
            'email' => 'required',
            'password' => 'required'
        ]);

        $email = $re->email;//grabs information form form.
        $pass = $re->password;

        $check_email = App\Login::where('email', $email)->get();// this is checking in the database if email already exists.

        if (count($check_email) > 0) { //this is to check duplicate email insertion.
            return redirect('/register')->with('error', 'Email exists already'); //if email is a duplicate, then alert message.

        } else {

            $login = new App\login;//accessing login class that gives us the chance to edit the database.

            //passing the data into the login table, into the corresponding column names.
            $login->email = $email;
            $login->password = $pass;

            $created = $login->save();// saving whats been inserted.


            if ($created) {
                return redirect('/')->with('success', 'Account Created Successfully');//if creation is successful then show alert and then redirect to login page.
            }
        }
    }

    public function register()
    {
        return view('/register');
    }


    //when an already exiting user tries to login this function is called.
    public function checkUser(request $re)
    {
        $re->validate([//will through an error if fields are left blank.
            'email' => 'required',
            'password' => 'required'
        ]);

        $email = $re->email;
        $pass = $re->password;

        $session = App\Login::where('email', $email)->where('password', $pass)->get();//create a session that grabs the data that matches the email and password that is inputted into the form.

        if (count($session) > 0) {
            $re->session()->put('id', $session[0]->id);//place id into a session
            $re->session()->put('email', $session[0]->email);//place email into a session
            return redirect('/transaction')->with('success', 'you have successfully login');
        } else {
            return redirect('/')->with('error', 'Email or Password does not match');// if the email and password does not match then through error.
        }
    }

    //protect function allows the users ID to be saved.
    public function protect(Request $re)
    {
        if ($re->session()->get('id') == "") {//if id is blank send back to login page
            return redirect('/');
        } else {
            $userEmail = $re->session()->get('email');// else grab email and print it to transaction page

            $capsule = array('userEmail' => $userEmail);
            return view('/transaction')->with($capsule);

        }
    }

    //this function makes sure that when the user logs out there data is deleted.
    public function logout(Request $re)
    {
        $re->session()->forget('id');
        $re->session()->forget('email');
        $re->session()->forget('tranRef');
        $re->session()->forget('amount');

        return redirect('/');

    }
}

















//old way to insert into database, I learnt a more efficient way to insert and check the database for login system.

//
//    function store(request $req){
//        $email=$req->input('email');//storing each value inputted
//        $pass=$req->input('pass');
//        $toke=$req->input('_token');
//
////        print_r($email);
////        print_r($pass);
////        print_r($toke);
//
//
//        $inquiries = DB::table('users')->where('email', '=', $email)->get();
//
//        if( count($inquiries ) == 1 )
//        {
//            return redirect()->back()->with('alert', 'Email already in use');
//        }
//        else
//        {
//            DB::insert('insert into users(id, email, password, remember_token) values(?,?,?,?)', [NULL, $email, $pass, $toke]);
//            return view('/login');
//        }
//    }
//
//    public function loginCheck(request $request){
//        $email=$request->input('email');
//        $pass=$request->input('pass');
//
//        $users = DB::table('users')->where(['email'=>$email,'password'=>$pass])->get();
//
////        print '<pre>';
////        print_r($users);
////        print '</pre>';
//        if(count($users) > 0)
//        {
//            //$userid = DB::table('users')->where('email', $email)->pluck('id');
//
//            //$request->session()->put('user_id',$users[0]->id);
//
//            return view('/transaction');
//
//        }
//        else
//        {
//            return redirect()->back()->with('alert', 'Your Email or password is incorrect, if you dont have an account please register one.');
//        }
//
//    }
//}
