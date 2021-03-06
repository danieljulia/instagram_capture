<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

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

	var $instagram;


	public function __construct() {        
    
    	parent::__construct();

    	//https://github.com/cosenary/Instagram-PHP-API

    	$this->instagram = new Instagram(
    		array(
		    'apiKey'      => $this->config->item('apiKey'),
		    'apiSecret'   => $this->config->item('apiKey'),
		    'apiCallback' => $this->config->item('apiCallback'),
		)

    		);


	}


	public function index()
	{
		
		print "hello";

	}

	public function search($tag)
	{
		$res=$this->instagram->getTagMedia($tag,33);
		print json_encode($res);
	}

	//add tag to set
	public function set_tag_add($id,$tag)
	{
		$res=$this->instagram_model->set_tag_add($id,$tag);
		print json_encode($res);
	}

	//remove tag
	public function set_tag_remove($id,$tag)
	{
		$res=$this->instagram_model->set_tag_remove($id,$tag);
		print json_encode($res);
	}


	//get all tags from set
	public function set_tag_get($id)
	{
		$res=$this->instagram_model->set_tag_get($id);
		print json_encode($res);
	}

	public function photos($set_id){
		
		//$set=$this->instagram_model->set_get($set_id);
	
		$photos=$this->instagram_model->set_get_photos($set_id);
		print json_encode($photos);

	}

	public function dash(){
		$res=$this->Backoffice_model->get_status();
		

		
		$d=time()-strtotime($res->updated);
		$res->d=$d;
		if( $res->set_id==0){
			$status="stopped";
		}else{
			$status="running";
		}
		$res->status=$status;

		if(isset($res->set_id)){
		
			$res->stats=$this->instagram_model->stats_get($res->set_id);
		}

		$res->photos=$this->instagram_model->get_last_photos(10);


		print json_encode($res);
	}

	public function do_parse($set_id){
		
		$res=exec('php index.php cron parse '.$set_id.' > /dev/null 2>/dev/null &');
		print json_encode($res);
	}
	public function timeline($set_id){
		$res=$this->instagram_model->export_time_days($set_id);
		print json_encode($res);
	}
}
