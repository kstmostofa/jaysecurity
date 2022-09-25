<?php

namespace App\Exports;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = Employee::get();
// dd($data);
        foreach ($data as $k => $employees) {

            $data[$k]["branch_id"] = !empty($employees->branch) ? $employees->branch->name : '-';
            $data[$k]["company_client_id"] = !empty($employees->company_client_id) ? $employees->company->name : '-';
            $data[$k]["company_client_unit_id"] = !empty($employees->company_client_unit_id) ? $employees->unit->name : '-';
            $data[$k]["department_id"] = !empty($employees->department) ? $employees->department->name : '-';
            $data[$k]["designation_id"] = !empty($employees->designation) ? $employees->designation->name : '-';
            $data[$k]["salary_type"] = !empty($employees->salary_type) ? $employees->salaryType->name : '-';
            $data[$k]["salary"] = Employee::employee_salary($employees->salary);
            $data[$k]["created_by"] = Employee::login_user($employees->created_by);
            unset($employees->id, $employees->user_id, $employees->documents, $employees->tax_payer_id, $employees->is_active, $employees->created_at, $employees->updated_at);
        }
// dd($employees);
        return $data;
    }

    public function headings(): array
    {
        return [
            "Name",
            "Adhar Card No",
            "Date Of Birth",
            "Gender",
            "Phone",
            "Address",
            "Email",
            "Password",
            "Employee ID",
            "Branch",
            "Company",
            "Company Unit",
            "Department",
            "Designation",
            "Date Of Joining",
            "Account Holder Name",
            "Account Number",
            "Bank Name",
            "Bank IFSC Code",
            "Branch Location",
            "Salary Type",
            "Salary",
            "Created By",
            "Role",
            "Random Password",
            "Note",
            "Status"
        ];
    }
}
