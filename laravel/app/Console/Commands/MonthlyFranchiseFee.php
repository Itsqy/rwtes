<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Branch;
use App\Model\Revenue;
use App\Model\FranchiseFee;

class MonthlyFranchiseFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:franchisefee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates Franchise Fee every 26th of Month';

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
        $branches = Branch::pluck('branc_name', 'id');

        foreach($branches as $branch_id => $branch_name)
        {
            $start_date = date('Y-m-d', mktime(0, 0, 0, date('n') - 1, 25));
            $end_date = date('Y-m-d');     
            
            $franchise_fee = new FranchiseFee;
            $franchise_fee->branch_id = $branch_id;
            $franchise_fee->month = date('m');
            $franchise_fee->year = date('Y');
            $franchise_fee->status = 0;
            $franchise_fee->royalty_percentage = 5;
            $franchise_fee->royalty_value = (Revenue::where('branch_id', $branch_id)->whereBetween('date', [$start_date, $end_date])->sum('total')) * $franchise_fee->royalty_percentage / 100;
            $franchise_fee->save();       
        }
    }
}
