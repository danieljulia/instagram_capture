<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {

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
		
		

	}

	

	public function photos($id)
	{

		$set=$this->instagram_model->set_get($id);
		$options=array(
			'id'=>$id,
			'set'=>$set,
			'photos'=>$this->instagram_model->set_get_photos($id));

		$this->load->view('export/photos',$options);
		//show form 

	}

		public function photos_geo($id)
	{

		$set=$this->instagram_model->set_get($id);
		$options=array(
			'id'=>$id,
			'set'=>$set,
			'photos'=>$this->instagram_model->set_get_photos($id));

		$this->load->view('export/photos_geo',$options);
		//show form 

	}


		public function users($id)
	{
		$set=$this->instagram_model->set_get($id);
		$options=array(
			'id'=>$id,
			'set'=>$set,
			'users'=>$this->instagram_model->users_get($id),
			
			);

		$this->load->view('export/users',$options);
		

	}


		public function graph($id)
	{

		$set=$this->instagram_model->set_get($id);
		$options=array(
			'id'=>$id,
			'set'=>$set,
			'users'=>$this->instagram_model->users_get($id),
			'user_2_user'=>$this->instagram_model->user_2_user_get($id),
			);

		$this->load->view('export/graph',$options);
		//show form 

	}


}
