<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use App\Csv;
use Illuminate\Http\Request;
use App\Http\Requests\CsvImportRequest;
use Auth;
use DB;
use Excel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Session\Store;


class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the details of employee 
        // join to companies table
        if(Auth::check()) { // authetication checking if has session
            $employees = DB::table('employees')
                            ->select(DB::raw(
                                    'employees.id, employees.last_name, employees.first_name,
                                    employees.middle_name, employees.gender, employees.address,
                                    employees.status, companies.name'
                                    ))
                            ->join('companies', 'employees.company_id', '=', 'companies.id')
                            ->get();
            $companies = DB::table('companies')
                            ->where('status',1)
                            ->get();

            return view('employees.index', ['employees' => $employees, 'companies' => $companies]);
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

       if (Auth::check()) { // authentication check if session started
           
            // if has an image
            if ($request->hasFile('avatar')) {
                
                $filename = $request->file('avatar')->getClientOriginalName(); // get the original name
                $path = $request->file('avatar')->storeAs('public', $filename); // store the new image to the store/public

                    if ($path) { // if success of storing the directory
                        
                        // convert the result to string (1 = Male / 2 = Female)
                        if ($request->input('gender') == 1) { //if gender = 1
                            $gender = "Male"; //if male
                        } else {
                            $gender = "Female"; // if female
                        }

                        // inserting to employees db
                        $employee = DB::table('employees')
                                        ->insert([
                                            'last_name' => $request->input('lname'),
                                            'first_name' => $request->input('fname'),
                                            'middle_name' => $request->input('mname'),
                                            'gender' => $gender,
                                            'address' => $request->input('address'),
                                            'company_id' => $request->input('company_id'),
                                            'status' => 1,
                                            'avatar' => $filename,
                                            'user_id' => Auth::user()->id
                                        ]);

                        if ($employee) { // if success
                            return back()->with('success' , 'Employee created successfully');
                        }

                        return back()->withInput()->with('errors', 'Error creating new employee (Saving to the database)');

                    }

                    return back()->withInput()->with('errors', 'Error creating employee image (Storing to the directory)'); // failed to storing to directory

            } else { // if no image include

                 // convert the result to string (1 = Male / 2 = Female)
                if ($request->input('gender') == 1) { //if gender = 1
                    $gender = "Male"; //if male
                } else {
                    $gender = "Female"; // if female
                }

                // inserting to employees db
                $employee = DB::table('employees')
                                ->insert([
                                    'last_name' => $request->input('lname'),
                                    'first_name' => $request->input('fname'),
                                    'middle_name' => $request->input('mname'),
                                    'gender' => $gender,
                                    'address' => $request->input('address'),
                                    'company_id' => $request->input('company_id'),
                                    'status' => 1,
                                    'user_id' => Auth::user()->id
                                ]);

                if ($employee) { // if success
                    return back()->with('success' , 'Employee created successfully');
                }

                return back()->withInput()->with('errors', 'Error creating new employee');

            }

        }
        return back()->withInput()->with('errors', 'Login first.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //get 1 employee / join to companies for show details
        if (Auth::check()) { // authentication check if session started

            $employee = DB::table('employees')
                            ->select(DB::raw(
                                    'employees.id, employees.last_name, employees.first_name,
                                    employees.middle_name, employees.gender, employees.address,
                                    employees.status, companies.name, employees.avatar'
                                    ))
                            ->join('companies', 'employees.company_id', '=', 'companies.id')
                            ->where('employees.id', $employee->id)
                            ->get()->first();
                            
                            
            return view('employees.show',['employee'=>$employee]);

        }
        return back()->withInput()->with('errors', 'Login first.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {   
        if (Auth::check()) { // authentication check if session started

            //get 1 employee for editing
            $employee = DB::table('employees')
                        ->select(DB::raw(
                                'employees.id, employees.last_name, employees.first_name,
                                employees.middle_name, employees.gender, employees.address,
                                employees.status, companies.name, employees.company_id,
                                employees.avatar'
                                ))
                        ->join('companies', 'employees.company_id', '=', 'companies.id')
                        ->where('employees.id', $employee->id)
                        ->get()->first(); // get 1 employee

            $companies = DB::table('companies')
                        ->where('id', '!=' , $employee->company_id) 
                        ->get(); // get companies for selection of companies

            return view('employees.edit',['employee'=>$employee, 'companies' => $companies]);

        } 
        return back()->withInput()->with('errors', 'Login first.');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //update employee
        if (Auth::check()) { // authentication check if session started

            //convert the result to string value ( 1= male / 2= female)
            if ($request->input('gender') == 1) { // if  1 = male
                $gender = "Male";
            } else {
                $gender = "Female"; //else 2 = male
            }

            //convert the result to integer value ( active = 1  / inactive = 2)
            if ($request->input('status') == 1) { // if active = 1
                $status = 1;
            } else {
                $status = 2; // else inactive = 2
            }

            $employee = DB::table('employees') //update to the employee table
                        ->where('id', $employee->id)
                        ->update([
                            'last_name' => $request->input('lname'),
                            'first_name' => $request->input('fname'),
                            'middle_name' => $request->input('mname'),
                            'address' => $request->input('address'),
                            'company_id' => $request->input('company_id'),
                            'gender' => $gender,
                            'status' => $status
                        ]);

            if ($employee) { // if success return
                return back()->with('success' , 'Employee updated successfully');
            }
            
            return back()->withInput()->with('errors', 'Error updating employee');

        }
        return back()->withInput()->with('errors', 'Login first.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        // deleting employee to db
        if (Auth::check()) { // authentication check if session started

            //get the employee details
            $findEmployee = Employee::find($employee->id);

            if ($findEmployee->delete()) { // if deleted the employee from db

                //get the avatar name to unlink or delete image to the storage
                $employeeAvatar = $findEmployee->avatar;

                //match if no image stored
                if ($employeeAvatar == null) { // null

                    return redirect()->route('employees.index')->with('success' , 'Employee deleted successfully.');
                
                } else { //if not null

                    if (Storage::delete('public/'.$employeeAvatar)) { // if deleted the image from storage

                        return redirect()->route('employees.index')->with('success' , 'Employee deleted successfully.');
                    } // end if of deleting image from storage

                    return back()->withInput()->with('errors', 'Error deleting employee (Deleting the image to the directory)');
                } // end if of matching image stored
                
            } //end of if / delete employee from db

            return back()->withInput()->with('errors', 'Error deleting employee (Deleting the employee to the database)');

        }
        return back()->withInput()->with('errors', 'Login first.');

    }

    public function importCsv(Request $request) {

        //parsing csv or excel file
        if (Auth::check()) { // authentication check if session started

            if ($request->hasFile('import_file')) { // if not empty the post
                $path = $request->file('import_file')->getRealPath(); // get the path of file
                $data = array_map('str_getcsv', file($path));

                if (count($data) > 0) { // if not empty the data
                    $csv_data = array_slice($data,0);

                    $csv_data_file = Csv::create([ // store to the csv table db
                        'csv_filename' => $request->file('import_file')->getClientOriginalName(), // get the original name of file
                        'csv_data' => json_encode($data) // save the data in json 
                    ]);

                } else { // if empty return back
                    return redirect()->back();
                }

                return view('employees.import_fields', compact('csv_data', 'csv_data_file'));
                    
            }

        }
        return back()->withInput()->with('errors', 'Login first.');
    }

    public function processImport(Request $request) 
    {   
        //importing the parse data to table of employee
        if (Auth::check()) { // authentication check if session started

            $data = Csv::find($request->csv_data_file_id); //get the details of 
            $csv_data = json_decode($data->csv_data, true); //decode the json data
                
                foreach ($csv_data as $employee) { // loop the data

                    //select from users
                    $getUser = User::select('id') // get the id of user (convert)
                                    ->where('name', $employee[6])
                                    ->first();
                    $userEmployee = $getUser->id;

                    //select from company
                    $getCompany = DB::table('companies') // get the if of companies (convert)
                                    ->select('id')
                                    ->where('name', $employee[7])
                                    ->first();
                    $companyEmployee = $getCompany->id;

                    //if status active or inactive
                    if ($employee[5] == "Active") { //convert result to integer value
                        $status = 1;    
                    } else {
                        $status = 2;
                    }

                    //insert to db employee
                    $insertEmployee = Employee::create([  
                        'first_name' =>     $employee[0],
                        'last_name' =>      $employee[1],
                        'middle_name' =>    $employee[2],
                        'gender' =>         $employee[3],
                        'address' =>        $employee[4],
                        'status' =>         $status,
                        'user_id' =>        $userEmployee,
                        'company_id' =>     $companyEmployee
                    ]);

                }

                    if ($insertEmployee) { // if success
                        return redirect()->route('employees.index')->with('success' , 'Import successfully.');
                    }

                    return redirect()->route('employees.index')->with('errors', 'Import failed.');

        }
        return back()->withInput()->with('errors', 'Login first.');
    }

    public function uploadImage(Request $request) {

        //uploading image
        if (Auth::check()) { // authentication check if session started

            if ($request->hasFile('uploadImage')) { // if not empty the post file

                $employeeId = $request->input('employeeId'); // get the id of employee
                $getAvatarName = Employee::find($employeeId); // get the data of employee

                $avatarName = $getAvatarName->avatar; // get the avatar name

                    if ($avatarName == null) { // if null the avatar column on db / no existing image

                        $filename = $request->file('uploadImage')->getClientOriginalName(); // get the orignal name of image
                        $path = $request->file('uploadImage')->storeAs('public', $filename); // store the image to store/app/public

                            if ($path) { // if success of storing the image to directory
                                $fileSave = DB::table('employees') // save the name of image to the database
                                                ->where('id', $request->input('employeeId'))
                                                ->update([
                                                    'avatar' => $filename
                                                ]);

                                if ($fileSave) { // if success of saving to the database
                                    return back()->with('success' , 'Employee image updated successfully');
                                }

                                return back()->withInput()->with('errors', 'Error update employee image (Saving the image name to the database)'); // else not success of saving
                            }

                            return back()->withInput()->with('errors', 'Error update employee image (Storing the image to the directory)'); // else not success of storing to directory

                    } else { // if not null the avatar column on db / and has a existing image
                            
                        if (Storage::delete('public/'.$avatarName)) { // delete the existing image in the store folder

                            $filename = $request->file('uploadImage')->getClientOriginalName(); // get the original name
                            $path = $request->file('uploadImage')->storeAs('public', $filename); // store the new image to the store/public

                                if ($path) { // if success of storing the directory
                                    $fileSave = DB::table('employees') // update to the database the new name db
                                                    ->where('id', $request->input('employeeId'))
                                                    ->update([
                                                        'avatar' => $filename
                                                    ]);

                                    if ($fileSave) { // if success of updating new name in db
                                        return back()->with('success' , 'Employee image updated successfully');
                                    }

                                    return back()->withInput()->with('errors', 'Error update employee image (Saving the image name to the database)'); // else failed updating to db
                                }

                                return back()->withInput()->with('errors', 'Error update employee image (Storing the new image to the directory)'); // failed to storing to directory
                        }

                        return back()->withInput()->with('errors', 'Error update employee image (Deleting the existing image to the directory)'); // failed to delete existing image to directory
                    }

                
            } else {
               return "No file selected"; // if no file selected
            }

        }
        return back()->withInput()->with('errors', 'Login first.');
       
    }

}
