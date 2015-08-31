<?php

$servername = "10.178.134.53"; //10.178.134.53 or db01

$username_ALPAC = "dashboard_user"; //user who only has permissions to SELECT rows. keeps permissions contained
$password_ALPAC = "5vOQBAX$@iOQt6";
$dbname_ALPAC = "americanlib";
$cat_id_ALPAC = 1152;  //numeric cat_id of slug 'newsedge'

$username_JGM = "dashboard_user";
$password_JGM = "5vOQBAX$@iOQt6";
$dbname_JGM = "minutemanproject_dreamho";
$cat_id_JGM = 835;  //numeric cat_id of slug 'newsedge'

$username_SAA = "dashboard_user";
$password_SAA = "5vOQBAX$@iOQt6";
$dbname_SAA = "senioraa_com";
$cat_id_SAA = 1373;  //numeric cat_id of slug 'newsedge'

$username_CRN = "dashboard_user";
$password_CRN = "5vOQBAX$@iOQt6";
$dbname_CRN = "conservativerepublicannews";
$cat_id_CRN = 1795;  //numeric cat_id of slug 'newsedge'

$username_SRC = "dashboard_user";
$password_SRC = "5vOQBAX$@iOQt6";
$dbname_SRC = "selfreliancecentral";
$cat_id_SRC = 1519;  //numeric cat_id of slug 'newsedge'




$date_offset = 1; 	/* not used, just here as an example
					* if you set this to 4, 
					* the MySQL query will grab posts 
					* from within the last 3 days.
					* Set to 1 to grab today's posts.
					*/

function typicalSQL($cat_id, $post_offset) {
return "SELECT DISTINCT ID, post_title, post_name, guid, post_date, post_content
FROM wp_posts AS p
INNER JOIN wp_term_relationships AS tr ON (
p.ID = tr.object_id

)
INNER JOIN wp_term_taxonomy AS tt ON (
tr.term_taxonomy_id = tt.term_taxonomy_id
AND taxonomy = 'category' AND tt.term_id
IN ( $cat_id )
)
AND DATEDIFF(NOW(), `post_date`) < $post_offset
ORDER BY id DESC";
}
 
 /*
 * JGM is bestowed the special honor of having a special function 
 * because the wp_ tables are prefixed.
 */
 
function jgmSQL($cat_id, $post_offset) {
return "SELECT DISTINCT ID, post_title, post_name, guid, post_date, post_content
FROM wp_a77es4_posts AS p
INNER JOIN wp_a77es4_term_relationships AS tr ON (
p.ID = tr.object_id

)
INNER JOIN wp_a77es4_term_taxonomy AS tt ON (
tr.term_taxonomy_id = tt.term_taxonomy_id
AND taxonomy = 'category' AND tt.term_id
IN ( $cat_id )
)
AND DATEDIFF(NOW(), `post_date`) < $post_offset
ORDER BY id DESC";
}

/*
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["ID"]. " - Title: " . $row["post_title"]. " " . $row['post_date']. "<br>";
    }
} else {
    echo "0 results";
}
*/


function sqlConnectionManager($servername, $username, $password, $dbname, $cat_id, $post_offset) {
	
	// Create a new MySQL connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	} 
	
	// This makes use of a typical category-selection statement for MySQL. 
	// We pass in two variables to control the request.
	
		$result = $conn->query(typicalSQL($cat_id, $post_offset));
		
	//echo $username . " " . var_dump($result) . "<br />"; //uncomment for debugging
	
	if($result->num_rows === null) {
		$result->num_rows = 0;
	}
	
	$conn->close();	
	
	return $result->num_rows;
}

function sqlConnectionManagerJGM($servername, $username, $password, $dbname, $cat_id, $post_offset) {
	// Create a new MySQL connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	} 
	
	// This makes use of a typical category-selection statement for MySQL. 
	// We pass in two variables to control the request.
	$result = $conn->query(jgmSQL($cat_id, $post_offset));
	
	
	if($result->num_rows === null) {
		$result->num_rows = 0;
	}
	
	$conn->close();	
	
	return $result->num_rows;
}


