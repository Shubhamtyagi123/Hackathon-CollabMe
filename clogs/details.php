<?php

	require_once("db_connect.php");
	require_once ("functions.php");
	require_once("../header.php");

	$username = $user_id = $_SESSION['username'];
	$project_to_find = null;

	if (isset($_GET['project']))
		$project_to_find = $_GET['project'];

	if (strlen($username) < 1)
		die("Wrong Username Fault caught!");

	get_user_information($username, $connect_link) != null ? 
	$user = mysqli_fetch_object(get_user_information($username, $connect_link)): $user = "Null";
	$projects = get_all_projects($username, $connect_link);
	$project_to_show = get_project($project_to_find, $connect_link);
	$pending_requests = get_all_pending_requests($username, $connect_link);
	$accepted_requests = get_all_accepted_requests($username, $connect_link);
	$project_pending_requests = get_all_pending_project_requests($project_to_find, $connect_link);
	$project_approved_requests = get_all_approved_project_requests($project_to_find, $connect_link);


	
	if ($project_to_show != null)
		$project_ = mysqli_fetch_object($project_to_show);
	else
		$project_ = null;

	//check for validation!
?>

<div class="container">
	<div class="col-md-4">
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
                <img src="/hackathon/<?=$user->photo_path?>">
              </div>
              <div class="content">
                <a href="/hackathon/profile.php?user=<?=$user->username?>"><?=$user->username?></a> accepted your request to join <a href="/hackathon/clogs/details.php?project=<?=$r->project_id?>"><?php $x = $r->project_id; echo get_project_name($x, $connect_link)?></a>
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
          <img src="/hackathon/<?=$i->photo_path?>">
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
		<div class="project-title">
			<h1>
				<?=($project_ != null)? $project_->project_title:"Project Not Found";?>
			</h1>
		</div>
		<div class="project-tags" style="margin-top:10px;">
			<?php
                    $tags = explode(',', $project_->skills);
                    foreach ($tags as $tag => $value) {
                      ?>
                      <div class="ui label" style="background-color:<?='rgba('.rand(0,255).', '.rand(0,255).', '.rand(0,255).', 0.63)';?> "><?=$value?></div>
                      <?php
                    }
                  ?>
		</div>
		<div class="project-desc">
			<p>
				<?=($project_ != null)? $project_->details:"Project Not Found";?>
			</p>
		</div>
		<hr>

	<?php
		if ($_SESSION['username'] == $project_->admin_name) {
	?>
		<div class="row">
		<div class="applicants-section" style="margin-bottom: 20px;">
			<h2>Pending Applicants</h2>
		</div>
		<div class="pending-project-requests">
			<?php

				if ($project_pending_requests != null) {
					while ($pr = mysqli_fetch_object($project_pending_requests)) {
							$usr = mysqli_fetch_object(get_user_information($pr->user_id, $connect_link));
						?>
						<div class="col-md-4">
							<div class="ui cards">
  <div class="card">
    <div class="content">
      <img class="right floated mini ui image" src="/hackathon/<?=$usr->photo_path?>">
      <div class="header">
       <a href="/hackathon/profile.php?user=<?=$usr->username?>"><?=$usr->full_name?></a>
      </div>
      <div class="meta">
        <?=$usr->username?>
      </div>
     
    </div>
    <div class="extra content">
      <div class="ui two buttons">
        <div class="ui basic green button">
        	<a href="/hackathon/clogs/accept.php?project_id=<?=$pr->project_id;?>&request_user=<?=$pr->user_id;?>">Approve</a></div>
        <div class="ui basic red button">Decline</div>
      </div>
    </div>
  </div>
  </div>
</div>
						<?php
					}
				}
				else {
					echo "<h3>Seems like no one has seen this project yet.<h3>";
				}
			?>
		
	</div>
</div>
<div class="row" >

	<div class="approved-project-requests">
		<div class="section-heading" style="margin-bottom: 20px; margin-top: 20px;">
			<h2>Approved Requests</h2>
		</div>
		<?php

				if ($project_approved_requests != null) {
					while ($pr = mysqli_fetch_object($project_approved_requests)) {
							$usr = mysqli_fetch_object(get_user_information($pr->user_id, $connect_link));
						?>
						<div class="col-md-4">
							<div class="ui cards">
  <div class="card">
    <div class="content">
      <img class="right floated mini ui image" src="/hackathon/<?=$usr->photo_path?>">
      <div class="header">
       <a href="/hackathon/profile.php?user=<?=$usr->username?>"><?=$usr->full_name?></a>
      </div>
      <div class="meta">
        <?=$usr->username?>
      </div>
     
    </div>
    
  </div>
  </div>
  </div>
						<?php
					}
				}
				else {
					echo "<h3>Seems like no one has seen this project yet.<h3>";
				}
			?>
	
</div>

</div>
<?php 
	}
?>
</div>
</body>
</html>