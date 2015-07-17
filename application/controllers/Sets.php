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
		$res=$this->instagram_model->set_get_all();
		
		$this->load->view('sets/list',array("sets"=>$res));


	}

	public function add()
	{

		$options=array();

		if($this->input->post("name")!=""){
			
			$id=$this->instagram_model->set_add(
				$this->input->post("name")
			);
			 redirect('/sets/config/'.$id, 'refresh');
				   return;

			
				

		}
		$this->load->view('sets/add',$options);
		//show form 

	}

	public function config($id)
	{
		$set=$this->instagram_model->set_get($id);

		$options=array(
			'id'=>$id,
			'set'=>$set,
			'photos'=>$this->instagram_model->set_get_photos($id));

	

		$this->load->view('sets/config',$options);
		//show form 

	}

	public function view($id)
	{
		$set=$this->instagram_model->set_get($id);

		$options=array(
			'id'=>$id,
			'set'=>$set,
			'photos'=>$this->instagram_model->set_get_photos($id));

		

		$this->load->view('sets/view',$options);
		//show form 

	}



	public function parse($id)
	{
		$options=array(
			'set'=>$this->instagram_model->set_get($id)
			);

		$this->load->view('sets/parse',$options);
		//show form 

	}

		public function export($id)
	{

		$set=$this->instagram_model->set_get($id);
		$options=array(
			'id'=>$id,
			'set'=>$set,
			'photos'=>$this->instagram_model->set_get_photos($id));

		$this->load->view('sets/export',$options);
		//show form 

	}


}
