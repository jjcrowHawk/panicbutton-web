<?php namespace App\Controllers;

class Login extends BaseController
{
	public function index()
	{
		if ($this->session->status == 'logged in') {
            return redirect()->to(base_url().'/alarm');
		}
		echo view('LoginView');
    }
    
    public function auth()
    {
		$idAdmin = $this->request->getPost('idAdmin');
		$kataSandi = md5($this->request->getPost('kataSandi'));
		$where = array(
			'idAdmin' => $idAdmin,
			'kataSandi' => $kataSandi
            );
        $dataAdminCount = $this->adminModel->where($where)->countAllResults();
        if ($dataAdminCount == 1) {
			$sessionData = array(
				'admin' => $idAdmin,
				'status' => 'logged in'
				);
			$this->session->set($sessionData);
			return redirect()->to(base_url().'/alarm');
		} else {
			$this->session->setFlashdata('error', 'Las credenciales ingresadas no son correctas o no existen');
			return redirect()->to(base_url().'/login');
		}
    }

    public function ubahsandi()
    {
		if ($this->session->status != 'logged in') {
            return redirect()->to(base_url().'/login');
		}
		$idAdmin = $this->request->getPost('idAdmin');
		$kataSandiLama = md5($this->request->getPost('kataSandiLama'));
		$kataSandi = md5($this->request->getPost('kataSandi'));
		$konfirmasiKataSandi = md5($this->request->getPost('konfirmasiKataSandi'));
		$where = array(
			'idAdmin' => $idAdmin,
			'kataSandi' => $kataSandiLama
		);
		$dataAdminCount = $this->adminModel->where($where)->countAllResults();
		if ($dataAdminCount == 1) {
			if ($kataSandi == $konfirmasiKataSandi) {
				$data = array('kataSandi' => $kataSandi);
				$this->adminModel->where($where)->set($data)->update();
				$this->session->setFlashdata('success', 'Contraseña cambiada con éxito.');
				return redirect()->back();
			} else {
				$this->session->setFlashdata('error', 'No se pudo cambiar la contraseña. Compruebe la nueva contraseña.');
				return redirect()->back();
			}
		} else {
			$this->session->setFlashdata('error', 'No se pudo cambiar la contraseña. Compruebe la contraseña anterior.');
			return redirect()->back();
		}
	}
	
	public function logout()
	{
		$this->session->destroy();
		return redirect()->to(base_url().'/login');
	}

	//--------------------------------------------------------------------

}
