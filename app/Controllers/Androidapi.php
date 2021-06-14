<?php namespace App\Controllers;

class Androidapi extends BaseController
{
	public function index()
	{
        echo "This is an API for Android application. Nothing's here. Please go back.";
	}

	public function register()
	{
		$idUser = $this->request->getPost('idUser');
		$namaUser = $this->request->getPost('namaUser');
		$noHP = $this->request->getPost('noHP');
		$kataSandi = md5($this->request->getPost('password'));
		$statusUser = "Aktif";
		$where = array('idUser' => $idUser);
		$userCount = $this->userModel->where($where)->countAllResults();
		if ($userCount < 1) {
			$data = array(
				'idUser' => $idUser,
				'namaUser' => $namaUser,
				'noHP' => $noHP,
				'kataSandi' => $kataSandi,
				'statusUser' => $statusUser
				);
			$this->userModel->insert($data);
			$response["value"] = 1;
			$response["message"] = "Registro exitoso";
			echo json_encode($response);
		} else {
			$response["value"] = 0;
			$response["message"] = "Registro fallido. Al parecer el usuario ya existe, ingrese otro usuario.";
			echo json_encode($response);
		}
	}

	public function login()
	{
		$idUser = $this->request->getPost('idUser');
		$kataSandi = md5($this->request->getPost('password'));
		$where = array(
			'idUser' => $idUser,
			'kataSandi' => $kataSandi
		);
		// print_r($this->request);
		// print_r('post:');
		// print_r($this->request->getPost());
		// print_r($where);
		// print_r($this->userModel->findAll());
		$userCount = $this->userModel->where($where)->countAllResults();
		if ($userCount == 1) {
			$where = array('idUser' => $idUser);
			$data = array('statusLogin' => 'Logged In');
			$this->userModel->where($where)->set($data)->update();
			$response["value"] = 1;
			$response["message"] = "Inicio de sesión exitoso.";
			echo json_encode($response);
		} else {
			$response["value"] = 0;
			$response["message"] = "Error al iniciar sesión";
			echo json_encode($response);
		}
	}

