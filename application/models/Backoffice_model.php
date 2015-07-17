<?php

/**
https://instagram.com/developer/endpoints/



delete from photo where 1; delete from user where 1

select username,photo_url,lat,lng,created_time where lat<>0

*/


class Backoffice_model extends CI_Model {




        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
  

      

         public function lock($set_id=0,$tag='')
        {
                $hash=uniqid();

                $data = array(
                        'set_id' => $set_id,
                        'tag' => $tag,
                        'status' => 'busy',
                        'started'=> time(),
                        'hash'=>$hash
                );
                $this->db->insert('status', $data);
                return $hash;

        }

        public function lockFree($hash)
        {
          $this->db->delete('status', array('hash' => $hash));
        }

         public function lockFreeAll()
        {
          $this->db->delete('status');
        }

        public function isLocked()
        { 

          $query = $this->db->get_where('status', 
              array(
                'status' => 'busy',

                ));
            $res=$query->row();
            if(isset($res->id)) return true;
            return false;
        }

   


        public function set_status($status,$set_id=0,$tag='')
        {
                $data = array(
                        'set_id' => $set_id,
                        'tag' => $tag,
                        'status' => $status,
                        'started'=> time()
                );
                $this->db->insert('status', $data);

        }

       
        

        public function get_status()
        { 
            
                //$query = $this->db->get_where('status', array('set_id' => $id));
                $this->db->order_by('updated','desc');
                $query = $this->db->get('status');

                $res= $query->row();  
                /*
                if(!isset($res)){
                    $this->set_status('free',0,'');
                    return $this->get_status();
                }*/
                return $res;
                
        }

       public function tags_get($set_id)
        { 
              //get only set with active = 1
                $this->db->order_by('updated','asc');
                $query = $this->db->get_where('set_2_tag', array('set_id' => $set_id));
                $tags=array();
               
               $res=$query->result();  
               
                foreach($res as $r){
                    $tags[]=$r->tag;
               }
               return $tags;


        }


        public function get_current_set_and_tag()

        { 

                $set_id=$this->get_current_set();

              //get only set with active = 1
                $this->db->order_by('updated','asc');
                $query = $this->db->get_where('set_2_tag', array('set_id' => $set_id));
                
               $res=$query->row();  
               return $res;


        }

        public function get_current_set()
        { 
              //get only set with active = 1
                $query = $this->db->get_where('set', array('active' => 1));
               $res=$query->row();  
               return $res->id;
        }

         public function test()
         {
                $res=$this->get_status();
                print_r($res);
                return;
                $this->set_status("busy",1,'parrot');
                /*$res=$this->get_status();
                print_r($res);
                */
                $res=$this->get_current_set_and_tag();
                print_r($res);

         }


}