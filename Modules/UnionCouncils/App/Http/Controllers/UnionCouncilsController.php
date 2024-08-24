<?php

namespace Modules\UnionCouncils\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Imports\UnionCouncilsImport;
use App\Models\States;
use Modules\Cities\Entities\Cities;
use Modules\UnionCouncils\App\Models\UnionCouncils;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
class UnionCouncilsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $req=request();

         if ($req->ajax()) {

            $strt=$req->start;
            $length=$req->length;

            $union_councils=UnionCouncils::query();
            if ($req->state_id != null) {
            $union_councils->where('state_id',$req->state_id);
            }
            if ($req->city_id != null) {
            $union_councils->where('city_id',$req->city_id);
            }
            if ($req->name != null) {
            $union_councils->where('name','LIKE','%'.$req->name.'%');
            }
            $total=$union_councils->count();

           $union_councils=$union_councils->offset($strt)->limit($length)->get();

           return DataTables::of($union_councils)
           ->setOffset($strt)
           ->with([
                'recordsTotal'=>$total,
                'recordsFiltered'=>$total
           ])
           ->addColumn('action',function ($row){
               $action='';
               if(Auth::user()->can('union-councils')){
               $action.='<a class="btn btn-primary btn-sm m-1" href="'.url('/union-councils/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
            }
            if(Auth::user()->can('union-councils.delete')){
               $action.='<a class="btn btn-danger btn-sm m-1" href="'.url('/union-councils/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
           }
               return $action;
           })
           ->editColumn('state_id',function ($row)
           {
               return State($row->state_id);
           })
           ->editColumn('city_id',function ($row)
           {
               return City($row->city_id);
           })
           ->rawColumns(['action'])
           ->make(true);
        }
        $states=States::where('country_id',167)->get();
        $cities=Cities::where('country_id',167)->get();
        return view('unioncouncils::index',compact('states','cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states=States::where('country_id',167)->get();
        return view('unioncouncils::create',compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $req->validate([
            'state_id'=>'required',
            'city_id'=>'required',
            'name'=>'required|unique:union_councils|max:255'
        ]);
        DB::beginTransaction();
        try{
            UnionCouncils::create($req->except('_token'));
           DB::commit();
           return redirect('union-councils')->with('success','Union Council sccessfully created');
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
     */
    public function show($id)
    {
        return view('unioncouncils::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $union_councils=UnionCouncils::find($id);
        $states=States::where('country_id',167)->get();
        return view('unioncouncils::edit',compact('states','union_councils'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, $id)
    {
         $req->validate([
            'state_id'=>'required',
            'city_id'=>'required',
            'name' => 'required|unique:union_councils,name,'.$id
        ]);
          DB::beginTransaction();
         try{
            UnionCouncils::find($id)->update($req->except('_token'));
            DB::commit();
            return redirect('/union-councils')->with('success','Union Council sccessfully Updated');
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
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
        UnionCouncils::find($id)->delete();
        DB::commit();
         return redirect('/union-councils')->with('success','Union Council successfully deleted');
         
         } catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong with this error: '.$e->getMessage());
         }catch(Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error','Something went wrong with this error: '.$e->getMessage());
         }
    }
    /**
     * Remove the specified resource from storage.
     */

    public function import(Request $request)
    {
      return view('unioncouncils::import');
    }
        /**
     * Remove the specified resource from storage.
     */
     public function importUpload(Request $request)
    {
        
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);
       

        $file = $request->file('file');
        $array = Excel::toArray(new UnionCouncilsImport, $file);

       foreach ($array[0] as $chunk) {
            if($chunk['state_id']==null || $chunk['city_id']==null || $chunk['name']==null){
            }
            UnionCouncils::updateOrCreate($chunk);
        }
         return redirect('/union-councils')->with('success','Union Council successfully Imported');

         }  
}
