<?php
    namespace App\Http\Controllers;


    
    use App\Models\User; 
    use DB; 
    
    Class LoginController extends Controller{

        // private $request;
        
        // public function __construct(Request $request){
			
		// 	$this->request = $request;
        // }
        
        public function login(){
			return view('login.main');   
        }
        

        public function result(){

            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user = User::all();
            
           $pass = false;
			
           $user = DB::connection('mysql')
           ->select("Select * from tbluser where username = '$username'");

            
           if($user){
            foreach ($user as $name){
                if($password == $name->password ){
                    return "Welcome $username";
                }
                else{
                    return "Wrong Password";
                }   
            }  
           }
           else{
               return "Username does not Exist";
           }
           
            
        }
        
    } 