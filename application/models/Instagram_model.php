<?php

/**
https://instagram.com/developer/endpoints/

*/


class Instagram_model extends CI_Model {

      /* public $title;
        public $content;
        public $date;
*/
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        public function get_tags_media_recent($tag="")
        {
               if($tag=="") return;
               $uri="https://api.instagram.com/v1/tags/".$tag."/media/recent?count=33&client_id=".$this->config->item('instagram_key');
               $res=file_get_contents($uri);
                $data = json_decode( $res ); // stdClass object
                return $data;

        }

   

}