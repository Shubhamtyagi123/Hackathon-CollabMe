<?php

include ('header.php');
require_once('clogs/functions.php');

$table = 'projects';
$data_fetched = false;

  if($_SESSION['is_logged_in'] != 1){
    header('location: login.php');
    die();
  }

  $username = $_SESSION['username'];
  $table = 'projects';
  $sql_global = "SELECT * FROM $db_name.$table ORDER BY id DESC";
  $sql_Res = mysqli_query($connect_link,$sql_global);

   	if ($sql_Res){
 		 $data_fetched = true;
 	  }

  $project_admin = null;
  $table_ = 'requests';

  if(isset($_GET['project_id'])){
    $pid = validate($_GET['project_id']);
    $sql_1 = "SELECT admin_name FROM $db_name.$table WHERE project_id = '$pid'";
    $sql_r_1 = mysqli_query($connect_link, $sql_1);
    
    if($sql_r_1){
      $row = mysqli_fetch_array($sql_r_1, MYSQLI_ASSOC);
      if ($row['admin_name'] != $username){
        $project_admin = $row['admin_name'];

        // check if the present user has already requested for this project.
        
        $check = "SELECT *  FROM $table_ WHERE project_id = '$pid' AND user_id = '$username'";
        $query = mysqli_query($connect_link, $check);
        if ($query && (mysqli_num_rows($query) == 0)) {

          $sql = "INSERT INTO $db_name.$table_ (project_id, user_id, project_admin) VALUES ('$pid', '$username', '$project_admin')";
          $sql_r = mysqli_query($connect_link, $sql);

          if ($sql_r){
            // request made!
            // 
            echo '<div class="alert alert-success" style="max-width:40%;">

                    <strong>Thank you! Request Submitted! </strong>
                  </div>';




                  /* ===============================

                   ===============================

                    NOTE:: Add mail system here!

                   ===============================

                     =============================== */
          }
          else {
          // could not save the request!
            echo '<div class="alert alert-danger">
                    <strong>Opps! Seems like there is a error within our servers! </strong>
                  </div>';
        }

        }
        else {
          echo '<div class="alert alert-danger">
                  <strong>Seems like you have already submitted a request for this project.</strong>
                </div>';
        }
      }
      else{
        // same user as the logged in user!
        echo '<div class="alert alert-warning" style="max-width:40%;">
                <p><strong>Sorry! You can not submit a request for your own Project.</strong></p>
              </div>';
      }
        }
        else{
          echo('location: ../html/error.html');
          echo $sql_1;
      }
    }
 ?>
<div class="container-fluid">
  <div class="row">
        <div class="col-sm-3">
          <div class="ui icon input" style="width:100%">
            <input type="text" placeholder="Search by name...">
            <i class="inverted circular search link icon"></i>
          </div>
          <br><br>
          <label for="">Search by tag</label><br>
          <div class="ui floating dropdown labeled icon button">
  <i class="filter icon"></i>
  <span class="text">Filter Projects</span>
  <div class="menu">
    <div class="ui icon search input">
      <i class="search icon"></i>
      <input type="text" placeholder="Search tags...">
    </div>
    <div class="divider"></div>
    <div class="header">
      <i class="tags icon"></i>
      Tag Label
    </div>
    <div class="scrolling menu">
      <div class="item">
        <div class="ui red empty circular label"></div>
        Important
      </div>
      <div class="item">
        <div class="ui blue empty circular label"></div>
        Announcement
      </div>
      <div class="item">
        <div class="ui black empty circular label"></div>
        Cannot Fix
      </div>
      <div class="item">
        <div class="ui purple empty circular label"></div>
        News
      </div>
      <div class="item">
        <div class="ui orange empty circular label"></div>
        Enhancement
      </div>
      <div class="item">
        <div class="ui empty circular label"></div>
        Change Declined
      </div>
      <div class="item">
        <div class="ui yellow empty circular label"></div>
        Off Topic
      </div>
      <div class="item">
        <div class="ui pink empty circular label"></div>
        Interesting
      </div>
      <div class="item">
        <div class="ui green empty circular label"></div>
        Discussion
      </div>
    </div>
  </div>
</div>
        </div>
              <div class="col-sm-10 col-md-9">
             <?php
               	if ($data_fetched){
                    $i = 0 ;
            		    while ($rows = mysqli_fetch_array($sql_Res, MYSQLI_ASSOC)) {
                      $tags = explode(',', $rows['skills']);
                      $u = mysqli_fetch_object(get_user_information($rows['admin_name'], $connect_link));
                      
               		?>
              <div class="col-md-4" style="margin-bottom: 20px;">

<div class="ui card">
  <div class="content">
    <div class="header"><a href="/hackathon/clogs/details.php?project=<?=$rows['project_id']?>"><?=$rows['project_title'];?></a></div>
    <div class="meta">
      <?php
        foreach ($tags as $key => $value) {
          ?>
            <div class="ui label"><?=$value?></div>
          <?php
        }
      ?>
    </div>
    <div class="description">
      <p><?=$rows['details']?></p>
    </div>
  </div>
  <div class="extra content">
    <div class="left floated author">
      <img class="ui avatar image" src="/hackathon/<?=$u->photo_path?>"> <?=$rows['admin_name']?>
    </div>
    <div class="right floated author">
      <a href="global.php?project_id=<?=$rows['project_id']?>" class="collab-btn">Collab
                </a>
              </div>
  </div>
</div>
</div>


          
        <?php
            
            $i = $i+1;
         }
       }
	       mysqli_close($connect_link);
      ?>

   
  </div>
 </div>
</div>

<script type="text/javascript">
  $('.ui.dropdown')
  .dropdown()
;
</script>