<?php
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use Illuminate\Http\Response;
	use App\Models\User;  
	use App\Traits\ApiResponser; 
	use DB; 

	Class UserController extends Controller {
		use ApiResponser; 

		private $request;
	
		public function __construct(Request $request){
			
			$this->request = $request;
		}

		public function show(){
			$users = User::all();
			return $this->successResponse($users);   
		}

		public function add(Request $request){
			$rules = [
				'username' => 'required|max:20',
				'password' => 'required|max:20'
			];

			$this->validate($request, $rules);

			$user = User::create($request->all());

			return $this->successResponse($user, Response::HTTP_CREATED);
		}

		public function index($id){
			// $user = User::findOrFail($id);
			$user =User::where('userid', $id)->first();
			if($user){
				return $this->successResponse($user);
			}
			{
				return $this->errorResponse('User ID Does Not Exits', Response::HTTP_NOT_FOUND);
			}
			
		}

		public function update(Request $request, $id){

			$rules = [
				'username' => 'required|max:20',
				'password' => 'required|max:20'
				// 'gender' => 'required|in:Male,Female'
			];
			$this->validate($request, $rules);
			$user = user::where('userid', $id)->first();

			if($user){
				$user->fill($request->all());
				
				if($user->isClean()) {
					return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
				}
				$user->save();
				return $this->successResponse($user);
			}
			{
				return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
			}
		}

		public function delete($id){
			$user = user::where('userid', $id)->first();
			
			if($user){
				$user->delete();
				return $this->successResponse($user);
			}
			{
				return $this->errorResponse('User ID Does NOT Exists', Response::HTTP_NOT_FOUND);
			}
		}
		

		
	}
