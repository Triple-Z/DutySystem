<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AbsenceValidRecord;
use Carbon\Carbon;
use App\Employee;

class AbsenceValidRecordController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function view(Request $request) {
        // $absenceRecords = AbsenceValidRecord::orderBy('year', 'desc')
        //                                     ->orderBy('month', 'desc')
        //                                     ->orderBy('day', 'desc')
        //                                     ->paginate(15);
        $absenceRecords = AbsenceValidRecord::orderBy('id')
                                            ->paginate(15);
        $employees = Employee::orderBy('work_number')->get();
        // return json_encode($absenceRecords);
        return view('leave',[
            'absenceRecords' => $absenceRecords,
            'employees' => $employees,
        ]);
    }

    // write GET/POST/PUT/DELETE method here

    // public function all_absence(Request $request) {
        // $absenceRecords = AbsenceValidRecord::orderBy('year', 'desc')
        //                                     ->orderBy('month', 'desc')
        //                                     ->orderBy('day', 'desc')
        //                                     ->paginate(15);
        
        // return json_encode($absenceRecords);

    // }

    public function search_absence(Request $request) {
        $success = true;

        // Waiting for the futher response...
    }

    public function add_absence(Request $request) {// PUT
        $success = true;

        $start_date = Carbon::parse($request->input('start_date'));
        $end_date = Carbon::parse($request->input('end_date'));

        $employeeId = $request->input('employee_id');
        $type = $request->input('type');
        $note = $request->input('note');

        if ($request->input('start_date') && $request->input('end_date')) {
        
            if ($start_date->isSameDay($end_date)) {
                $year = $start_date->year;
                $month = $start_date->month;
                $day = $start_date->day;
                AbsenceValidRecord::create([
                    'employee_id' => $employeeId,
                    'year' => $year,
                    'month' => $month,
                    'day' => $day,
                    'type' => $type,
                    'note' => $note,
                ]);
            } else {
                $temp_date = $start_date;
                $temp_end_date = $end_date->addDay();
                while (!$temp_date->isSameDay($temp_end_date)) {
                    $year = $temp_date->year;
                    $month = $temp_date->month;
                    $day = $temp_date->day;

                    AbsenceValidRecord::create([
                        'employee_id' => $employeeId,
                        'year' => $year,
                        'month' => $month,
                        'day' => $day,
                        'type' => $type,
                        'note' => $note,
                    ]);

                    $temp_date = $temp_date->addDay();
                }
            }
        } else {
            $success = false;
        }

        if ($success) {
            $request->session()->flash('flash_success', '请假记录添加成功');
        } else {
            $request->session()->flash('flash_error', '请假记录添加失败');
        }

        return redirect('leave');

    }

    public function delete_absence(Request $request) {// DELETE
        $success = true;

        $start_date = Carbon::parse($request->input('start_date'));
        $end_date = Carbon::parse($request->input('end_date'));

        $employeeId = $request->input('employeeId');
        $type = $request->input('type');

        if ($request->input('start_date') && $request->input('end_date')) {

            if ($start_date->isSameDay($end_date)) {
                $year = $start_date->year;
                $month = $start_date->month;
                $day = $start_date->day;
                
                AbsenceValidRecord::where('year', '=', $year)
                                    ->where('month', '=', $month)
                                    ->where('day', '=', $day)
                                    ->where('employee_id', '=', $employeeId)
                                    ->delete();

                echo 'Simple Delete!';
                
            } else {
                $temp_date = $start_date;
                $temp_end_date = $end_date->addDay();
                while (!$temp_date->isSameDay($temp_end_date)) {
                    $year = $temp_date->year;
                    $month = $temp_date->month;
                    $day = $temp_date->day;
                    
                    AbsenceValidRecord::where('year', '=', $year)
                                        ->where('month', '=', $month)
                                        ->where('day', '=', $day)
                                        ->where('employee_id', '=', $employeeId)
                                        ->delete();
                    
                    $temp_date = $temp_date->addDay();

                    echo 'Multi Delete!';
                }
            }
            
        } else {
            $success = false;
        }

        if ($success) {
            $request->session()->flash('flash_success', '请假记录删除成功');
        } else {
            $request->session()->flash('flash_error', '请假记录删除失败');
        }

        return redirect('leave');

    }
}