$daily_ALPAC = sqlConnectionManager($servername, $username_ALPAC, $password_ALPAC, $dbname_ALPAC, $cat_id_ALPAC, 1);
$weekly_ALPAC = sqlConnectionManager($servername, $username_ALPAC, $password_ALPAC, $dbname_ALPAC, $cat_id_ALPAC, 8);
$monthly_ALPAC = sqlConnectionManager($servername, $username_ALPAC, $password_ALPAC, $dbname_ALPAC, $cat_id_ALPAC, 31);
$total_ALPAC = sqlConnectionManager($servername, $username_ALPAC, $password_ALPAC, $dbname_ALPAC, $cat_id_ALPAC, 999);


$daily_JGM = sqlConnectionManagerJGM($servername, $username_JGM, $password_JGM, $dbname_JGM, $cat_id_JGM, 1);
$weekly_JGM = sqlConnectionManagerJGM($servername, $username_JGM, $password_JGM, $dbname_JGM, $cat_id_JGM, 8);
$monthly_JGM = sqlConnectionManagerJGM($servername, $username_JGM, $password_JGM, $dbname_JGM, $cat_id_JGM, 31);
$total_JGM = sqlConnectionManagerJGM($servername, $username_JGM, $password_JGM, $dbname_JGM, $cat_id_JGM, 999);


$daily_SAA = sqlConnectionManager($servername, $username_SAA, $password_SAA, $dbname_SAA, $cat_id_SAA, 1);
$weekly_SAA = sqlConnectionManager($servername, $username_SAA, $password_SAA, $dbname_SAA, $cat_id_SAA, 8);
$monthly_SAA = sqlConnectionManager($servername, $username_SAA, $password_SAA, $dbname_SAA, $cat_id_SAA, 31);
$total_SAA = sqlConnectionManager($servername, $username_SAA, $password_SAA, $dbname_SAA, $cat_id_SAA, 999);

$daily_CRN = sqlConnectionManager($servername, $username_CRN, $password_CRN, $dbname_CRN, $cat_id_CRN, 1);
$weekly_CRN = sqlConnectionManager($servername, $username_CRN, $password_CRN, $dbname_CRN, $cat_id_CRN, 8);
$monthly_CRN = sqlConnectionManager($servername, $username_CRN, $password_CRN, $dbname_CRN, $cat_id_CRN, 31);
$total_CRN = sqlConnectionManager($servername, $username_CRN, $password_CRN, $dbname_CRN, $cat_id_CRN, 999);


$daily_SRC = sqlConnectionManager($servername, $username_SRC, $password_SRC, $dbname_SRC, $cat_id_SRC, 1);
$weekly_SRC = sqlConnectionManager($servername, $username_SRC, $password_SRC, $dbname_SRC, $cat_id_SRC, 8);
$monthly_SRC = sqlConnectionManager($servername, $username_SRC, $password_SRC, $dbname_SRC, $cat_id_SRC, 31);
$total_SRC = sqlConnectionManager($servername, $username_SRC, $password_SRC, $dbname_SRC, $cat_id_SRC, 999);



$totalCounter = $total_SAA + $total_JGM + $total_ALPAC + $total_CRN + $total_SRC;
$weeklyCounter = $weekly_SAA + $weekly_JGM + $weekly_ALPAC + $weekly_CRN + $weekly_SRC;
$monthlyCounter = $monthly_SAA + $monthly_JGM + $monthly_ALPAC + $monthly_CRN + $monthly_SRC;
$dailyCounter = $daily_SAA + $daily_JGM + $daily_ALPAC + $daily_CRN + $daily_SRC;


$mysql_servername = "db01";
$username = "testuser1";
$password = "Number24!";
$dbname = "testSchema";

