<?php

namespace RBooks\Services;

use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Repositories\HolidayRepository;
use RBooks\Models\Holiday;


class HolidayService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(HolidayRepository::class);
    }

    /**
     * getHoliday
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  array
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getNumworkDaySalary($month, $year)
    {
        $firstdate = $year."-".$month."-01";                    
        $firstdate_ = Carbon::parse($year."/".$month."/01");
        $lastdate = $firstdate_->endOfMonth();

        $common_conditions = [
            ["holiday", ">=", $firstdate],
            ["holiday", "<=", $lastdate->toDateString()],
        ];
        $listday = app(HolidayRepository::class)->findWhere($common_conditions);

        $numworkday_salary = 0;
        foreach($listday as $item){
            $numworkday_salary += (double)$item["salary"]; 
        }

        return $numworkday_salary;
    }          
}
