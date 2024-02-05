<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Auth;
use Modules\Users\Entities\People;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        //dd(Auth::user()->roles[0]->name);
    if (request()->ajax()) {
        $users=User::with('roles')->select('id','name','email')->orderBy('id','ASC')->get();
            return DataTables::of($users)
                ->addColumn('action', function ($row) {
                    $action='';

                if(Auth::user()->hasRole('super-admin') AND $row->hasRole('super-admin')){
                $action.='<a class="btn btn-primary btn-sm" href="'.url('users/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';

                }
                elseif($row->hasRole('super-admin'))
                {
                    return '';
                }
                    else{
                if(Auth::user()->can('users.edit')){
                $action.='<a class="btn btn-primary btn-sm" href="'.url('admin/users/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
                }
                if(Auth::user()->can('users.delete')){
                $action.='<a class="btn btn-danger btn-sm" href="'.url('admin/users/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
                    }
                }
                return $action;
                })
                ->addColumn('role', function ($row) {
                    return $row->roles[0]->name;
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('email', function ($row) {
                    return $row->email;
                })
                ->removeColumn('id')
                ->rawColumns(['action','role'])
                ->make(true);
    }


        return view('users::index');    
    }



    public function people()
    {
        //dd(Auth::user()->roles[0]->name);
    if (request()->ajax()) {
        $users=People::select('phone','otp')->orderBy('id','ASC')->get();
            return DataTables::of($users)
                ->addColumn('action', function ($row) {
                    $action='';

                if(Auth::user()->can('users.delete')){
                $action.='<a class="btn btn-danger btn-sm" href="'.url('users/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
                    }
              
                return $action;
                })

                ->editColumn('phone', function ($row) {
                    return $row->phone;
                })
                ->editColumn('otp', function ($row) {
                    return $row->otp;
                })
                ->rawColumns(['action'])
                ->make(true);
    }


        return view('users::people');    
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->data['role']=Role::where('name','!=','super-admin')->get();
        return view('users::create')->withData($this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $req)
    {
        $req->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required'],
        ]);

        $path=public_path('img/users');

        $user=User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'image'=>FileUpload($req->file('image'), $path)
        ]);
        if($user->assignRole($req->role)){
            return redirect('admin/users')->with('success', 'User successfully created');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['role']=Role::where('name','!=','super-admin')->get();
        $this->data['user']=User::with('roles')->find($id);
        return view('users::edit')->withData($this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role' => ['required'],
        ]);
        $path=public_path('img/users');

        $user=User::find($id);
        $user->name=$req->name;
        $user->email=$req->email;
        if($req->password!=null){
        $user->password=Hash::make($req->password);
        }
        if($req->file('image')!=null){
        $user->image=FileUpload($req->file('image'), $path);
        }
        $user->save();
        $user->roles()->detach();
        if($user->assignRole($req->role)){
            return redirect('admin/users')->with('success', 'User successfully Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
       $user=User::find($id);
       $user->roles()->detach();
        User::find($id)->delete();
        return redirect('admin/users')->with('success','User successfully deleted');

    }
    
    
    public function register(Request $req){

    
    $api_key=Settings()->sms_api;
    $api_sec=Settings()->sms_api_secret;
    
    $code=rand ( 1000 , 9999 );
    
    $phone=$req->phone;
    
    if($phone==null){
         return response()->json(['success'=>false]);
    }
    
    if(substr( $phone, 0, 2) !== "88"){
        $phone="88".$phone;
    }
    
    $people=People::firstOrCreate(['phone'=>$phone]);
    
    $people->phone=$phone;
    $people->otp=$code;
    
    if($people->save()){
    $post = [
        'to'   => $phone,
        'text'=>"Your ".Settings()->portal_name." OTP is ".$code." Don't share with anyone for security reasons",
    ];
   
    
    $header= array(                                                              
    'Content-Type: application/x-www-form-urlencoded',                         
    "Accept: application/json",
    
    ); 
        
      $curl_handle=curl_init();
      curl_setopt($curl_handle,CURLOPT_URL,'https://brain.sendlime.com/sms');
      curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
      curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
      curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $header);  
      curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST,'POST');
      curl_setopt($curl_handle, CURLOPT_USERPWD, $api_key . ":" . $api_sec);
     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER,false);
     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST,false);
    
      curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($post));
      $buffer = curl_exec($curl_handle);
      curl_close($curl_handle);
      
      return $buffer;
    }
    else{
        return response()->json(['success'=>false]);
    }
  
  
    }
    
    public function verify(Request $req){
        
        $phone=$req->phone;
        
        if($phone==null){
             return response()->json(['success'=>false]);
        }
        
        if(substr( $phone, 0, 2) !== "88"){
            $phone="88".$phone;
        }
        
      $people=People::where('phone',$phone)->where('otp',$req->otp)->first();
      
      if($people!=null){
           return response()->json(['success'=>true]);
      }
      else{
           return response()->json(['success'=>false]);
      }
      
      
    }
}
