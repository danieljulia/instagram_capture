<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <title>Instagram capturing tool</title>






  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css">

<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
<style type="text/css">
body
{
  font-family: Arial;
  font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
  text-decoration: underline;
}
	#content img{
		width:100px;
		float:left;
	}

  img.thumb{
    float:left;
  }
	</style>

<?php 
if(isset($output->css_files )):
foreach($output->css_files as $file): ?>
  <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; endif; ?>
<?php
if(isset($output->js_files )):
 foreach($output->js_files as $file): ?>
  <script src="<?php echo $file; ?>"></script>
<?php endforeach; endif; ?>

</head>
<body>

<div class="container">

 <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Instagram capture</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
            <?php 
              function is_active($mine){
                if(uri_string()==$mine) print "class='active' ";
              }
             ?>
              <li <?php is_active('sets')?> ><a href="<?php print site_url("sets")?>">Config</a></li>
              <li <?php is_active('admin/dash')?> ><a href="<?php print site_url("admin/dash")?>">Dash</a></li>
              <li <?php is_active('admin/users')?> ><a href="<?php print site_url("admin/users")?>">Users</a></li>
              <li <?php is_active('admin/timeline')?> ><a href="<?php print site_url("admin/timeline")?>">Timeline</a></li>
              <li <?php is_active('admin/map')?> ><a href="<?php print site_url("admin/map")?>">Map</a></li>
               <li <?php is_active('admin/export')?> ><a href="<?php print site_url("admin/export")?>">Export</a></li>

              <!--
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
              -->
            </ul>
           
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>