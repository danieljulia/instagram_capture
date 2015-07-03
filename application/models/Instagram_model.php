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

        public function get_tags_media_recent_ex($id,$tag="",$url="")
        {
              if($tag=="") return;
              $uri="https://api.instagram.com/v1/tags/".$tag."/media/recent?count=33&client_id=".$this->config->item('apiKey');
              if($url!="") $uri=$url;
              $res=file_get_contents($uri);
              $headers=$http_response_header;

              //todo extract and save limit
              /*
                X-Ratelimit-Remaining: the remaining number of calls available to your app within the 1-hour window

              X-Ratelimit-Limit: the total number of calls allowed within the 1-hour window
              */

            

              $data = json_decode( $res ); // stdClass object


             $next_url=$data->pagination->next_url;
          
            
              $count=0;
            

         

              foreach($data->data as $photo){
                if(!$this->_photo_saved($photo,$id)){
                  $count++;
                  $this->_photo_save($photo,$id); 
                }
               // print_r($photo);
                //for each comment
                //todo get all comments, calling api
                //now only the last ones
                foreach($photo->comments->data as $comment){
                  if(!$this->_user_saved($id,$comment->from)){
                    $this->_user_save($id,$comment->from);

                  }else{
                   
                  }
                   $this->_user_increment($id,$comment->from->username,'comments');
                   //graph
                   if($comment->from->username!= $photo->user->username){ 
                   $this->_user_2_user_update(
                    $id,$comment->from->username,$photo->user->username,1);
                 }

                }

                //for each like
                //todo get all likes calling api again
                foreach($photo->likes->data as $like){
                  if(!$this->_user_saved($id,$like)){
                    $this->_user_save($id,$like);

                  }else{
                   
                  }
                   $this->_user_increment($id,$like->username,'likes');
                   //graph
                    if($like->username!= $photo->user->username){ 
                   $this->_user_2_user_update(
                    $id,$like->username,$photo->user->username,0,1);
                 }
                }


              }


              if ($count==0){
                print 'I already have this photos...';
                return '';
              }

              //if date last photo is older than the window
              $last=$data->data[count($data->data)-1];
            
              $created_time=$last->created_time;
            
              print "set id: ".$id." tag: ".$tag." parsed ".$count." photos, ".$this->count_users." users\n";


        //https://api.instagram.com/v1/tags/barcelona/media/recent?count=33&client_id=128d96b790704f5db73b5a3dc706831a
              if( (time()-$last->created_time) > 60*60*$this->config->item('instagram_max_hours_back') ) {
                print "max hours back!\n";
                return '';
              }
            

             // $res=array('count'=>$count,'count_users'=>$this->count_users,'url'=>$next_url,'data'=>$dat,
              //  'headers'=>$headers);
             // print json_encode($res);
              
              return $next_url;

        }


        function set_get_all(){
          $query = $this->db->get('set');

          return $query->result_array();
        }

        function set_add($name){ //$tag,$lat,$lng,$distance
          $data=array(
             'name' => $name,
              /*'tag' => $tag,
                'lat' => $lat,
                'lng' => $lng,
                'distance' => $distance,*/
          );

          $this->db->insert('set', $data);
          return  $this->db->insert_id();
        }

        function set_updated($set_id,$tag){
            $data = array(
                'updated' => date('Y-m-d H:i:s'),
              
            );
         
            $this->db->where('set_id', $set_id);
             $this->db->where('tag', $tag);
            $res=$this->db->update('set_2_tag', $data); 
           
        }


        function set_tag_add($id,$tag){

          //if not exists do nothing
          if($this->set_tag_exists($id,$tag)){
           return $this->set_tag_get($id);
          }
          $data=array(
             'set_id' => $id,
             'tag' => $tag,
          );

          $this->db->insert('set_2_tag', $data);
          //eturn  $this->db->insert_id();
           return $this->set_tag_get($id);

        } 
         function set_tag_exists($id,$tag){
          $query = $this->db->get_where('set_2_tag', array('set_id' => $id,'tag'=>$tag));
          $res=$query->row();
          if(isset($res->id)) return true;
          return false;
        }

        function set_tag_get($id){
          $query = $this->db->get_where('set_2_tag', array('set_id' => $id));
          return $query->result_array();
        }

        function set_tag_remove($id,$tag){

          $this->db->delete('set_2_tag', array('set_id' => $id,'tag'=>$tag));

          return $this->set_tag_get($id);
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


        function users_get($id,$limit=0){
            $this->db->order_by("username", "desc");
            if($limit!=0) $this->db->limit($limit);

           $query = $this->db->get_where(
            'user', array(
            'set_id'=> $id
            ));
         
           return $query->result_array();
        }



       function user_2_user_get($id,$limit=0){
        $this->db->order_by("from", "desc");
        if($limit!=0) $this->db->limit($limit);

           $query = $this->db->get_where(
            'user_2_user', array(
            'set_id'=> $id
            ));
           
           return $query->result_array();
        }


         function get_last_photos($num){
          $this->db->limit($num);
           $this->db->order_by("id", "desc");
           $query = $this->db->get('photo');
           
           return $query->result_array();

        }




        function _photo_saved($photo,$id){
            $this->db->where('pid', $photo->id);
            $this->db->where('set_id', $id);
           $query = $this->db->get('photo');
            if ($query->num_rows() > 0){
              return true;
            }
            return false;
        }

        function _photo_save($photo,$id){

           if(!$this->_user_saved($id,$photo->user)){
                  $this->_user_save($id,$photo->user,1);
                  $this->count_users++;
            }else{
              $this->_user_increment($id,$photo->user->username,'photos');
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

        function _user_2_user_update($set_id,$from,$to,$comments=0,$likes=0){
          if(!$this->_user_2_user_exist($set_id,$from,$to)){
            $this->_user_2_user_create($set_id,$from,$to);
          }
            $this->db->where('set_id', $set_id);
            $this->db->where('from', $from);
             $this->db->where('to', $to);
             if($comments!=0)
                $this->db->set('comments', 'comments+1', FALSE);
                 if($likes!=0)
                $this->db->set('likes', 'likes+1', FALSE);
            $this->db->update('user_2_user');
        }

        function _user_2_user_exist($set_id,$from,$to){
             $query = $this->db->get_where('user_2_user', 
              array(
                'set_id' => $set_id,
                'from'=>$from,
                'to'=>$to,
                ));
            $res=$query->row();
            if(isset($res->id)) return true;
            return false;
        }

        function _user_2_user_create($set_id,$from,$to){
            $data=array(
             'set_id' => $set_id,
               'from'=>$from,
                'to'=>$to,
                'comments'=>0,
                'likes'=>0
          );

          $this->db->insert('user_2_user', $data);
        }



         function _user_saved($set_id,$user){
            $query = $this->db->get_where('user', 
              array(
                'username' => $user->username,
                'set_id' => $set_id
                ));
            if ($query->num_rows() > 0){
              return true;
            }
            return false;
        }

         function _user_save($set_id,$user,$photos=0){
            //ask for more information about the user
          
          $full_name="";
          if( isset($user->full_name)){
            $full_name=$user->full_name;

          }
          $data = array(
                 'set_id'=>$set_id,
                  'username' => $user->username,
                  'profile_picture' =>  $user->profile_picture,
                  'user_id' =>  $user->id,
                  'full_name' =>  $full_name,
                  'photos'=>$photos
          );

          $this->db->insert('user', $data);

        }

         function _user_increment($set_id,$username,$field){
            $this->db->where('username', $username);
             $this->db->where('set_id', $set_id);
            $this->db->set($field, $field.'+1', FALSE);
            $this->db->update('user');
         }


         function test(){
            $this->get_tags_media_recent_ex(10,"parrot");

         }
   

}