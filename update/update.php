<?php

/************************************
* 	@author			Mian Saleem		*
* 	@package 		SMA2			*
* 	@subpackage 	install			*
************************************/

$installFile = "../SMA2";
$indexFile = "../index.php";
$configFolder = "../sma/config";
$configFile = "../sma/config/config.php";

if (is_file($installFile)) { 

switch($_GET['step']){
	default: ?>
		<ul class="steps">
		<li class="active pk">Checklist</li>
		<li>Register</li>
		<li>Site Config</li>
		<li class="last">Done!</li>
		</ul>
		<h3>Pre-update Checklist</h3>
		<?php 
			$error = FALSE;
			if(!is_writeable($indexFile)){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Index Filer (index.php) is not writeable!</div>"; }
			if(!is_writeable($configFolder)){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Config Folder (sma/config/) is not writeable!</div>"; }
			if(!is_writeable($configFile)){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Config File (sma/config/config.php) is not writeable!</div>"; }
			if(phpversion() < "5.2"){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Your PHP version is ".phpversion()."! PHP 5.3 or higher required!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> You are running PHP ".phpversion()."</div>";} 
			if(!extension_loaded('mcrypt')){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Mcrypt PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> Mcrypt PHP exention loaded!</div>";}
			if(!extension_loaded('mysql')){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Mysql PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> Mysql PHP exention loaded!</div>";}
			if(!extension_loaded('mysqli')){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> Mysqli PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> Mysqli PHP exention loaded!</div>";}
			if(!extension_loaded('mbstring')){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> MBString PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> MBString PHP exention loaded!</div>";}
			if(!extension_loaded('gd')){echo "<div class='alert alert-error'><i class='icon-remove'></i> GD PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> GD PHP exention loaded!</div>";}
			if(!extension_loaded('curl')){$error = TRUE; echo "<div class='alert alert-error'><i class='icon-remove'></i> CURL PHP exention missing!</div>";}else{echo "<div class='alert alert-success'><i class='icon-ok'></i> CURL PHP exention loaded!</div>";}
?>      
		<div class="bottom">
			<?php if($error){ ?>
			<a href="#" class="btn btn-primary disabled">Next Step</a>
			<?php }else{ ?>
			<a href="?step=0" class="btn btn-primary">Next Step</a>
			<?php } ?>
		</div>

<?php
	break;
	case "0": ?>
	<ul class="steps">
		<li class="ok"><i class="icon icon-ok"></i>Checklist</li>
		<li class="active">Register SMA</li>
		<li>Site Config</li>
		<li class="last">Done!</li>
		</ul>
	<h3>Verify your purchase code.</h3>
     <?php
		if($_POST){
			$code = $_POST["code"];
			if (isset($code) && md5($code) == 'f7b16af5588f9654862e4aefcec8b0de') {
		    ?>
            <form action="?step=1" method="POST" class="form-horizontal">
		
		<div class="alert alert-success"><i class='icon-ok'></i> <strong>Success</strong>: Valid purchase code</div> 
		<input id="code" type="hidden" name="code" value="<?php echo $code; ?>" />
        <input id="username" type="hidden" name="username" value="<?php echo $username; ?>" />
		<div class="bottom">
			<input type="submit" class="btn btn-primary" value="Next Step"/>
		</div>
		</form>
				    <?php
		}else{  ?>
		<div class="alert alert-success"><i class='icon-ok'></i> <strong>Success</strong>: Valid purchase code</div>
		<form action="?step=0" method="POST" class="form-horizontal">
        <div class="control-group">
          <label class="control-label" for="code">Purchase Code <a href="#myModal" role="button" data-toggle="modal"><i class="icon-question-sign"></i></a></label>
          <div class="controls">
          <input id="code" type="text" name="code" class="input-large" required data-error="Purchase Code is required" placeholder="Purchase Code" />
          </div>
        </div>
		<div class="bottom">
			<input type="submit" class="btn btn-primary" value="Check"/>
		</div>
		</form>
		<?php
		}
		}else{	?>
	<p>If you don't have a purchase code check <b>pruchasecode.txt</b></p>
	<br />
		<form action="?step=0" method="POST" class="form-horizontal">
        <div class="control-group">
          <label class="control-label" for="code">Purchase Code <a href="#myModal" role="button" data-toggle="modal"><i class="icon-question-sign"></i></a></label>
          <div class="controls">
          <input id="code" type="text" name="code" class="input-large" required data-error="Purchase Code is required" placeholder="Purchase Code" />
          </div>
        </div>
		
		<div class="bottom">
			<input type="submit" class="btn btn-primary" value="Validate"/>
		</div>
		</form>
	<?php }
	break;
	case "1": ?>
	<ul class="steps">
		<li class="ok"><i class="icon icon-ok"></i>Checklist</li>
		<li class="ok"><i class="icon icon-ok"></i>Register</li>
		<li class="active">Site Config</li>
		<li class="last">Done!</li>
		</ul>
        <h3>Site Config</h3>
		<?php if($_POST){ ?>
		<form action="?step=2" method="POST" class="form-horizontal">
		<div class="control-group">
          <label class="control-label" for="domain">SMA URL</a></label>
          <div class="controls">
          <input type="text" id="domain" name="domain" class="xlarge" required data-error="SMA URL is required" value="<?php echo "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -14); ?>" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="domain">Your Timezone</a></label>
          <div class="controls">
            <?php 
			require_once('includes/timezones_class.php');
			$tz = new Timezones();
			$timezones = $tz->get_timezones();
			echo '<select name="timezone" required="required" data-error="TimeZone is required">';
            foreach ($timezones as $key => $zone){
            echo '<option value="'.$key.'">'.$zone.'</option>';
            }
            echo '</select>'; ?>
          </div>
        </div>    
		<input type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
        <input type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
		<div class="bottom">
			<a href="?step=0" class="btn pull-left">Previous Step</a>
			<input type="submit" class="btn btn-primary" value="Next Step"/>
		</div>
		</form>
		
	<?php }
	break;
	case "2":
	?>
	<ul class="steps">
		<li class="ok"><i class="icon icon-ok"></i>Checklist</li>
		<li class="ok"><i class="icon icon-ok"></i>Register</li>
		<li class="active">Site Config</li>
		<li class="last">Done!</li>
		</ul>
	<h3>Saving site config</h3>
	<?php
		if($_POST){
			$domain = $_POST['domain'];
			$timezone = $_POST['timezone'];
			$code = $_POST["code"];
			$username = $_POST["username"];

			require_once('includes/core_class.php');
			$core = new Core();
						
			if ($core->write_config($domain) == false) {
				echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write config details to ".$configFile."</div>";
			} elseif ($core->write_index($timezone) == false) {
				echo "<div class='alert alert-error'><i class='icon-remove'></i> Failed to write timezone details to ".$indexFile."</div>";
			} else { 
				echo "<div class='alert alert-success'><i class='icon-ok'></i> Config details written to the config file.</div>"; 
			}
		
		
		} else { echo "<div class='alert alert-success'><i class='icon-question-sign'></i> Nothing to do...</div>"; }
		?>
		<div class="bottom">
			<form action="?step=1" method="POST" class="form-horizontal">
		    <input id="code" type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
            <input id="username" type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
			<input type="submit" class="btn pull-left" value="Previous Step"/>
			</form>
			<form action="?step=3" method="POST" class="form-horizontal">
		    <input id="code" type="hidden" name="code" value="<?php echo $_POST['code']; ?>" />
            <input id="username" type="hidden" name="username" value="<?php echo $_POST['username']; ?>" />
			<input type="submit" class="btn btn-primary pull-right" value="Next Step">
			</form>
			<br clear="all">
		</div>

	<?php
	break;
	case "3": ?>
		<ul class="steps">
		<li class="ok"><i class="icon icon-ok"></i>Checklist</li>
		<li class="ok"><i class="icon icon-ok"></i>Register</li>
		<li class="ok"><i class="icon icon-ok"></i>Site Config</li>
		<li  class="active">Done!</li>
	</ul>

	<?php if($_POST){
		$code = $_POST['code'];
		define("BASEPATH", "update/");
		require("../sma/config/database.php");
		if (isset($code) && md5($code) == '603d45b9be38f30180145818a2ee8a1a') {
			$db_tables = file_get_contents('includes/sql/db.sql');
			$dbdata = array(
						'hostname' => $db['default']['hostname'],
						'username' => $db['default']['username'],
						'password' => $db['default']['password'],
						'database' => $db['default']['database'],
						'dbtables' => $db_tables
						);
			require_once('includes/database_class.php');
			$database = new Database();
			if ($database->update_db($dbdata) == false) {
			#if ($database->update_tables($dbdata) == false) {
				$finished = FALSE;
				echo "<div class='alert alert-warning'><i class='icon-warning'></i> The database tables could not be created, please try again.</div>";
			} else {
				$finished = TRUE;
					if(!@unlink('../SMA2')){
					echo "<div class='alert alert-warning'><i class='icon-warning'></i> Please remove the SMA2 file from the main folder in order to lock the ipdate tool.</div>";
					}
				
			}

		}else{
			echo "<div class='alert alert-error'><i class='icon-remove'></i> Error while validating your purchase code!</div>";
		}
		
				 
		} 
		if($finished) {
?>
			
			<h3><i class='icon-ok'></i> Update completed!</h3>
            <div class="alert alert-warning"><i class='icon-warning-sign'></i> You can proceed to login now.</div>
					<div class="bottom">
					<a href="<?php echo "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -15); ?>" class="btn btn-primary">Go to Login</a>
				</div>
			
	<?php	
		}
	}

}else{
			echo "<div style='width: 100%; font-size: 10em; color: #757575; text-shadow: 0 0 2px #333, 0 0 2px #333, 0 0 2px #333; text-align: center;'><i class='icon-lock'></i></div><h3 class='alert-text text-center'>Update tool is locked!<br><small style='color:#666;'>Please contact your developer/support.</small></h3>";
		}
?>

 
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
    <h3 id="myModalLabel">How to find your purchase code</h3>
  </div>
  <div class="modal-body">
    <img src="img/purchaseCode.png">
  </div>
</div>