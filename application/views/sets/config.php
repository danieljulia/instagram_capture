<?php 
$this->load->view('header');
//require "../header.php";
?>

<div class="container">

<div class="row">

	<h1><?php print $set->name?></h1>


</div>

<div id="content" class="row">

<?php



//http://www.codeigniter.com/userguide3/helpers/form_helper.html
echo form_open('sets/add',array('class' => 'myform', 'role' => 'form'));


/*
$hidden = array('username' => 'Joe', 'member_id' => '234');
echo form_open('email/send', '', $hidden);
*/
?>

<div class="col-md-4">
<h2>Hashtag finder</h2>



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
  <li class="list-group-item">
  
    #craftbeer <a href=''>add</a>
  </li>
   <li class="list-group-item">
    <span class="badge">11</span>
    #cerveza <a href=''>delete</a>
  </li>
</ul>



</div>
<div class="col-md-4">
<h2>Results</h2>
<ul id="results" class="list-group">

</ul>
</div>
<div class="col-md-4">
<h2>Current hashtags</h2>
<ul class="list-group">
  <li class="list-group-item">
    <span class="badge">14</span>
    #craftbeer <a href=''>remove</a>
  </li>
   <li class="list-group-item">
   
    #cerveza <a href=''>remove</a>
  </li>
</ul>

</div>


</div> <!-- end container -->


<script>
var tags=new Array();
$('#search').on("click",function(e){
  var tag=$('#hashtag').val();
  search(tag);

});

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
      console.log(tags);

      var html="";
      $.each(tags,function(i,tag){
        if(tag.value>2){ 
          html+='<li class="list-group-item"><span class="badge">'+tag.value+'</span> #'+tag.name+' <a href="">remove</a></li>';
      }
      });

      $('#results').html(html);


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

</script>

<?php 
$this->load->view('footer');