<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
    	$this->load->helper('url');
    	$this->load->library('grocery_CRUD');
	}


	public function index()
	{
		
		$this->load->view('parse');
	}

	public function dash()
	{
		
		$this->load->view('admin/dash');
	}

	public function timeline($set_id=0)
	{
		$options=array();

		if($set_id==0){
			$options['sets']=$this->instagram_model->set_get_all();
			
		}
$options['set_id']=$set_id;

		$this->load->view('admin/timeline',$options);
	}


	public function map($set_id=0)
	{
			$options=array();

		//if($set_id==0){
			$options['sets']=$this->instagram_model->set_get_all();
			
		//}
		$options['set_id']=$set_id;

		$options['output']->css_files[]="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css";
		$options['output']->js_files[]="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js";
		$options['output']->js_files[]=site_url('')."assets/js/leaflet-heat.js";


		$this->load->view('admin/map',$options);
	}

	public function export($set_id=0)
	{
			$options=array();

		if($set_id==0){
			$options['sets']=$this->instagram_model->set_get_all();
			
		}
		$options['set_id']=$set_id;

		$this->load->view('admin/export',$options);
	}


	public function users($set_id=0)
	{
	

		$options=array();




		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('flexigrid'); //datatables? is client
			$crud->unset_add();
			$crud->unset_edit();

			$crud->set_table('user');
			$crud->set_subject('Users');
			//$crud->where('lat','2');
			//$crud->limit(5);
			//$crud->required_fields('city');
			//$crud->columns('city','country','phone','addressLine1','postalCode');
			if($set_id!=0) $crud->where('set_id',$set_id);
			$options['output'] = $crud->render();


			if($set_id==0){
				
				
			}else{
				
			}
			$options['sets']=$this->instagram_model->set_get_all();
			$options['set_id']=$set_id;


			$this->load->view('users',$options);

			

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	
	}


}
