<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::check()) { // authentication check if session started

            $companies = DB::table('companies')->get();
            return view('companies.index', ['companies'=>$companies]);

        }
        return back()->withInput()->with('errors', 'Login first.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (Auth::check()) { // authentication check if session started

            $company = DB::table('companies')->insert([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'status' => 1,
                'user_id' => Auth::user()->id
            ]);

            if($company){
                    // return redirect()->route('companies.index', ['company'=> $company->id])
                    // ->with('success' , 'Company created successfully');
                    return back()->with('success' , 'Company created successfully');
            }
            return back()->with('errors' , 'Error creating company.');
        }
        return back()->withInput()->with('errors', 'Login first.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
        if (Auth::check()) { // authentication check if session started

            $company = DB::table('companies')->find($company->id);
            return view('companies.edit', ['company'=>$company]);

        }
        return back()->withInput()->with('errors', 'Login first.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        // 
        if (Auth::check()) { // authentication check if session started

            if ($request->input('status') == 1) {
                $status = 1;
            } else {
                $status = 2;    
            }

            $company = DB::table('companies')
                        ->where('id',$company->id)
                        ->update([
                            'name' => $request->input('name'),
                            'description' => $request->input('description'),
                            'status' => $status
                        ]);

            if ($company) {
                return back()->with('success' , 'Company updated successfully');
            }

            return back()->withInput()->with('errors', 'Error updating company');

        }
        return back()->withInput()->with('errors', 'Login first.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
        // $company = Company::find($company->id);

        // if ($company->delete()) {
        //     return back()->with('success' , 'Company deleted successfully');
        // }
        // return back()->withInput()->with('errors', 'Error creating new company');
        if (Auth::check()) { // authentication check if session started
           
            dd($company->id);
            
        }
        return back()->withInput()->with('errors', 'Login first.');
    }
}
