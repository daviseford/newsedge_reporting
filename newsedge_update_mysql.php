<?php
$servername = "10.178.134.53"; //10.178.134.53 or db01

$username_ALPAC = "americanlib";
$password_ALPAC = "682z0U3K";
$dbname_ALPAC = "americanlib";
$cat_id_ALPAC = 1152;  //numeric cat_id of slug 'newsedge'

$username_JGM = "ucrdjzzn";
$password_JGM = "73y2L8sE";
$dbname_JGM = "minutemanproject_dreamho";
$cat_id_JGM = 835;  //numeric cat_id of slug 'newsedge'

$username_SAA = "senioraa";
$password_SAA = "QMha4AbW5+BD68C1iDZXnSVaLGs=";
$dbname_SAA = "senioraa_com";
$cat_id_SAA = 1373;  //numeric cat_id of slug 'newsedge'

$username_CRN = "conservative_rep";
$password_CRN = "7mfPxkr7qSPt4xYA";
$dbname_CRN = "conservativerepublicannews";
$cat_id_CRN = 1795;  //numeric cat_id of slug 'newsedge'

$username_SRC = "selfreliancecent";
$password_SRC = "z48jR8Mg9N";
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
		return 0;
	} 
	
	// This makes use of a typical category-selection statement for MySQL. 
	// We pass in two variables to control the request.
	
		$result = $conn->query(typicalSQL($cat_id, $post_offset));
		
	//echo $username . " " . var_dump($result) . "<br />"; //uncomment for debugging
	
	if($result->num_rows === null) {
		$result->num_rows = 0;
	}
	
	$conn->close();	
	
	echo $dbname . " rows = " . $result->num_rows . "<br />";
	
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
$total_ALPAC = sqlConnectionManager($servername, $username_ALPAC, $password_ALPAC, $dbname_ALPAC, $cat_id_ALPAC, 999);

$daily_JGM = sqlConnectionManagerJGM($servername, $username_JGM, $password_JGM, $dbname_JGM, $cat_id_JGM, 1);
$weekly_JGM = sqlConnectionManagerJGM($servername, $username_JGM, $password_JGM, $dbname_JGM, $cat_id_JGM, 8);
$total_JGM = sqlConnectionManagerJGM($servername, $username_JGM, $password_JGM, $dbname_JGM, $cat_id_JGM, 999);


$daily_SAA = sqlConnectionManager($servername, $username_SAA, $password_SAA, $dbname_SAA, $cat_id_SAA, 1);
$weekly_SAA = sqlConnectionManager($servername, $username_SAA, $password_SAA, $dbname_SAA, $cat_id_SAA, 8);
$total_SAA = sqlConnectionManager($servername, $username_SAA, $password_SAA, $dbname_SAA, $cat_id_SAA, 999);

$daily_CRN = sqlConnectionManager($servername, $username_CRN, $password_CRN, $dbname_CRN, $cat_id_CRN, 1);
$weekly_CRN = sqlConnectionManager($servername, $username_CRN, $password_CRN, $dbname_CRN, $cat_id_CRN, 8);
$total_CRN = sqlConnectionManager($servername, $username_CRN, $password_CRN, $dbname_CRN, $cat_id_CRN, 999);


$daily_SRC = sqlConnectionManager($servername, $username_SRC, $password_SRC, $dbname_SRC, $cat_id_SRC, 1);
$weekly_SRC = sqlConnectionManager($servername, $username_SRC, $password_SRC, $dbname_SRC, $cat_id_SRC, 8);
$total_SRC = sqlConnectionManager($servername, $username_SRC, $password_SRC, $dbname_SRC, $cat_id_SRC, 999);




$totalCounter = $total_SAA + $total_JGM + $total_ALPAC + $total_CRN + $total_SRC;
$weeklyCounter = $weekly_SAA + $weekly_JGM + $weekly_ALPAC + $weekly_CRN + $weekly_SRC;
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

function insertNewsedge($conn, $website_name, $posts_total, $posts_today, $posts_week) {
	
	$website_name = '"'.mysql_escape_mimic($website_name).'"';
	$posts_total = '"'.mysql_escape_mimic($posts_total).'"';
	$posts_today = '"'.mysql_escape_mimic($posts_today).'"';
	$posts_week = '"'.mysql_escape_mimic($posts_week).'"';

	$sql = "INSERT INTO Newsedge (website_name, posts_total, posts_today, posts_week)
	VALUES ($website_name, $posts_total, $posts_today, $posts_week) 
	ON DUPLICATE KEY UPDATE 
		posts_total = $posts_total,
		posts_today = $posts_today,
		posts_week = $posts_week";

	if ($conn->query($sql) === TRUE) {
	    echo "New ".$website_name." record created successfully<br />";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
insertNewsedge($conn, 'ALPAC', $total_ALPAC, $daily_ALPAC, $weekly_ALPAC); //should update with a total number
insertNewsedge($conn, 'JGM', $total_JGM, $daily_JGM, $weekly_JGM); //should update with a total number
insertNewsedge($conn, 'SAA', $total_SAA, $daily_SAA, $weekly_SAA); //should update with a total number
insertNewsedge($conn, 'CRN', $total_CRN, $daily_CRN, $weekly_CRN); //should update with a total number
insertNewsedge($conn, 'SRC', $total_SRC, $daily_SRC, $weekly_SRC); //should update with a total number

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>