<?php

namespace RBooks\Services;

use RBooks\Repositories\TranslateOneRepository;
use RBooks\Repositories\ProcessTaskRepository;
use RBooks\Repositories\DetailTaskRepository;

use \Auth;
use DB;

class JuridicalOneService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(TranslateOneRepository::class);
    }

    public function create($request)
    {
        // Start transaction!
        DB::beginTransaction();

        try {
            $data = [
                'module_id' => 17,
                'division_id' => 9,
                'module_type' => 1,
                'taskname' => $request->taskname,
                'tasktype'=> $request->tasktype,
                'project'=> $request->project,
                'status'=> 1,
                'status_child' => 0,
                'progress'=> 0,
                'fromdate'=> $request->fromdate,
                'todate'=> $request->todate,
                'numday'=> $request->numday,
                'priority'=> 1,
                'description'=> $request->description,
                'initialization_user_id'=>  Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id
            ];

            $task = $this->repository->create($data);
        } catch(ValidationException $e) {
            // Rollback and then redirect
            // back to form with errors
            DB::rollback();
            return Redirect::to('/form')
                ->withErrors( $e->getErrors() )
                ->withInput();
        } catch(\Exception $e) {
            DB::rollback();
            throw $e;
        }

        try {
            app(TaskOneService::class)->processTasks($task);
        } catch(ValidationException $e) {
            // Rollback and then redirect
            // back to form with errors
            DB::rollback();
            return Redirect::to('/form')
                ->withErrors( $e->getErrors() )
                ->withInput();
            } catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        // If we reach here, then
        // data is valid and working.
        // Commit the queries!
        DB::commit();

        return $task;
    }

    public function update($request, $id)
    {
        $juridical = $this->repository->find($id);
        $data = [
            'taskname' => $request->taskname,
            'tasktype'=> $request->tasktype,
            'project'=> $request->project,
            'fromdate'=> $request->fromdate,
            'todate'=> $request->todate,
            'numday'=> $request->numday,
            'priority'=> 1,
            'description'=> $request->description,
            'updated_user_id' => Auth::user()->id
        ];

        $juridical = $this->repository->update($data, $id);
        return $juridical;
    }
}