	public function sendhelprequest()
	{
		$idAlarm = date('YmdHis');
		$idUser = $this->request->getPost('idUser');
		$jenis = $this->request->getPost('keluhan');
		$latitude = $this->request->getPost('latitude');
		$longitude = $this->request->getPost('longitude');
		$waktu = date("Y-m-d H:i:s");
		$statusTombol = "Aktif";
		$statusAlarm = "Belum Dikonfirmasi";
		$data = array(
			'idAlarm' => $idAlarm,
			'idUser' => $idUser,
			'jenis' => $jenis,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'waktu' => $waktu,
			'statusTombol' => $statusTombol,
			'statusAlarm' => $statusAlarm
		);
		$this->alarmModel->insert($data);
		$where = array('idUser' => $idUser);
		$dataUser = $this->userModel->where($where)->first();
		$messageText = "<b>Últimas actualizaciones de alarmas</b>\n\Alerta : ".$jenis."\nNombre del alertante: ".$dataUser->namaUser."\nNúmero de teléfono : ".$dataUser->noHP."\nHora : ".$waktu."\n\nPuede obtener más información en el administrador Web.";
		$url = ""; //Telegram Bot API
		$url = $url . "&text=" . urlencode($messageText);
		$ch = curl_init();
		$optArray = array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true
		);
		curl_setopt_array($ch, $optArray);
		$result = curl_exec($ch);
		curl_close($ch);
		$response["value"] = 1;
		$response["idAlarm"] = $idAlarm;
		echo json_encode($response);
	}

	public function sendmessage()
	{
		$idAlarm = $this->request->getPost('idAlarm');
		$idUser = $this->request->getPost('idUser');
		$pesan = $this->request->getPost('pesanKhusus');
		$waktu = date("Y-m-d H:i:s");
		$statusPesan = "Unread";
		$data = array(
			'idAlarm' => $idAlarm,
			'idUser' => $idUser,
			'pesan' => $pesan,
			'waktu' => $waktu,
			'statusPesan' => $statusPesan
		);
		$this->pesanKhususModel->insert($data);
		$where = array('idUser' => $idUser);
		$dataUser = $this->userModel->where($where)->first();
		$where2 = array('idAlarm' => $idAlarm);
		$dataAlarm = $this->alarmModel->where($where2)->first();
		$messageText = "<b>Últimas actualizaciones de mensajes</b>\n\nMensaje : ".$pesan."\nNombre del alertante: ".$dataUser->namaUser."\nAlerta: ".$dataAlarm->jenis."\nHora : ".$waktu."\n\nPuede obtener más información en el administrador Web.";
		$url = ""; //Telegram Bot API
		$url = $url . "&text=" . urlencode($messageText);
		$ch = curl_init();
		$optArray = array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true
		);
		curl_setopt_array($ch, $optArray);
		$result = curl_exec($ch);
		curl_close($ch);
		$response["value"] = 1;
		echo json_encode($response);
	}

	public function getnotif()
	{
		$idAlarm = $this->request->getPost('idAlarm');
		$where = array(
			'idAlarm' => $idAlarm,
			'statusAlarm' => 'Dikonfirmasi'
		);
		$alarmCount = $this->alarmModel->where($where)->countAllResults();
		if ($alarmCount == 1) {
			$response["value"] = 1;
			$response["message"] = "Se ha confirmado la atención";
			echo json_encode($response);
		} else {
			$response["value"] = 0;
			echo json_encode($response);
		}
	}

	public function stopalarm()
	{
		$idAlarm = $this->request->getPost('idAlarm');
		$where = array('idAlarm' => $idAlarm);
		$dataAlarm = $this->alarmModel->where($where)->first();
		$alarmCount = $this->pesanKhususModel->where($where)->countAllResults();
		if ($dataAlarm->statusAlarm == 'Belum Dikonfirmasi') {
			if ($alarmCount > 0) {
				$this->pesanKhususModel->where($where)->delete();
				$this->alarmModel->where($where)->delete();
			} else {
				$this->alarmModel->where($where)->delete();
			}
		}
		$response["value"] = 1;
		echo json_encode($response);
	}

	public function showprofileinfo()
	{
		$idUser = $this->request->getPost('idUser');
		$where = array('idUser' => $idUser);
		$dataUser = $this->userModel->where($where)->first();
		$response["value"] = 1;
		$response["idUser"] = $dataUser->idUser;
		$response["namaUser"] = $dataUser->namaUser;
		$response["noHP"] = $dataUser->noHP;
		echo json_encode($response);
	}

	public function saveprofileinfo()
	{
		$idUser = $this->request->getPost('idUser');
		$idUserOld = $this->request->getPost('idUserOld');
		$namaUser = $this->request->getPost('namaUser');
		$noHP = $this->request->getPost('noHP');
		$where = array('idUser' => $idUser);
		$userCount = $this->userModel->where($where)->countAllResults();
		if ($userCount == 0 || $idUser == $idUserOld) {
			$data = array(
				'idUser' => $idUser,
				'namaUser' => $namaUser,
				'noHP' => $noHP
				);
			$where2 = array('idUser' => $idUserOld);
			$this->userModel->where($where2)->set($data)->update();
			$response["value"] = 1;
			$response["message"] = "Perfil guardado con éxito";
			echo json_encode($response);
		} else {
			$response["value"] = 0;
			$response["message"] = "No se pudo guardar la información del perfil. Ingrese otro usuario.";
			echo json_encode($response);
		}
	}

	public function changepassword()
	{
		$idUser = $this->request->getPost('idUser');
		$kataSandiLama = md5($this->request->getPost('passwordLama'));
		$kataSandi = md5($this->request->getPost('password'));
		$where = array('idUser' => $idUser);
		$dataUser = $this->userModel->where($where)->first();
		$userCount = $this->userModel->where($where)->countAllResults();
		if ($userCount == 1) {
			if ($kataSandiLama == $dataUser->kataSandi) {
				$where2 = array('idUser' => $idUser);
				$data = array('kataSandi' => $kataSandi);
				$this->userModel->where($where2)->set($data)->update();
				$response["value"] = 1;
				$response["message"] = "Contraseña guardada exitosamente.";
				echo json_encode($response);
			} else {
				$response["value"] = 0;
				$response["message"] = "No se pudo guardar la contraseña. Contraseña antigua incorrecta.";
				echo json_encode($response);
			}
		} else {
			$response["value"] = 0;
			$response["message"] = "No se pudo guardar la contraseña. Perfil no disponible.";
			echo json_encode($response);
		}
	}

	public function logout()
	{
		$idUser = $this->request->getPost('idUser');
		$where = array('idUser' => $idUser);
		$data = array('statusLogin' => 'Logged Out');
		$this->userModel->where($where)->set($data)->update();
		$response["value"] = 1;
		echo json_encode($response);
	}

	//--------------------------------------------------------------------

}
