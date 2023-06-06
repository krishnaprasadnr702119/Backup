<?php
// Execute the 'w' command to get the load average
$output = shell_exec('w');

// Return the output as the response
echo $output;
?>

