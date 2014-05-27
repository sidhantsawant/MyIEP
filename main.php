
<? php
/** @file
 *  @brief  main menu
*  @bug	right hand drop down nav isn't working
*  @todo
*  1. Make input fields wider, perhaps
*  2. figure out which datepicker stuff can go
*  3. Create nav link back to student
*  4. Duplicate nav bar for all pages without one (or two)
*/
//the authorization level for this page!
$MINIMUM_AUTHORIZATION_LEVEL = 100;

if(isset($system_message)) $system_message = $system_message;
else $system_message = "";

define('IPP_PATH', './');

/* eGPS required files. */
require_once(IPP_PATH . 'etc/init.php');
require_once(IPP_PATH . 'include/db.php');
require_once(IPP_PATH . 'include/auth.php');
require_once(IPP_PATH . 'include/log.php');
//require_once(IPP_PATH . 'include/navbar.php');
require_once(IPP_PATH . 'include/supporting_functions.php');
require_once 'include/password.php';
require_once 'include/page_troubleshoot.php';
//require_once(IPP_PATH . 'include/config.inc.php');
header('Pragma: no-cache'); //don't cache this page!

/** brief sanitize authenticate form
 *  @remark but first secure against uncontrolled input
*/

$userPassword = $_POST['PASSWORD'];
$user = $_POST['LOGIN_NAME'];
function checkHash($user='', $userPassword='') {
   $query = "SELECT * FROM users WHERE login_name = '" . $user . ";
   $result = mysql_query($query);
   $row=mysql_fetch_array($system_result);
   if(!$result) {
      $error_message = "Database query failed (" . __FILE__ . ":" . __LINE__ . "): " . mysql_error() . "<BR>Query: '$query'<BR>";
      echo FALSE;
   }
   if(!connectUserDB()) {
      $error_message = $error_message; //just to remember we need this
      echo FALSE;
   }
   $hash = $row['unencrypted_password'];
   
   $valid=validateHash($userPassword, $hash);
   if ($valid) {
      echo "TRUE";
   else echo "false";
}






if (isset($_POST['LOGIN_NAME']) && isset( $_POST['PASSWORD'] )) {
    if (!validate( $_POST['LOGIN_NAME'] ,  $_POST['PASSWORD'] )) {
        $system_message = $system_message . $error_message;
        if (isset($_SESSION['egps_username'])) 
            IPP_LOG($system_message, $_SESSION['egps_username'], 'ERROR');
        else IPP_LOG($system_message, 'no session', 'ERROR');
        require(IPP_PATH . 'index.php');
        exit();
    }
} else {
    if(!validate()) {
        $system_message = $system_message . $error_message;
        if (isset($_SESSION['egps_username'])) 
            IPP_LOG($system_message, $_SESSION['egps_username'], 'ERROR');
        else IPP_LOG($system_message, "no session", 'ERROR');
        require(IPP_PATH . 'index.php');
        exit();
    }
}

?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Rik Goldman" >
    <link rel="shortcut icon" href="./assets/ico/favicon.ico">

    <title>MyIEP</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">
  </head>

  <body>
	
  
      <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" 
            data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="main.php">MyIEP</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="about.php">About</a></li>
			<li><a href="sprint_feedback.php">Leave Feedback</a></li>
            <li><a href="help.php">Help</a></li>
            <li><a href="index.php">Logout</a></li>
            </ul>
             
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" 
                data-toggle="dropdown">Navigation <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="./manage_student.php">Students</a></li>
                <li class="divider"></li>
                <li><a href="change_ipp_password.php">Reset Password</a></li>
                <li><a href="superuser_add_goals.php">Goals Database</a></li>
                <li><a href="./student_archive.php">Archive</a></li>
                <li><a href="./user_audit.php">Audit</a></li>
                <li><a href="superuser_manage_coding.php">Manage Codes</a></li>
                <li><a href="school_info.php">Manage Schools</a></li>
                <li><a href="superuser_view_logs.php">View Logs</a></li>
                <li><a href="superuser_add_program_area.php">Add New Goal Area</a></li>
              </ul>
            </li>
          </ul>
         </div>
         <!--/.nav-collapse -->
        <!--<div class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" role="form" enctype="multipart/form-data" action="jumbotron.php" method="post">
            <div class="form-group">
              <input type="text" placeholder="User Name" class="form-control" value="<?php echo $LOGIN_NAME;?>">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control" name="PASSWORD" value="">
            </div>
            <button type="submit" value="submit" class="btn btn-success">Sign in</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Welcome to MyIEP</h1>
        <p>MyIEP is a Web-based IEP Management system under active development by students at 
            <a href="http://chelseaschool.edu">Chelsea School</a> in Hyattsville, MD.</p>
        <p>&copy; 2014 Chelsea School - <a href="http://www.gnu.org/licenses/gpl-2.0.html">GPLv2</a>.</p>
        <p><a class="btn btn-primary btn-lg" href="about.php" role="button">Learn More &raquo;</a></p>
        <p><?php echo checkHash($user, $userPassword); ?></p>
      </div>
    </div>
    <div class="container">
    <?php if ($system_message) {
    	echo "<p>" . $system_message . "</p>";} 
    ?>
      <div class="alert alert-block alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Note</strong>: Access to the following sections is restricted. 
        All areas are displayed here; as you explore keep in mind that you won't be able to access some areas.
         Please do contact support if you're blocked from a necessary area.
      </div>
      
      <p></p>
    
      <div class="row">
        <div class="col-md-4">
          <h2>Students</h2>
          <p>List available students; update progress on objectives; create IEP; revise IEP.</p>
          <p><a class="btn btn-default" href="./manage_student.php" role="button">Access Student Records &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Change Password</h2>
          <p><em>Important</em>: Go here to <em>change your password</em>, particularly if it's still set to the default password you were assigned.</p>
          <p><a class="btn btn-default" href="change_ipp_password.php" role="button">Change Password &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Goals Database</h2>
          <p>Enter goals or objectives into Goals and Objectives bank.</p>
          <p><a class="btn btn-default" href="./superuser_add_goals.php" role="button">Update Goal Bank &raquo;</a></p>
        </div>
      </div>
<div class="row">
        <div class="col-md-4">
          <h2>Archives</h2>
          <p>Access archived student records.</p>
          <p><a class="btn btn-default" href="./student_archive.php" role="button">View Archive &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>User Audit</h2>
          <p>Choose from list of users.</p>
          <p><a class="btn btn-default" href="./user_audit.php" role="button">Browse Users &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Manage Codes</h2>
          <p>Manage codes available for use with IEPs.</p>
          <p><a class="btn btn-default" href="./superuser_manage_coding.php" role="button">Manage Codes &raquo;</a></p>
        </div>
      </div>
      
 <div class="row">
        <div class="col-md-4">
          <h2>Schools</h2>
          <p>Manage schools.</p>
          <p><a class="btn btn-default" href="school_info.php" role="button">View Schools &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>System Tools</h2>
          <p>System administration &amp; Operations.</p>
          <p><a class="btn btn-default" href="superuser_tools.php" role="button">Admin Tools &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Manage Accounts</h2>
          <p>Configure MyIEP user accounts and access control; create new accounts.</p>
          <p><a class="btn btn-default" href="./superuser_manage_users.php" role="button">Manage Accounts &raquo;</a></p>
        </div>
      </div>     
      <hr>
</div> <!-- /container -->
      
     
  <?php echo print_footer(); ?>  


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-2.1.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
  </body>
</html>
