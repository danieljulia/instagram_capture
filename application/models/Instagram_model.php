<?php

/**
https://instagram.com/developer/endpoints/



delete from photo where 1; delete from user where 1

select username,photo_url,lat,lng,created_time where lat<>0

*/


class Instagram_model extends CI_Model {

      /* public $title;
        public $content;
        public $date;
*/
       // var $next_url;
        //var $count=0;

        var $count_users=0;
        var $set_id;



        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        public function get_tags_media_recent($id,$tag="",$url="")
        {
              if($tag=="") return;
              $uri="https://api.instagram.com/v1/tags/".$tag."/media/recent?count=33&client_id=".$this->config->item('instagram_key');
              if($url!="") $uri=$url;
              $res=file_get_contents($uri);
              $headers=$http_response_header;
              /*
                X-Ratelimit-Remaining: the remaining number of calls available to your app within the 1-hour window

              X-Ratelimit-Limit: the total number of calls allowed within the 1-hour window
              */

            

              $data = json_decode( $res ); // stdClass object


             $next_url=$data->pagination->next_url;
          
            
              $count=0;
            

              $dat=array();

              foreach($data->data as $photo){
                if(!$this->_photo_saved($photo,$id)){
                  $count++;
                  $d=$this->_photo_save($photo,$id);

                  $dat[]=array(
                    'u'=>$photo->images->low_resolution->url,
                    'l'=>$d['lat'],
                    'g'=>$d['lng'],
                    't'=>$d['created_time'],
                    'i'=>$d['link']
                    );
                }
              }

              $res=array('count'=>$count,'count_users'=>$this->count_users,'url'=>$next_url,'data'=>$dat,
                'headers'=>$headers);
              print json_encode($res);
              

        }

        function set_get_all(){
          $query = $this->db->get('set');

          return $query->result_array();
        }

        function set_add($name,$tag,$lat,$lng,$distance){
          $data=array(
             'name' => $name,
              'tag' => $tag,
                'lat' => $lat,
                'lng' => $lng,
                'distance' => $distance,
          );

          $this->db->insert('set', $data);
        }

        function set_get($id){
          $query = $this->db->get_where('set', array('id' => $id));
          return $query->row();
        }

        function set_get_photos($id){
           $query = $this->db->get_where('photo', array(
            'set_id'=> $id
            ));
           $this->db->order_by("id", "desc");
           return $query->result_array();

        }


        function _photo_saved($photo,$id){
           $query = $this->db->get_where('photo', array(
            'pid' => $photo->id,
            'set_id'=> $id
            ));
            if ($query->num_rows() > 0){
              return true;
            }
            return false;
        }

        function _photo_save($photo,$id){

           if(!$this->_user_saved($photo->user)){
                  $this->_user_save($photo->user);
                  $this->count_users++;
            }

           

            $caption="";
            if(isset($photo->caption->text)){
              $caption=$photo->caption->text;
            }

            $created_time=0;
            if(isset($photo->caption->created_time)){
              $created_time=$photo->caption->created_time;
            }
          $data = array(
                'pid' => $photo->id,
                'username' => $photo->user->username,
                'caption' => $caption,
                'photo_url' => $photo->images->standard_resolution->url,
                'link' => $photo->link,
                'created_time' => $created_time,
                'lat'=>0,
                'lng'=>0,
                'set_id'=>$id   

          );

          if($photo->location){
              if(isset($photo->location->latitude)){
                $data['lat']=$photo->location->latitude;
                $data['lng']=$photo->location->longitude;
              }         
          }

          $this->db->insert('photo', $data);
          return $data;
        }

         function _user_saved($user){
            $query = $this->db->get_where('user', array('username' => $user->username));
            if ($query->num_rows() > 0){
              return true;
            }
            return false;
        }

         function _user_save($user){
            //ask for more information about the user

          $data = array(
                  'username' => $user->username,
                  'profile_picture' =>  $user->profile_picture,
                  'user_id' =>  $user->id,
                  'full_name' =>  $user->full_name,
          );

          $this->db->insert('user', $data);

        }
   

}