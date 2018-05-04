<?php

include ('header.php');
require_once ('clogs/functions.php');

//include ('clogs/db_connect.php');

$username = null;
$table = 'projects';
$post_head = $post_content = $post_skills = null;
 //session_start();
  if($_SESSION['is_logged_in'] != 1){
    echo "<script> location.href='login.php'; </script>";
    die();
  }
    else
      $username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD']== 'POST'){

  if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['tags'])){
    
    $post_head = SQLProof($connect_link, $_POST['title']);
    $post_content = SQLProof($connect_link, $_POST['content']);
    $post_skills = SQLProof($connect_link, $_POST['tags']);
    $randID = rand(1000, 1000000);
    $post_id = preg_replace('/\s+/', '', $post_head).$randID;
    $post_id = strtolower($post_id);
    $date = date('Y-m-d');
    $user = $username;

    $sql = "INSERT INTO $db_name.$table (project_id, admin_name, project_title, details, skills, _begin)
                    VALUES ('$post_id','$username','$post_head','$post_content','$post_skills','$date')";

    $sql_result = mysqli_query($connect_link, $sql);
    if ($sql_result) {
      echo "<script> location.href='profile.php?stack=298'; </script>";
    }
    else{
      echo mysqli_error($connect_link);
      echo $sql;
    }
  }
} 
?>
<div class="container" style="margin: 0 auto;">
  <div class="row">
    <div class="col-sm-10 col-md-offset-2">
      <h1>Got a new idea? Let's work on it.</h1><br>
    </div>
    <div class="col-sm-7 col-md-7 col-md-offset-2">
      <form class="" role="form" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <div>
                <label for="">Project Title</label>
                <input class="form-control " name="title" maxlength="130" name="post_title" type="text" placeholder="Project Title">
              </div>
            </div>
            <div class="form-group">
              <div>
                <label for="">Tags</label>
<div class="ui fluid multiple search selection dropdown">
  <input name="tags" type="hidden">
  <i class="dropdown icon"></i>
  <div class="default text">Skills</div>
  <div class="menu">
    <div class="item" data-value="angular">Angular</div>
<div class="item" data-value="css">CSS</div>
<div class="item" data-value="design">Graphic Design</div>
<div class="item" data-value="ember">Ember</div>
<div class="item" data-value="html">HTML</div>
<div class="item" data-value="ia">Information Architecture</div>
<div class="item" data-value="javascript">Javascript</div>
<div class="item" data-value="mech">Mechanical Engineering</div>
<div class="item" data-value="meteor">Meteor</div>
<div class="item" data-value="node">NodeJS</div>
<div class="item" data-value="plumbing">Plumbing</div>
<div class="item" data-value="python">Python</div>
<div class="item" data-value="rails">Rails</div>
<div class="item" data-value="react">React</div>
<div class="item" data-value="repair">Kitchen Repair</div>
<div class="item" data-value="ruby">Ruby</div>
<div class="item" data-value="ui">UI Design</div>
<div class="item" data-value="ux">User Experience</div>
  </div>
</div>
              </div>
            </div>
            <div class="form-group ">
              <label>Details</label>
              <textarea  class="form-control" name="content" rows="10" cols="80"></textarea>
            </div>
            <div class="form-group">
              <div class="col-sm-10" style="padding:0;">
                <button type="submit" class="btn btn-success">Launch Idea</button>
              </div>
            </div>
          </form>
    </div>
    <div class="col-md-4 col-sm-4 col-lg-4">
      <p>
      </p>
     
    </div>
  </div>
</div>


<script type="text/javascript">
  $('.ui.dropdown')
  .dropdown({
    allowAdditions: true
  })
;
</script>