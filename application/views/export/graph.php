<?php
if(!isset($_GET['debug'])){
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="instagram_graph_set_'.$id.'.gdf"');
}
?>
nodedef>name VARCHAR,label VARCHAR
<?php
/*
s1,Site number 1
s2,Site number 2
s3,Site number 3
*/

//print_r($users);
foreach($users as $u):
	print $u['username'];
	print ",";
	print $u['username'];
	print "\n";
endforeach; 

/*
edgedef>node1 VARCHAR,node2 VARCHAR
s1,s2,pes (opcional)
s2,s3
s3,s2
s3,s1
*/
?>
edgedef>node1 VARCHAR,node2 VARCHAR
<?php
foreach($user_2_user as $u):
	print $u['from'];
	print ",";
	print $u['to'];
	print ",";
	print $u['comments']*5+$u['likes'];
	print "\n";
endforeach;