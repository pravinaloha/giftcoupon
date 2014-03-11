
<?php

// Connecting, selecting database
$link = mysql_connect('localhost', 'magento_dbuser', 'fascinations') or die('Could not connect: ' . mysql_error());
echo 'Connected successfully';
mysql_select_db('magento') or die('Could not select database');

$delete = 0;

if ($delete) {
    
    // Performing SQL query
    $query = "delete FROM cron_schedule where job_code = 'bloyal_product_updater'";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());
    
    echo 'deleted successfully';
}

// Performing SQL query
$query = "SELECT * FROM cron_schedule where status = 'running' order by schedule_id desc";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$cnt = 0;
// Printing results in HTML
echo '<pre>';
echo "<table>\n";
while ($line = mysql_fetch_assoc($result)) {
    echo '<br>=====================================================';
    print_r($line);
    if ($cnt > 10)
        exit;

    $cnt++;
}
echo "</table>\n";

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);
?>
