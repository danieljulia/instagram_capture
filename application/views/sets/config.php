<?php 
$this->load->view('header');
//require "../header.php";
?>

<div class="container">

<div class="row">

	<h1><?php print $set->name?></h1>


</div>
<div id="content" class="row">
<a id="parse" href="#" class="btn btn-primary" >Parse</a>
<a href="#" id="del" class="btn btn-warning" >Delete set and all related data</a>
<div class="show-info"></div>
</div>

<div id="content" class="row">

<?php



//http://www.codeigniter.com/userguide3/helpers/form_helper.html
//echo form_open('sets/add',array('class' => 'myform', 'role' => 'form'));


/*
$hidden = array('username' => 'Joe', 'member_id' => '234');
echo form_open('email/send', '', $hidden);
*/
?>

<div class="col-md-4">
<h2>Hashtags</h2>



<div class="input-group  input-group-lg">
  <span class="input-group-addon" id="basic-addon1">#</span>
  <input type="text" id="hashtag" class="form-control" placeholder="hashtag" aria-describedby="basic-addon1">
  <span class="input-group-btn">
        <button id="search" class="btn btn-default" type="button">Search!</button>
      </span>
</div>

<div id="info" style="display:none" class="alert alert-info" role="alert">...</div>
<?php echo form_close();?>

<ul class="list-group">

</ul>



</div>
<div class="col-md-4">
<h2>Results</h2>
<ul id="results" class="list-group">

</ul>
</div>
<div class="col-md-4">
<h2>Current hashtags</h2>
<ul class="list-group" id="current-tags">

</ul>

</div>


</div> <!-- end container -->


<script>

var tags=new Array();


  


$(document).ready(function(){
  tag_current();
  setInterval("update()",1000);
});

$('#search').on("click",function(e){
  var tag=$('#hashtag').val();
  search(tag);

});

function get(){

}

function tag_add(tag){
  var uri='<?php print site_url("ajax/set_tag_add/".$id)?>/'+tag;

 $.getJSON(uri,function(data){
    refresh_tags(data);
 });

}

function tag_remove(tag){
  var uri='<?php print site_url("ajax/set_tag_remove/".$id)?>/'+tag;
 
 $.getJSON(uri,function(data){
    refresh_tags(data);
 });
}

function tag_current(){
  
  var uri='<?php print site_url("ajax/set_tag_get/".$id)?>';

 $.getJSON(uri,function(data){
    refresh_tags(data);
 });
}

function refresh_tags(data){
  var html="";
  $.each(data,function(i,itm){
      html+='<li class="list-group-item tag" data-tag='+itm.tag+'> #'+itm.tag+' <a href="#" class="remove" >remove</a></li>';
  });
  $('#current-tags').html(html);

   $('li.tag .remove').on('click',function(e){
        var tag=$(this).parent().data('tag');
        tag_remove(tag);
        e.preventDefault();

      });


}

function search(tag){
     tags=new Array();

    $.getJSON('<?php print site_url("ajax/search")?>/'+tag,function(data){
      console.log(data);
 
      $.each(data.data,function(i,itm){
        $.each(itm.tags,function(j,tag){
          if(!tag_exist(tag)){
            tags.push({name:tag,value:1});
          }else{
            tag_increment(tag);
          }

         
        });

      });
      tags.sort(function(a,b){
        if(a.value==b.value) return 0;
        if(a.value<b.value) return 1;
        return -1;
      });
   

      var html="";
      $.each(tags,function(i,tag){
        if(tag.value>2){ 
          html+='<li class="list-group-item tag" data-tag='+tag.name+'><span class="badge">'+tag.value+'</span> #'+tag.name+' <a href="#" class="add" >add</a></li>';
      }
      });

      

      $('#results').html(html);
      $('li.tag .add').on('click',function(e){
        var tag=$(this).parent().data('tag');
        tag_add(tag);
        e.preventDefault();

      });


    });
}

function tag_exist(tag){
  for(var i=0;i<tags.length;i++){
    if(tags[i]['name']==tag) return true;
  }
  return false;
}
function tag_increment(tag){
  for(var i=0;i<tags.length;i++){
    if(tags[i]['name']==tag) tags[i]['value']++;
  }
  return false;
}

//delete button
$('#del').on("click", function(e){
  if(confirm("Are you sure you want to delete this set and all related data?")){
    
    window.location = "<?php print site_url("cron/delete/".$id)?>";
  }
});

//delete button
$('#parse').on("click", function(e){
  var uri="<?php print site_url("ajax/do_parse/".$id)?>";

$.getJSON(uri,function(data){
    console.log(data);
 });
e.preventDefault();
  
});

function update(){
   $.getJSON("<?php print site_url("ajax/dash")?>",function(data){
      //console.log(data);
      
      if(data.status!="stopped"){
        var html="parsing...";
        html=nano("parsing  set_id:{set_id} tag:{tag} photos:{stats.photos} users:{stats.users} user_2_tag:{stats.user_2_tag} user_2_user:{stats.user_2_user}",data);
        $('.show-info').html(html);
      }

   });
}
</script>

<?php 
$this->load->view('footer');
