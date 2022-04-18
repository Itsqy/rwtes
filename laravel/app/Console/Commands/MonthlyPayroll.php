<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Branch;
use App\Model\Payroll;
use App\Model\PayrollDetail;
use App\Model\CashbondPayroll;
use App\Model\CashbondPayrollDetail;
use App\Model\Employee;

class MonthlyPayroll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:payroll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates Payroll every 26th of Month';

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
            $start_date = date('Y-m-d', mktime(0, 0, 0, date('n') - 1, 25));
            $end_date = date('Y-m-d');
            $employees = Employee::where('branch_id', $branch_id)->get();

            $payroll = new Payroll;
            $payroll->month = date('m');
            $payroll->year = date('Y');
            $payroll->status = 0;
            $payroll->branch_id = $branch_id;
            $payroll->save();

            foreach($employees as $employee)
            {
                $payroll_detail = new PayrollDetail;
                $payroll_detail->payroll_id = $payroll->id;
                $payroll_detail->employee_id = $employee->id;
                $payroll_detail->workdays = 20;
                $payroll_detail->slr_basic = $employee->slr_basic;
                $payroll_detail->slr_transport = $employee->slr_transport;
                $payroll_detail->slr_tunjangan_makan = $employee->slr_tunjangan_makan;
                $payroll_detail->slr_cashbond = CashbondPayroll::with('cashbond_payroll_detail')
                    ->join('cashbond_payroll_detail', 'cashbond_payroll.id', '=', 'cashbond_payroll_detail.cashbond_payroll_id')
                    ->whereMonth('cashbond_payroll.date', date('m'))->where('cashbond_payroll_detail.employee_id', $employee->id)
                    ->sum('cashbond_payroll_detail.cashbond');
                $payroll_detail->slr_thr = $employee->slr_thr;
                $payroll_detail->slr_pot_deposit = $employee->slr_pot_deposit;
                $payroll_detail->save();
            }
        }
    }
}
