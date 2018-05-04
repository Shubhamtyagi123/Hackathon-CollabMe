<?php session_start();?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CollabME</title>
    <link rel="shortcut icon" type="image/png" href="favicon.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600|Tajawal" rel="stylesheet">
    <link rel="stylesheet" href="/hackathon/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/hackathon/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/hackathon/css/sym-ui/dropdown.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="/hackathon/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
    <script src="/hackathon/css/sym-ui/dropdown.min.js" type="text/javascript"></script>
    <script src="/hackathon/js/main.js"></script>

</head>
<body>
<?php
  include ('clogs/db_connect.php');
  require_once ('clogs/functions.php');
  
  if($_SESSION['is_logged_in'] != 1){
    echo "<script> location.href='login.php'; </script>";
    die();
  }

  $username_ = $_SESSION['username'];
  $table__ = 'requests';
  $requests = false;

  $sql___ = "SELECT COUNT(*) AS cc FROM $db_name.$table__ WHERE project_admin = '$username_'";
  $sql__ = "SELECT * FROM $db_name.$table__ WHERE project_admin = '$username_' AND status = 0";

  $sql___res = mysqli_query($connect_link, $sql___);

  if ($sql___res){
     $count__ = mysqli_fetch_array($sql___res,MYSQLI_ASSOC);
    if ($count__['cc'] > 0){
     $sql_res = mysqli_query($connect_link, $sql__);
    if ($sql_res) {
      $requests = true;
    }
      else {
   }
 }
}
?>
<nav class="navbar">
    <div class="container-fluid">
        <!-- Header -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#topNavBar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/hackathon/profile.php">CollabME</a>
        </div>
        <!-- Items -->
        <div class="collapse navbar-collapse" id="topNavBar">
            <ul class="nav navbar-nav">
                
            </ul>
            
            <div id="mySidenav" class="sidenav" style="text-align:center">
              <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
          <?php 

          if ($requests){
            while( $rm = mysqli_fetch_array($sql_res, MYSQLI_ASSOC)){

          ?>
              <div class="row row_custom">
              <div style="width:10px;"></div>
                <h3>
                  <a href="profile.php"><?=$rm['user_id']?></a>
                  <br>
                  <small>
                    <a href="details.php">@<?php echo get_project_name($rm['project_id'], $connect_link);?></a></small></h3>
                   <a href="/hackathon/clogs/accept.php?project_id=<?=$rm['project_id']?>&request_user=<?=$rm['user_id']?>" class="btn-accept pull-center">Accept</a>
                    <a href="/hackathon/post.php">
                      <button type="button" class="btn-reject pull-center">Reject</button>
                    </a>
                </form>
             </div>
                <?php
            }
          }
          else{
            echo "Not Allowed Area!";
          }
        ?>
            </div>
            <ul class="nav navbar-nav navbar-right">
            <li ><a href="/hackathon/post.php">New Idea?</a></li>

                <li ><a href="/hackathon/global.php">Global Projects</a></li>
                
                </li>
              
              <li>
                  <a href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> <span class="caret"></span></a>
                  
                  <ul class="dropdown-menu">
                    <li><a href="/hackathon/profile.php">Profile</a></li>
              <li> <a href="#"><span onclick="openNav()">Requests</span></a></li>
                    <li><a href="/hackathon/login.php">Logout</a></li> 
                  </ul>
        </div>
    </div>
</nav>


