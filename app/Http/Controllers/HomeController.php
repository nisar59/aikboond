<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Countries;
use App\Models\States;
use Modules\Cities\Entities\Cities;
use Modules\Areas\Entities\Areas;
use Modules\AddressesAndTowns\Entities\AddressesAndTowns;
use Throwable;
use Auth;
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function fetchStates(Request $req){
         try {
        $data['states'] =States::where("country_id", $req->country_id)->get(["name", "id"]);                          
        return response()->json($data);
        }
        catch(Exception $ex){
            $res=['success'=>false, 'error'=>'Something went wrong with this error: '.$ex->getMessage(), 'data'=>null];
             return response()->json($res);
        }catch(Throwable $ex){
            $res=['success'=>false, 'error'=>'Something went wrong with this error: '.$ex->getMessage(), 'data'=>null];
             return response()->json($res);
        }


    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function fetchCity(Request $req){
        try {
        $data['cities'] =Cities::where("state_id", $req->state_id)->get(["name", "id"]);                          
        return response()->json($data);
        }
        catch(Exception $ex){
            $res=['success'=>false, 'error'=>'Something went wrong with this error: '.$ex->getMessage(), 'data'=>null];
             return response()->json($res);
        }catch(Throwable $ex){
            $res=['success'=>false, 'error'=>'Something went wrong with this error: '.$ex->getMessage(), 'data'=>null];
             return response()->json($res);
        }
        
    }
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function fetchAreas(Request $req) {
        try{
        $data['areas'] =Areas::where("city_id", $req->city_id)->get(["name", "id"]);                          
        return response()->json($data);
    }
         catch(Exception $ex){
            $res=['success'=>false, 'error'=>'Something went wrong with this error: '.$ex->getMessage(), 'data'=>null];
             return response()->json($res);
        }catch(Throwable $ex){
            $res=['success'=>false, 'error'=>'Something went wrong with this error: '.$ex->getMessage(), 'data'=>null];
             return response()->json($res);
        }
        }

           /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function fetchAdress(Request $req){
        try{
        $data['address'] =AddressesAndTowns::where("area_id", $req->area_id)->get(["name", "id"]);                          
        return response()->json($data);
    }
         catch(Exception $ex){
            $res=['success'=>false, 'error'=>'Something went wrong with this error: '.$ex->getMessage(), 'data'=>null];
             return response()->json($res);
        }catch(Throwable $ex){
            $res=['success'=>false, 'error'=>'Something went wrong with this error: '.$ex->getMessage(), 'data'=>null];
             return response()->json($res);
        }
}


    public function sendOTP(Request $req)
    {
        try{
            dd($req->all());

        }
         catch(Exception $ex){
            $res=['success'=>false, 'error'=>'Something went wrong with this error: '.$ex->getMessage(), 'data'=>null];
             return response()->json($res);
        }catch(Throwable $ex){
            $res=['success'=>false, 'error'=>'Something went wrong with this error: '.$ex->getMessage(), 'data'=>null];
             return response()->json($res);
        }
    }



}
