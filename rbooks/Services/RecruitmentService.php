<?php

namespace RBooks\Services;

use RBooks\Repositories\RecruitmentRepository;
use \Auth;
use \DB;
use RBooks\Models\Job_description;
use RBooks\Models\Recruitment;

class RecruitmentService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(RecruitmentRepository::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Recruitment
     */
    public function create($request)
    {


        $data = [
            'title' => $request->title,
            'vacancies' => $request->vacancies,
            'quantity' => $request->quantity,
            'application_deadline' =>  $request->application_deadline,
            'status' => $request->status,
        ];
        Recruitment::create($data);
        $recruitment = Recruitment::latest('id')->first();
        $job_description = new Job_description();
        $job_description->introduction = $request->introduction;
        $job_description->benefit = $request->benefit;
        $job_description->address = $request->address;
        $job_description->salary = $request->salary;
        $job_description->work_time = $request->work_time;
        $job_description->experience = $request->experience;
        $job_description->requirements = $request->requirements;
        $job_description->orther_requirements = $request->orther_requirements;
        $job_description->recruitment_id = $recruitment->id;
        $job_description->save();
        return $this->repository;
    }

    public function update($request, $id)
    {


        $data = [
            'title' => $request->title,
            'vacancies' => $request->vacancies,
            'quantity' => $request->quantity,
            'application_deadline' => $request->application_deadline,
            'status' => $request->status,
        ];
        $recruitment = $this->repository->update($data, $id);
        $job_description =  Job_description::where('recruitment_id', '=', $id)->first();
        $job_description->introduction = $request->introduction;
        $job_description->benefit = $request->benefit;
        $job_description->address = $request->address;
        $job_description->salary = $request->salary;
        $job_description->work_time = $request->work_time;
        $job_description->experience = $request->experience;
        $job_description->requirements = $request->requirements;
        $job_description->orther_requirements = $request->orther_requirements;
        $job_description->save();
        return $recruitment;
    }
}
