<?php
/* credentials */

$db_user = 'infratest';
$db_pass = 'infra1234';
/* FIX THIS LATER */
/* $db_host = 'app'; */
$db_host = 'localhost';
$db_database = "infratest";

$memcache_host = 'front';

/* MySQL */
try {
     $db_link = mysql_connect($db_host, $db_user, $db_pass);

     if (!$db_link) {
	  $db_result = "<p>Error: Could not connect to db host '" . $db_host . "</p>";
     } else {
	  mysql_select_db($db_database, $db_link);

	  $result = mysql_query("INSERT INTO test VALUES(null, " . mysql_real_escape_string(rand(100000, 999999)) . ", NOW() )");
	  if (!$result) {
	       $db_result = "<p>Error: Could not insert into database" . htmlentities(mysql_error($db_link)) . "</p>" . $db_link;
	  } else {

	       $result = mysql_query("SELECT * from test ORDER BY id DESC LIMIT 0, 25");
	       if (!$result) {
		    $db_result = "<p>Error: Could not read from database" . htmlentities(mysql_error($db_link)) . "</p>";
	       } else {
		    $cached_val = null;
		    $db_result = "<p>DB Read and Write successful</p>\n";

		    $db_result .= "<h3>Recent Rows:</h3>\n <ul>\n";
		    while ($row = mysql_fetch_assoc($result)) {
			 $line = "<li>ID: " . htmlentities($row["id"]) . " Value: " . htmlentities($row["value"]) . " Created at: " . htmlentities($row["created_at"]) . "</li>\n";
			 $db_result .= $line;
			 
			 if (!$cached_val) {
			      $cached_val = $line;
			 }
		    }
		    $db_result .= "</ul>\n";
	       }
	  }
	  
	  mysql_close();
     }
} catch (Exception $e) {
      $db_result = "<p>Error with DB Test: " . htmlentities($e->getMessage()) . "</p>";
}


/* Memcache Tests */
try {
     
     $memcache = new Memcache;
     $memcache->addServer($memcache_host, 11211);
     
     if ( $memcache->set('infratest_memcache', $cached_val) ) {
	  $memcache_result = "<p>Set memcache value successfully</p>";
	  $memcache_result .= "GET value: " . htmlentities($memcache->get('infratest_memcache'));
     }
     else {
	  $memcache_result = "<p>Error: Did not set memcache value</p>";
     }
     
} catch (Exception $e) {
      $memcache_result = "<p>Error with Memcache Test: " . htmlentities($e->getMessage()) . "</p>";
}

/* Environment */
$env_result = "<ul>";
foreach ($_SERVER as $key => $value) {
     $env_result .= "<li>" . htmlentities($key) . " => " . htmlentities($value) . "</li>";
}
$env_result .= "</ul>";
?>
<html>
     <head>
	  <title>Infrastructure Engineer Test</title>
     </head>
     <body>

	  <h1>Infrastructure Engineer Test</h1>

	  <h2>Environment</h2>
<!--<?php echo $env_result; ?>-->

	  <h2>Mysql Test</h2>
	  <p><?php echo $db_result ?></p>

	  <h2>Memcache Test</h2>
	  <p><?php echo $memcache_result ?></p>

     </body>
</html>