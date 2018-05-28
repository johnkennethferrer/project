<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use DB;
use DateTime;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        //
    }

    public function attendance_monitor() {
        return view('monitor.index');
    }

    public function timeInOut(Request $request) {

        //get datetime now
        $dt = new DateTime();
        $date = $dt->format('Y-m-d');
        $time = $dt->format('H:m:s');

        $datetime = $dt->format('Y-m-d H:m:s');

        //if employee exist

        $emp_exist = DB::table('employees')
                        ->where('id', $request->input('employeeId'))
                        ->get()
                        ->first();
        if ($emp_exist) { // employee exist
            
            //check if employee have a time in
            $emp_log = DB::table('logs')
                        ->where('employee_id', $request->input('employeeId'))
                        ->get()
                        ->first();
            
            if ($emp_log) { // have a time in
                return "1";   
            }
            else { // no time in / TIME in starts here
                
                $emp_time_in = DB::table('logs')->insert([
                                        'employee_id' => $request->input('employeeId'),
                                        'time_in' => $datetime
                                    ]);

                if ($emp_time_in) {

                    $employee = DB::table('employees')
                                ->where('id', $request->input('employeeId'))
                                ->get()
                                ->first();
                     return view('monitor.index', ['employee'=>$employee]);
                }


            }

        }
        else { // employee not exist
            return back()->withInput()->with('errors', 'Employee not found.');
        }

        // if ($request->input('val_in_out') == 1) {
        //     return "1";
        // }
        // else {
        //     return "2";
        // }
    }
}