// Create connection
$conn = new mysqli($mysql_servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

function mysql_escape_mimic($inp) { 
    if(is_array($inp)) 
        return array_map(__METHOD__, $inp); 

    if(!empty($inp) && is_string($inp)) { 
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
    } 

    return $inp; 
} 

function insertNewsedge($conn, $website_name, $posts_today, $posts_week, $posts_month, $posts_total) {
	
	$website_name = '"'.mysql_escape_mimic($website_name).'"';	
	$posts_today = '"'.mysql_escape_mimic($posts_today).'"';
	$posts_week = '"'.mysql_escape_mimic($posts_week).'"';
	$posts_month = '"'.mysql_escape_mimic($posts_month).'"';
	$posts_total = '"'.mysql_escape_mimic($posts_total).'"';

	$sql = "INSERT INTO Newsedge (website_name, posts_today, posts_week, posts_month, posts_total)
	VALUES ($website_name, $posts_today, $posts_week, $posts_month, $posts_total) 
	ON DUPLICATE KEY UPDATE 
		posts_today = $posts_today,
		posts_week = $posts_week,
		posts_month = $posts_month,
		posts_total = $posts_total";

	if ($conn->query($sql) === TRUE) {
	    //echo "New ".$website_name." record created successfully<br />";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
insertNewsedge($conn, 'ALPAC', $daily_ALPAC, $weekly_ALPAC, $monthly_ALPAC, $total_ALPAC); //update mysql records
insertNewsedge($conn, 'JGM', $daily_JGM, $weekly_JGM, $monthly_JGM, $total_JGM);
insertNewsedge($conn, 'SAA', $daily_SAA, $weekly_SAA, $monthly_SAA, $total_SAA);
insertNewsedge($conn, 'CRN', $daily_CRN, $weekly_CRN, $monthly_CRN, $total_CRN);
insertNewsedge($conn, 'SRC', $daily_SRC, $weekly_SRC, $monthly_SRC, $total_SRC);
insertNewsedge($conn, 'TOTAL', $dailyCounter, $weeklyCounter, $monthlyCounter, $totalCounter); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NewsEdge Reporting Dashboard</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<!-- JustGage Scripts -->
<script src="raphael-2.1.4.min.js" type="application/javascript"></script>
<script src="justgage-1.1.0.min.js" type="application/javascript"></script>
</head>

<body>
<div class="container">
  <div class="page-header">
    <h1>NewsEdge Reporting Dashboard</h1>
    <p class="lead">Developed by Davis Ford, this script pulls in category usage stats from multiple Wordpress installations.</p>
  </div>
  
  <!-- Gauge Section -->
  <div class="row">
    <div class="col-md-2"></div>
    
    <div class="col-md-8 col-sm-12" id="gauge" style="height:250px;"></div>
    <script>
  	var g = new JustGage({
    	id: "gauge",
    	value: <?php echo $dailyCounter; ?>,
    	min: 0,
    	max: 50,
    	title: "Daily Quota"
  	});
	</script>
    
    <div class="col-md-2"></div>
    <!-- filler --> 
  </div>
  <div class="row clearfix"></div>
  <div class="row">
    <div class="col-md-4"> <!-- Start of 3column area -->
      <div class="row"> <!-- Start of row within a column-->
        <div class="col-md-2"></div>
        <!-- spacer colum -->
        <div class="col-md-8"> <!-- Start of new column within that row -->
          <center>
            <h3>Total</h3>
          </center>
          <ul class="list-group">
            <li class="list-group-item"> <span class="badge"><?php echo $dailyCounter; ?></span> Today: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $weeklyCounter; ?></span> This Week: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $monthlyCounter; ?></span> This Month: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $totalCounter; ?> </span> All Time: </li>
          </ul>
          <center>
            <em style="font-size:8pt;">combined data</em>
          </center>
        </div>
        <div class="col-md-2"></div>
        <!-- spacer colum --> 
      </div>
      <!-- end of row --> 
    </div>
    <!-- end of col-md-4 -->
    
    <div class="col-md-4"> <!-- Start of 3column area -->
      <div class="row"> <!-- Start of row within a column-->
        <div class="col-md-2"></div>
        <!-- spacer colum -->
        <div class="col-md-8"> <!-- Start of new column within that row -->
          <center>
            <h3>ALPAC</h3>
          </center>
          <ul class="list-group">
            <li class="list-group-item"> <span class="badge"><?php echo $daily_ALPAC; ?></span> Today: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $weekly_ALPAC; ?></span> This Week: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $monthly_ALPAC; ?></span> This Month: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $total_ALPAC; ?> </span> All Time: </li>
          </ul>
          <center>
            <em style="font-size:8pt;">AmericanLibertyPAC.com</em>
          </center>
        </div>
        <div class="col-md-2"></div>
        <!-- spacer colum --> 
      </div>
      <!-- end of row --> 
    </div>
    <!-- end of col-md-4 -->
    
    <div class="col-md-4"> <!-- Start of 3column area -->
      <div class="row"> <!-- Start of row within a column-->
        <div class="col-md-2"></div>
        <!-- spacer colum -->
        <div class="col-md-8"> <!-- Start of new column within that row -->
          <center>
            <h3>JGM</h3>
          </center>
          <ul class="list-group">
            <li class="list-group-item"> <span class="badge"><?php echo $daily_JGM; ?></span> Today: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $weekly_JGM; ?></span> This Week: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $monthly_JGM; ?></span> This Month: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $total_JGM; ?> </span> All Time: </li>
          </ul>
          <center>
            <em style="font-size:8pt;">MinutemanProject.com</em>
          </center>
        </div>
        <div class="col-md-2"></div>
        <!-- spacer colum --> 
      </div>
      <!-- end of row --> 
    </div>
    <!-- end of col-md-4 --> 
  </div>
  <div class="row"> <!-- Start of row -->
    
    <div class="col-md-4"> <!-- Start of 3column area -->
      <div class="row"> <!-- Start of row within a column-->
        <div class="col-md-2"></div>
        <!-- spacer colum -->
        <div class="col-md-8"> <!-- Start of new column within that row -->
          <center>
            <h3>SAA</h3>
          </center>
          <ul class="list-group">
            <li class="list-group-item"> <span class="badge"><?php echo $daily_SAA; ?></span> Today: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $weekly_SAA; ?></span> This Week: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $monthly_SAA; ?></span> This Month: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $total_SAA; ?> </span> All Time: </li>
          </ul>
          <center>
            <em style="font-size:8pt;">SeniorAmericansAssociation.com</em>
          </center>
        </div>
        <div class="col-md-2"></div>
        <!-- spacer colum --> 
      </div>
      <!-- end of row --> 
    </div>
    <!-- end of col-md-4 -->
    
    <div class="col-md-4"> <!-- Start of 3column area -->
      <div class="row"> <!-- Start of row within a column-->
        <div class="col-md-2"></div>
        <!-- spacer colum -->
        <div class="col-md-8"> <!-- Start of new column within that row -->
          <center>
            <h3>SRC</h3>
          </center>
          <ul class="list-group">
            <li class="list-group-item"> <span class="badge"><?php echo $daily_SRC; ?></span> Today: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $weekly_SRC; ?></span> This Week: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $monthly_SRC; ?></span> This Month: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $total_SRC; ?> </span> All Time: </li>
          </ul>
          <center>
            <em style="font-size:8pt;">SelfRelianceCentral.com</em>
          </center>
        </div>
        <div class="col-md-2"></div>
        <!-- spacer colum --> 
      </div>
      <!-- end of row --> 
    </div>
    <!-- end of col-md-4 -->
    
    <div class="col-md-4"> <!-- Start of 3column area -->
      <div class="row"> <!-- Start of row within a column-->
        <div class="col-md-2"></div>
        <!-- spacer colum -->
        <div class="col-md-8"> <!-- Start of new column within that row -->
          <center>
            <h3>CRN</h3>
          </center>
          <ul class="list-group">
            <li class="list-group-item"> <span class="badge"><?php echo $daily_CRN; ?></span> Today: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $weekly_CRN; ?></span> This Week: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $monthly_CRN; ?></span> This Month: </li>
            <li class="list-group-item"> <span class="badge"><?php echo $total_CRN; ?> </span> All Time: </li>
          </ul>
          <center>
            <em style="font-size:8pt;">ConservativeRepublicanNews.com</em>
          </center>
        </div>
        <div class="col-md-2"></div>
        <!-- spacer colum --> 
      </div>
      <!-- end of row --> 
    </div>
    <!-- end of col-md-4 --> 
  </div>
</div>
<!-- end of container -->
</body>
</html>
