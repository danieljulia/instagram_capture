<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$config['disabled']=false;

$config['apiKey']=''; //your instagram key
$config['apiSecret']=''; 
$config['apiCallback']='';


//number of hours calls can go back
$config['instagram_max_hours_back']=24*28;//24*7;




/* next are optional */

//maxium recursive calls
$config['instagram_max_calls']=5000;


$config['parse_tags']=false; 

//todo
$config['parse_follows']=true; //additional call for each user to get follows and followers 