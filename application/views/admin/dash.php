<?php
$this->load->view('header');
?>


<div id="angular-container" ng-app="myapp" ng-controller="MyController" >
<div class="row" >
<h1>DashBoard</h1>
<p>
status:{{myData.status}} {{dots}}
</p>
<p>
set id: {{myData.set_id}}
</p>
<p>
updated:{{myData.updated}}
</p>

<p>
tag:{{myData.tag}}
</p>
<p>
last date:{{myData.photos[0].created_time*1000 | date:'H:m d/M/yyyy'}}
</div>
<div class="row">
<div class="photos" ng-repeat="p in myData.photos" >

<a target="instagram" href="{{p.link}}"><img class="thumb" title="{{p.caption}}" width="100" ng-src="{{p.photo_url}}"></a>
</div>
</div>	
</div>
	
<script>
 angular.module("myapp", [])
        .controller("MyController", function($scope, $http,$interval) {
            $scope.myData = {};
          	$scope.dots = "";

                //var responsePromise = $http.get("<?php print site_url("ajax/dash/")?>");

              
                
                $scope.callAtInterval = function() {
			       // console.log("$scope.callAtInterval - Interval occurred");
			         var  responsePromise = $http.get("<?php print site_url("ajax/dash/")?>");
			            responsePromise.success(function(data, status, headers, config) {
	                	console.log(data);
	                    $scope.myData = data;
	                });
	                responsePromise.error(function(data, status, headers, config) {
	                    alert("AJAX failed!");
	                });

			          $scope.dots+=".";
			          if($scope.dots.length>3) $scope.dots="";
			    }

			    $interval( function(){ $scope.callAtInterval(); }, 500);

            

        } );

/*
$(document).ready(function(){
	var uri='<?php print site_url("ajax/dash/")?>';
 $.getJSON(uri,function(data){

  refresh_dash(data);
   
});

});*/
</script>

<?php 
$this->load->view('footer');
?>