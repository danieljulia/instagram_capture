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

	public function parse($set_id=0)
	{

		print "trying to parse..\n";

		if($this->config->item('disabled')){
			print "disabled";
			return;
		}

		if($set_id==0){
			print "no set_id";
			return;
		}

		$tags=$this->Backoffice_model->tags_get($set_id);
		
		foreach($tags as $tag){
			print "parsing ".$tag."..\n";
			$this->Backoffice_model->set_status("busy",$set_id,$tag);
			$this->parse_tag($set_id,$tag);
		}
		/*
		//todo if very recent don't reparse
		$intents=$this->config->item('cron_intents');
		for($i=0;$i<$intents;$i++){ 
			$res=$this->Backoffice_model->get_status();
			if($res->status=="busy"){
				//wait until next call
				print "busy!\n";
				return;

			}
			$res=$this->Backoffice_model->get_current_set_and_tag();
			
			print_r($res);
			$this->Backoffice_model->set_status("busy",$res->set_id,$res->tag);

			$this->parse_tag($res->set_id,$res->tag);

		}
		*/



	}

	//caution! deletes all
	public function delete($set_id)
	{
		

		
		$this->db->where('set_id',$set_id);
		$this->db->delete('user');
		$this->db->where('set_id',$set_id);
		$this->db->delete('photo');
		$this->db->where('set_id',$set_id);
		$this->db->delete('user_2_user');


	}


	public function parse_tag($set_id,$tag){
		$c=0;
		$next=$this->instagram_model->get_tags_media_recent_ex($set_id,$tag);

		while( $next!=''){

			$next=$this->instagram_model->get_tags_media_recent_ex($set_id,$tag,$next);
			print "parsing...";
			$c++;
			if($c>$this->config->item('instagram_max_calls')){
				$next=''; //quit
			}
		}
		$this->instagram_model->set_updated($set_id,$tag);

		$this->Backoffice_model->set_status('free');
	}

	public function __parse($id)
	{


  		$link = $this->input->get('url');
  		if($link!=""){
  			$link=urldecode($link);
  		}

  		$set=$this->instagram->set_get($id);


  		//todo geo, 

		//print $link;
		//exit();
		//$this->load->model('Instagram_model','instagram');

		//print_r($this->instagram);

		$data=$this->instagram->get_tags_media_recent($id,$set->tag,$link);
		

		//$this->load->view('welcome_message');
	}

	public function test(){
		//$this->instagram_model->set_updated(10,'parrot');
		$this->instagram_model->test();

	}
}
