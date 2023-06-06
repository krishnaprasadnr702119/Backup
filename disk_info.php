<?php
$diskData = array(
  'total_space' => disk_total_space("/"), // Total disk space in bytes
  'used_space' => disk_total_space("/") - disk_free_space("/") // Used disk space in bytes
);

// Convert bytes to gigabytes
$diskData['total_space'] = round($diskData['total_space'] / (1024 * 1024 * 1024), 2);
$diskData['used_space'] = round($diskData['used_space'] / (1024 * 1024 * 1024), 2);

echo json_encode($diskData);
?>

