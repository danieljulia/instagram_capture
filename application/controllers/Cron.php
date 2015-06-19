<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {        
    parent::__construct();
}


	public function index()
	{
		
		print "hello";

	}

	public function cron()
	{


  		$link = $this->input->get('url');
  		if($link!=""){
  			$link=urldecode($link);
  		}
		//print $link;
		//exit();
		//$this->load->model('Instagram_model','instagram');

		//print_r($this->instagram);

		$data=$this->instagram->get_tags_media_recent($this->config->item('hashtag'),$link);
		

		//$this->load->view('welcome_message');
	}
}
