<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sets extends CI_Controller {

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
		
		//show list
		$res=$this->instagram->set_get_all();
		
		$this->load->view('sets_list',array("sets"=>$res));


	}

	public function add()
	{
		if($this->input->post("name")!=""){
			
			print "ei.. capturant..".$this->input->post("name");
			return;
		}
		$this->load->view('sets_add');
		//show form 

	}

	public function view($id)
	{
		
		print "viewing set ".$id;
		//show form 

	}

}
