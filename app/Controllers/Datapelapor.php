<?php namespace App\Controllers;

class Datapelapor extends BaseController
{
	public function index()
	{
		if ($this->session->status != 'logged in') {
            return redirect()->to(base_url().'/login');
		}
		$data['dataPelapor'] = $this->userModel->findAll();
		echo view('menu/header');
		echo view('menu/DataPelaporView', $data);
		echo view('menu/footer');
    }
    
	public function edit()
	{
		if ($this->session->status != 'logged in') {
            return redirect()->to(base_url().'/login');
		}
		$idUser = $this->request->getPost('idUser');
		$namaUser = $this->request->getPost('namaUser');
		$noHP = $this->request->getPost('noHP');
		$data = array(
			'namaUser' => $namaUser,
			'noHP' => $noHP
		);
		$where = array('idUser' => $idUser);
		$this->userModel->where($where)->set($data)->update();
		$this->session->setFlashdata('success','Datos modificados con éxito.');
		return redirect()->back();
    }
    
	public function delete($idUser)
	{
		if ($this->session->status != 'logged in') {
            return redirect()->to(base_url().'/login');
		}
		$where = array('idUser' => $idUser);
		$data['dataUser'] = $this->userModel->where($where)->first();
		$dataAlarmCount = $this->alarmModel->where($where)->countAllResults();
		$dataPesanKhususCount = $this->pesanKhususModel->where($where)->countAllResults();
		if ($data['dataUser']->statusLogin != "Logged In") {
			if ($dataAlarmCount == 0 && $dataPesanKhususCount == 0) {
				$this->userModel->where($where)->delete();
				$this->session->setFlashdata('success','Datos eliminados con éxito.');
				return redirect()->back();
			} else {
				$this->session->setFlashdata('error','No se pudieron borrar los datos.');
				return redirect()->back();
			}
		} else {
			$this->session->setFlashdata('error','No se pudieron borrar los datos. El reportero / usuario ha iniciado sesión.');
			return redirect()->back();
		}
	}

	//--------------------------------------------------------------------

}
