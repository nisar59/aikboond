<?php

namespace Modules\Donors\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Countries;
use App\Models\States;
use Modules\Cities\Entities\Cities;
use Modules\Areas\Entities\Areas;
use Modules\AddressesAndTowns\Entities\AddressesAndTowns;
use Modules\Donors\Entities\Donor;
use App\Models\OTP;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Carbon\Carbon;
class DonorsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
       $req=request();

         if ($req->ajax()) {

            $strt=$req->start;
            $length=$req->length;

            $donors=Donor::query();
             if ($req->name != null) {
            $donors->where('name', $req->name);
            }
             if ($req->state_id != null) {
            $donors->where('state_id', $req->state_id);
            }
             if ($req->city_id != null) {
            $donors->where('city_id', $req->city_id);
            }
            if ($req->area_id != null) {
            $donors->where('area_id', $req->area_id);
            }
            if ($req->address != null) {
            $donors->where('address', $req->address);
            } 
            if ($req->contact_number != null) {
            $donors->where('contact_no','LIKE','%'.$req->contact_number.'%');
            }
            if ($req->last_donate_date != null) {
            $donors->where('last_donate_date',$req->last_donate_date);
            }
            $total=$donors->count();

           $donors=$donors->offset($strt)->limit($length)->get();

           return DataTables::of($donors)
           ->setOffset($strt)
           ->with([
                'recordsTotal'=>$total,
                'recordsFiltered'=>$total
           ])
           ->addColumn('action',function ($row){
               $action='';
               if(Auth::user()->can('donors.edit')){
               $action.='<a class="btn btn-primary btn-sm m-1" href="'.url('/donors/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
            }
            if(Auth::user()->can('donors.delete')){
               $action.='<a class="btn btn-danger btn-sm m-1" href="'.url('/donors/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
           }
               return $action;
           })
           ->editColumn('country_id',function ($row)
           {
               return Country($row->country_id);
           })
          ->editColumn('state_id',function ($row)
           {
               return State($row->state_id);
           })
          ->editColumn('city_id',function ($row)
           {
               return City($row->city_id);
           })
          ->editColumn('area_id',function ($row)
           {
               return Area($row->area_id);
           })
          ->editColumn('town',function ($row)
           {
               return Address($row->town);
           })
           ->editColumn('last_donate_date',function($row)
             {
                 return Carbon::parse($row->last_donate_date)->format('d-m-Y');
             })
            ->addColumn('image', function ($row) {                    
                    $path=public_path('images');
                    $url=url('images');
                    $img=$url.'/images.png';
                    if(file_exists($path.'/donors/'.$row->image) AND $row->image!=null){
                    $img=$url.'/donors/'.$row->image;
                    }

                    return '<img src="'.$img.'" height="50" width="50">';
                })
           ->rawColumns(['action','image'])
           ->make(true);
        }
         $states=States::where('country_id',167)->get();
         $cities=Cities::where('country_id',167)->get();
         $areas=Areas::where('country_id',167)->get();
        return view('donors::index',compact('states','cities','areas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $states=States::where('country_id',167)->get();
        return view('donors::create',compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $req)
    {

        $req->validate([
            'name'=>'required',
            'age'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'area_id'=>'required',
            'address'=>'required',
            'town'=>'required',
            'blood_group'=>'required',
            'contact_no'=>'required',
        ]);
            DB::beginTransaction();
         try{
                $inputs=$req->except('_token');
                 $path=public_path('images/donors/');
                 $inputs=$req->except('_token');
                 if($req->image!=null){
                 $inputs['image']=FileUpload($req->image, $path);
                }
                $count=OTP::where(['otp'=>$req->otp, 'phone_number'=>$req->contact_no])->orderBy('id', 'DESC')->first();
                if ($count==null) {
                       $message="Your given otp is not matched";
                       return redirect()->back()->withInput()->with('success',$message);
                }
            Donor::create($inputs);
            DB::commit();
            return redirect('/donors')->with('success','Donor sccessfully created');
         }catch(Exception $ex){
            DB::rollback();
         return redirect()->back()->with('error','Something went wrong with this error: '.$ex->getMessage());
        }catch(Throwable $ex){
            DB::rollback();
        return redirect()->back()->with('error','Something went wrong with this error: '.$ex->getMessage());
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('donors::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
       
        $donor=Donor::find($id);
        $states=States::where('country_id',167)->get();
        return view('donors::edit',compact('donor','states'));
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
            'name'=>'required',
            'age'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'area_id'=>'required',
            'town'=>'required',
            'address'=>'required',
            'blood_group'=>'required',
            'contact_no'=>'required',
            'last_donate_date'=>'required',
        ]);
            DB::beginTransaction();
         try{
             $inputs=$req->except('_token');
             $path=public_path('images/donors/');
                 if($req->image!=null){
                 $inputs['image']=FileUpload($req->image, $path);
                }
                $count=OTP::where(['otp'=>$req->otp, 'phone_number'=>$req->contact_no])->orderBy('id', 'DESC')->first();
                if ($count==null) {
                       $message="Your given otp is not matched";
                       return redirect()->back()->withInput()->with('success',$message);
                }
            Donor::find($id)->update($inputs);
            DB::commit();
            return redirect('/donors')->with('success','Donor sccessfully Updated');
         }catch(Exception $ex){
            DB::rollback();
         return redirect()->back()->with('error','Something went wrong with this error: '.$ex->getMessage());
        }catch(Throwable $ex){
            DB::rollback();
        return redirect()->back()->with('error','Something went wrong with this error: '.$ex->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
         DB::beginTransaction();
        try{
        Donor::find($id)->delete();
        DB::commit();
         return redirect('/donors')->with('success','Blood Donor successfully deleted');
         
         } catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong with this error: '.$e->getMessage());
         }catch(Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong with this error: '.$e->getMessage());
         }   
    }
  
    
    
}