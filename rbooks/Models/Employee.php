<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends BaseModel
{
    use SoftDeletes;
    protected $table = "ns_profiles";
    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'id_staff', 'fullname', 'gender', 'birthday', 'maritalstatus', 'email', 'localmail', 'id_No', 'identycarddate', 'identycardplace_issue', 'hometown_id', 'people', 'phone', 'phone_other', 'address', 'temporaryaddress', 'level_id', 'status', 'position_id', 'department_id', 'division_id', 'begin_workday', 'begin_official_workday', 'account_No', 'bankname', 'beginlabordate', 'finishworkdate', 'print', 'personaltaxcode', 'salaryyear', 'salaryincome', 'user_id', 'created_user_id', 'updated_user_id',
    ];

    /**
     * User association with customer
     *
     * @return QueryBuilder
     */

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cityprovince()
    {
        return $this->belongsTo(CityProvince::class, 'hometown_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function laborContract()
    {
        return $this->hasMany(LaborContract::class, 'employee_id');
    }

    public function education()
    {
        return $this->hasMany(Education::class, 'employee_id');
    }

    public function emplperday()
    {
        return $this->hasMany(EmployeePermissionday::class, 'employee_id');
    }

    public function checkemployee()
    {
        return $this->hasMany(CheckEmployee::class, 'employee_id');
    }

    public function checkbusiness()
    {
        return $this->hasMany(CheckBusines::class, 'employee_id');
    }

    public function familyrelationships()
    {
        return $this->hasMany(FamilyRelationship::class, 'employee_id');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class, 'employee_id');
    }

    public function disciplines()
    {
        return $this->hasMany(DiscipLine::class, 'employee_id');
    }

    public function insurances()
    {
        return $this->hasMany(Insurances::class, 'employee_id');
    }

    public function payroll()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }

    public function monthinsurance()
    {
        return $this->hasMany(MonthInsurance::class, 'employee_id');
    }

    public function monthsalary()
    {
        return $this->hasMany(MonthSalary::class, 'employee_id');
    }

    public function avatar()
    {
        return $this->hasOne(ImageAvatar::class, 'employee_id');
    }

}
