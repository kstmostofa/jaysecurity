<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Leave::get();

        foreach ($data as $k => $leaves) {


            $data[$k]["employee_id"]=Employee::employee_name($leaves->employee_id);
            $data[$k]["leave_type_id"]= !empty(\Auth::user()->getLeaveType($leaves->leave_type_id))?\Auth::user()->getLeaveType($leaves->leave_type_id)->title:'';
            $data[$k]["created_by"]=Employee::login_user($leaves->created_by);
            unset($leaves->created_at,$leaves->updated_at);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            "ID",
            "Employee Name",
            "Leave Type ",
            "Applied On",
            "Start Date",
            "End Date",
            "Total Leaves Days",
            "Leave Reason",
            "Remark",
            "Status",
            "Created By"
        ];
    }
}
