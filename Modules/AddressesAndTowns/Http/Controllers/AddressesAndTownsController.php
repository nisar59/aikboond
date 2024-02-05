<?php

namespace Modules\AddressesAndTowns\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Countries;
use App\Models\States;
use Modules\Cities\Entities\Cities;
use Modules\Areas\Entities\Areas;
use Modules\AddressesAndTowns\Entities\AddressesAndTowns;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
class AddressesAndTownsController extends Controller
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

            $addresses_and_towns=AddressesAndTowns::query();
             if ($req->state_id != null) {
            $addresses_and_towns->where('state_id', $req->state_id);
            }
            if ($req->city_id != null) {
            $addresses_and_towns->where('city_id',$req->city_id);
            }
            if ($req->area_id != null) {
            $addresses_and_towns->where('area_id',$req->area_id);
            }
            $total=$addresses_and_towns->count();

           $addresses_and_towns=$addresses_and_towns->offset($strt)->limit($length)->get();

           return DataTables::of($addresses_and_towns)
           ->setOffset($strt)
           ->with([
                'recordsTotal'=>$total,
                'recordsFiltered'=>$total
           ])
           ->addColumn('action',function ($row){
               $action='';
               if(Auth::user()->can('addresses-and-towns.edit')){
               $action.='<a class="btn btn-primary btn-sm m-1" href="'.url('/addresses-and-towns/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
            }
            if(Auth::user()->can('addresses-and-towns.delete')){
               $action.='<a class="btn btn-danger btn-sm m-1" href="'.url('/addresses-and-towns/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
           }
               return $action;
           })->editColumn('country_id',function ($row)
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
           ->rawColumns(['action'])
           ->make(true);
        }
        $states=States::where('country_id',167)->get();
        $cities=Cities::where('country_id',167)->get();
        $areas=Areas::where('country_id',167)->get();
        return view('addressesandtowns::index',compact('states','cities','areas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $states=States::where('country_id',167)->get();
        return view('addressesandtowns::create',compact('states'));
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
            'state_id'=>'required',
            'city_id'=>'required',
            'area_id'=>'required',
          ]);
            DB::beginTransaction();
         try{
            AddressesAndTowns::create($req->except('_token'));
            DB::commit();
            return redirect('addresses-and-towns')->with('success','Addresses And Town sccessfully created');
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
        return view('addressesandtowns::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $addresses_and_towns=AddressesAndTowns::find($id);
        $states=States::where('country_id',167)->get();
        $cities=Cities::where('country_id',167)->get();
        $areas=Areas::all();
        return view('addressesandtowns::edit',compact('addresses_and_towns','states','cities','areas'));
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
            'state_id'=>'required',
            'city_id'=>'required',
            'area_id'=>'required',
          ]);
            DB::beginTransaction();
         try{
            AddressesAndTowns::find($id)->update($req->except('_token'));
            DB::commit();
            return redirect('addresses-and-towns')->with('success','Addresses And Town sccessfully Updated');
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
        AddressesAndTowns::find($id)->delete();
        DB::commit();
         return redirect('addresses-and-towns')->with('success','Addresses And Town successfully deleted');
         
         } catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong with this error: '.$e->getMessage());
         }catch(Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong with this error: '.$e->getMessage());
         }
    }
}
