<?php

final class EventController extends BaseController {

	public function index() {
		$modelObj = FactoryModel::getInstance("EventModel");
		$imei = $_GET['imei'];
		$list = $modelObj->fetchAll($imei);
		include VIEW_PATH . "event.html";
	}

	public function add() {

		$data = array();
		$header = $this->getHeader();
		$data['platform'] = $header['clients'];
		$data['version'] = $header['version'];
		$data['name'] = $_POST['name'];
		$data['imei'] = $header['imei'];
		$modelObj = FactoryModel::getInstance("EventModel");
		if ($modelObj->insert($data)) {
			echo "成功";
		} else {
			echo "失败";
		}
	}

	private function getHeader() {
		$temp = getallheaders()['user-agent'];
		$userAgent = explode(" ", $temp);
		$header = array();
		foreach ($userAgent as $key => $value) {
			$item = explode('/', $value);
			$header[$item[0]] = $item[1];
		}
		return $header;
	}

}