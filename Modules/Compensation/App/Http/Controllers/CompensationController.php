<?php

namespace Modules\Compensation\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Compensation\App\Models\Compensation;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use Throwable;
Use Auth;

class CompensationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        //dd(Auth::user()->roles[0]->name);
    if (request()->ajax()) {
        $users=User::with('roles')->orderBy('id','ASC')->get();
            return DataTables::of($users)
                ->addColumn('action', function ($row) {
                    $action='';

                $action.='<a class="btn btn-primary btn-sm" href="'.url('compensation/update/'.$row->id).'"><i class="fas fa-eye"></i></a>';

                return $action;
                })
                ->addColumn('role', function ($row) {
                    $roles='';
                    foreach ($row->roles as $key => $role) {
                      $roles.='<span class="badge badge-primary">'.$role->name.'</span>';
                    }
                    return $roles;
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('email', function ($row) {
                    return $row->email;
                })

                ->editColumn('state_id', function ($row) {
                    if($row->state()->exists()){
                        return $row->state->name;
                    }
                })

                ->editColumn('city_id', function ($row) {
                    if($row->city()->exists()){
                        return $row->city->name;
                    }
                })

                ->editColumn('area_id', function ($row) {
                    if($row->area()->exists()){
                        return $row->area->name;
                    }
                })

                ->editColumn('town_id', function ($row) {
                    if($row->town()->exists()){
                        return $row->town->name;
                    }
                })

                ->removeColumn('id')
                ->rawColumns(['action','role'])
                ->make(true);
    }


        return view('compensation::index');    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('compensation::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('compensation::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('compensation::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
