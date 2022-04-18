<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Branch;
use App\Model\Employee;
use App\Model\CashbondPayroll;
use App\Model\CashbondPayrollDetail;

class MonthlyCashbondPayroll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:cashbondpayroll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates cashbond payroll every 14th of Month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $branches = Branch::pluck('branch_name', 'id');

        foreach($branches as $branch_id => $branch_name)
        {
            $start_date = date('Y-m-d', mktime(0, 0, 0, date('n') - 1, 13));
            $end_date = date('Y-m-d');
            $employees = Employee::where('branch_id', $branch_id)->get();

            $cashbond_payroll = new CashbondPayroll;
            $cashbond_payroll->date = date('Y-m-d');
            $cashbond_payroll->status = 0;
            $cashbond_payroll->branch_id = $branch_id;
            $cashbond_payroll->save();

            foreach($employees as $employee)
            {
                $cashbond_payroll_detail = new CashbondPayrollDetail;
                $cashbond_payroll_detail->cashbond_payroll_id = $cashbond_payroll->id;
                $cashbond_payroll_detail->employee_id = $employee->id;
                $cashbond_payroll_detail->cashbond = $employee->slr_cashbond;
                $cashbond_payroll_detail->save();
            }
        }
    }
}
