<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use App\Csv;
use DateTime;
use Response;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

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

            $companies = DB::table('companies')
                            ->whereNull('deleted_at')
                            ->get();

            $companiestrash = DB::table('companies')
                            ->whereNotNull('deleted_at')
                            ->get();

            return view('companies.index', ['companies'=>$companies, 'companiestrash'=>$companiestrash]);

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
    public function destroy(Request $request, Company $company)
    {
        //
        $company = Company::find($company->id);

        if ($company->delete()) {
            return back()->with('success' , 'Company deleted successfully');
        }
        return back()->withInput()->with('errors', 'Error creating new company');
        
        if (Auth::check()) { // authentication check if session started
           
            dd($company->id);
            
        }
        return back()->withInput()->with('errors', 'Login first.');

    }

    public function importCsvCompanies(Request $request) {
        //parsing csv or excel file
        if (Auth::check()) { // authentication check if session started

            if ($request->hasFile('import_file')) { // if not empty the post
                $path = $request->file('import_file')->getRealPath(); // get the path of file
                $data = array_map('str_getcsv', file($path));

                if (count($data) > 0) { // if not empty the data
                    $csv_data = array_slice($data,1); // slice data ($data,1) removed the first row

                    $csv_data_file = Csv::create([ // store to the csv table db
                        'csv_filename' => $request->file('import_file')->getClientOriginalName(), // get the original name of file
                        'csv_data' => json_encode($csv_data) // save the data in json 
                    ]);

                } else { // if empty return back
                    return redirect()->back();
                }

                return view('companies.import_fieldscompanies', compact('csv_data', 'csv_data_file'));
                    
            }

        }
        return back()->withInput()->with('errors', 'Login first.');
    }

    public function processImportCompanies(Request $request) {
        //importing the parse data to table of employee
        if (Auth::check()) { // authentication check if session started

            $data = Csv::find($request->csv_data_file_id); //get the details of 
            $csv_data = json_decode($data->csv_data, true); //decode the json data
                
                foreach ($csv_data as $companies) { // loop the data

                    //insert to db employee
                    $insertCompany = Company::create([  
                        'name' =>             $companies[0],
                        'description' =>      $companies[1],
                        'status' =>           1,
                        'user_id' =>          Auth::user()->id
                    ]);

                }

                    if ($insertCompany) { // if success
                        return redirect()->route('companies.index')->with('success' , 'Import successfully.');
                    }

                    return redirect()->route('companies.index')->with('errors', 'Import failed.');

        }
        return back()->withInput()->with('errors', 'Login first.');
    }

    public function exportCsvCompanies() {
        $dt = new DateTime();
        $datetime = $dt->format('Y-m-d_HiA');

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Companies".$datetime.".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $companies = DB::table('companies')
                        ->select(DB::raw('companies.id, companies.name as cname, 
                            companies.description, companies.status, users.name as uname'))
                        ->join('users','companies.user_id','=','users.id')
                        ->whereNull('deleted_at')
                        ->get();

        $columns = array('ID','Name','Description','Status','User added');

        $callback = function() use ($companies, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($companies as $company) {

                //status convert           
                $status = "";
                if ($company->status == 1) {
                    $status = "Active";
                }
                else {
                    $status = "Inactive";
                }  

                fputcsv($file, array($company->id, $company->cname, $company->description, $status, $company->uname));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

}
