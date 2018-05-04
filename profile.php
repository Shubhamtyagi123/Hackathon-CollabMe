<?php

include ('header.php');
include ('clogs/db_connect.php');
require_once ('clogs/functions.php');
$username = $user_id = $_SESSION['username'];
$NO_PROJECTS_YET = true;

if (isset($_GET['user']))
  $username = $_GET['user'];

get_user_information($username, $connect_link) != null ? 
$user = mysqli_fetch_object(get_user_information($username, $connect_link)): $user = "Null";
$projects = get_all_projects($username, $connect_link);
$pending_requests = get_all_pending_requests($username, $connect_link);
$accepted_requests = get_all_accepted_requests($username, $connect_link);

if ($projects != null) 
  $NO_PROJECTS_YET = false;

function populate($data){

  if ($data == NULL || $data = "")
    $data = 'Not Known';
  else
    $data = $data;

  return $data;

}

  if($_SESSION['is_logged_in'] != 1){
    header('location: login');
    die();
  }

?>

<div class="container">
  <div class="col-md-4">
    <div class="ui card full-card">
  <a class="image" href="#">
    <img src="<?=$user->photo_path?>">
  </a>
  <div class="content">
    <a class="header" href="/hackathon/profile.php?user=<?=$user->username?>"><?=$user->full_name?></a>
    <div class="meta">
      <a>Last Seen 2 days ago</a>
    </div>
  </div>
</div><br>
<div class="recent-activities">
<div class="section-heading">
  <h3>Recent Activities</h3>
</div>
<?php
    if ($accepted_requests != null) {
      while ($r = mysqli_fetch_object($accepted_requests)) {
          $user = mysqli_fetch_object(get_user_information($r->user_id, $connect_link));
        ?>
          <div class="ui feed">
            <div class="event">
              <div class="label">
                <img src="<?=$user->photo_path?>">
              </div>
              <div class="content">
                <a href="/hackathon/profile.php?user=<?=$user->username?>"><?=$user->username?></a> accepted you request to join <a href="/hackathon/clogs/details.php?project=<?=$r->project_id?>"><?php $x = $r->project_id; echo get_project_name($x, $connect_link)?></a>
              </div>
            </div>
          </div>
        <?php
      }
    }
    else {
      echo "No Activities found.";
    }
?>

</div>
<div class="pending-section">
<div class="section-heading">
  <h3>Pending Requests</h3>
</div>
<?php
  
  if ($pending_requests != null) {
    while ($req = mysqli_fetch_object($pending_requests)) {

        $u = get_user_information($user_id, $connect_link);
        $i = mysqli_fetch_object($u);
      ?>
      <div class="ui feed">
      <div class="event">
        <div class="label">
          <img src="<?=$i->photo_path?>">
        </div>
        <div class="content">
          Request pending for <a href="/hackathon/clogs/details.php?project=<?=$req->project_id?>"><?php $x=$req->project_id;echo get_project_name($x, $connect_link)?></a>
        </div>
      </div>
    </div>
      <?php
    }
  }
  else {
    echo "No Recent Post found.";
  }


?>

</div>
  </div>
  <div class="col-md-8">
    <div class="section-heading">
      <h1>Initiated Projects</h1><br>
    </div>
    <div class="ui divided items">
  <?php
        if (!$NO_PROJECTS_YET) {
          while ($p = mysqli_fetch_object($projects)) {
              ?>

              <div class="item">
                <div class="content">
                <a class="header" href="/hackathon/clogs/details.php?project=<?=$p->project_id?>"><?=$p->project_title?></a>
                <div class="meta">
                  <span class="cinema"><?=$p->_begin?></span>
                </div>
                <div class="description">
                  <p>
                    <?=$p->details?>
                  </p>
                </div>
                <div class="extra">
                  <?php
                    $tags = explode(',', $p->skills);
                    foreach ($tags as $tag => $value) {
                      ?>
                      <div class="ui label" style="background-color:<?='rgba('.rand(0,255).', '.rand(0,255).', '.rand(0,255).', 0.83)';?> "><?=$value?></div>
                      <?php
                    }
                  ?>
                </div>
              </div>
            </div>
              <?php
          }
        }
        else {
          echo "<h1>oops! Seems like you don't have any projects yet.</h1>";
        }
  ?>
  
  </div>
</div>