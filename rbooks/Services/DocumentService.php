<?php

namespace RBooks\Services;

use RBooks\Repositories\DocumentRepository;

use \Auth;
use DB;

class DocumentService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(DocumentRepository::class);
    }

    public function create($request)
    {
        $file = $request->file('filename');
        $file_name = $file->getClientOriginalName();
        $file->move(public_path('document/'), $file_name);

        $data = [
            'name' => $request->name,
            'filename' => $file_name,
            'note'=> $request->note,
            'created_user_id' => Auth::user()->id,
            'updated_user_id' => Auth::user()->id
        ];
        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $document = $this->repository->find($id);
        if ($request->filename == null) {
            $data = [
                'name' => $request->name,
                'note'=> $request->note,
                'updated_user_id' => Auth::user()->id
            ];
            return $this->repository->update($data, $id);
        } else {
            $file_path = public_path('document/'  . $document->filename);

            if (file_exists($file_path)) {
                unlink($file_path);

                $file = $request->file('filename');
                $file_name = $file->getClientOriginalName();
                $file->move(public_path('document/'), $file_name);

                $data = [
                    'name' => $request->name,
                    'note'=> $request->note,
                    'filename' => $file_name,
                    'updated_user_id' => Auth::user()->id
                ];
                return $this->repository->update($data, $id);
                
            } else {
                $file = $request->file('filename');
                $file_name = $file->getClientOriginalName();
                $file->move(public_path('document/'), $file_name);

                $data = [
                    'name' => $request->name,
                    'filename' => $file_name,
                    'note'=> $request->note,
                    'updated_user_id' => Auth::user()->id
                ];
                return $this->repository->update($data, $id);
            }
        }
    }
}
