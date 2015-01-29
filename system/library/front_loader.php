<?php
class agooFrontLoader extends Controller {

	public function install() {
	     $this->load->library('occms_layouts');
		 $this->load->model('design/layout');
		 $this->load->model('tool/image');
	  	 $this->load->library('agoo/image');
	}


}

$agooController = new agooFrontLoader($this->registry);
$agooController->install();

$agooController->load->library('agoo/loader');
$agooloader = new agooLoader($this->registry);
$this->registry->set('load', $agooloader);

$agooController->load->library('agoo/config');
$Config = $this->registry->get('config');
$this->registry->set('config_old', $Config);
$agooConfig = new agooConfig($this->registry);
$this->registry->set('config', $agooConfig);



?>