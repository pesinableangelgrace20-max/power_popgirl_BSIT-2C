<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use App\Models\LogModel;
use CodeIgniter\Controller;

class Profiling extends Controller
{
    public function index(){
        return view('profiling/index');
    }

    public function save(){
        $model = new ProfileModel();
        $logModel = new LogModel();

        $data = [
            'name'       => $this->request->getPost('name'),
            'birthday'   => $this->request->getPost('birthday'),
            'address'    => $this->request->getPost('address'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($model->insert($data)) {
            $logModel->addLog('Added new profile: ' . $data['name'], 'ADD');
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save profile']);
        }
    }

    public function edit($id){
        $model = new ProfileModel();
        $profile = $model->find($id);

        if ($profile) {
            return $this->response->setJSON(['data' => $profile]);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Profile not found']);
        }
    }

    public function update(){
        $model = new ProfileModel();
        $logModel = new LogModel();
        $id = $this->request->getPost('id');

        $data = [
            'name'       => $this->request->getPost('name'),
            'birthday'   => $this->request->getPost('birthday'),
            'address'    => $this->request->getPost('address'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($model->update($id, $data)) {
            $logModel->addLog('Updated profile: ' . $data['name'], 'UPDATED');
            return $this->response->setJSON(['success' => true, 'message' => 'Profile updated successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error updating profile.']);
        }
    }

    public function delete($id){
        $model = new ProfileModel();
        $logModel = new LogModel();
        $profile = $model->find($id);

        if (!$profile) {
            return $this->response->setJSON(['success' => false, 'message' => 'Profile not found.']);
        }

        if ($model->delete($id)) {
            $logModel->addLog('Deleted profile: ' . $profile['name'], 'DELETED');
            return $this->response->setJSON(['success' => true, 'message' => 'Profile deleted successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete profile.']);
        }
    }

    public function fetchRecords()
    {
        $request = service('request');
        $model = new ProfileModel();

        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;
        $searchValue = $request->getPost('search')['value'] ?? '';

        $totalRecords = $model->countAll();
        $result = $model->getRecords($start, $length, $searchValue);

        $data = [];
        $counter = $start + 1;
        foreach ($result['data'] as $row) {
            $row['row_number'] = $counter++;
            $data[] = $row;
        }

        return $this->response->setJSON([
            'draw' => intval($request->getPost('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $result['filtered'],
            'data' => $data,
        ]);
    }
}