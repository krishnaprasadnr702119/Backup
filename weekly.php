<!DOCTYPE html>
<html>
<head>
    <title>File Manager </title>
    <style>
        /* Add some basic styles to enhance the appearance */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #0000EE;
        }
        /* Updated styles */
        html {
            box-sizing: border-box;
        }
        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }
        body {
            padding: 2px;
            outline: 8px solid #ddd;
            background-color: black;
            color: red;
        }
        table {
            background-color: black;
        }
        th {
            background-color: #333;
            color: white;
        }
        td {
            color: red;
        }
        a {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>File Manager</h1>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Created Time</th>
                    <th>Hash</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Set the server directory path
                    $directory = '/backup/Weekly'; // Set the server directory here

                    // Retrieve the current directory path from the query string
                    $currentDirectory = isset($_GET['path']) ? $_GET['path'] : '';

                    // Get the absolute path of the current directory
                    $absolutePath = realpath($directory . '/' . $currentDirectory);

                    // Ensure the current directory is within the specified server directory
                    if (strpos($absolutePath, $directory) !== 0) {
                        $absolutePath = realpath($directory);
                        $currentDirectory = '';
                    }

                    // Retrieve the list of files and directories in the current directory
                    $files = scandir($absolutePath);

                    // Loop through the files and directories, excluding . and ..
                    foreach ($files as $file) {
                        if ($file != '.' && $file != '..') {
                            // Determine the file type (directory or file)
                            $path = $currentDirectory . '/' . $file;
                            $isDirectory = is_dir($absolutePath . '/' . $file);

                            // Output each entry as a table row
                            echo '<tr>';
                            echo '<td>' . ($isDirectory ? 'Directory' : getFileType($file)) . '</td>';
                            echo '<td>';
                            if ($isDirectory) {
                                echo '<a href="' . ($_SERVER['PHP_SELF'] . '?path=' . urlencode($path)) . '">';
                                echo $file;
                                echo '</a>';
                            } else {
                                if (isTextFile($file)) {
                                    echo '<a href="' . ($directory . '/' . $path) . '" target="_blank">';
                                    echo $file;
                                    echo '</a>';
                                } else {
                                    echo $file;
                                }
                            }
                            echo '</td>';

                            // Display the file size, creation time, and hash value
                            if (!$isDirectory) {
                                $filePath = $absolutePath . '/' . $file;
                                $size = filesize($filePath);
                                $createdTime = date('Y-m-d H:i:s', filectime($filePath));
                                $hash = md5_file($filePath);

                                echo '<td>' . formatSizeUnits($size) . '</td>';
                                echo '<td>' . $createdTime . '</td>';
                                echo '<td>' . $hash . '</td>';
                            } else {
                                echo '<td>-</td>';
                                echo '<td>-</td>';
                                echo '<td>-</td>';
                            }

                            echo '</tr>';
                        }
                    }

                    // Function to determine the file type based on its extension
                    function getFileType($file) {
                        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $compressedFormats = ['zip', 'rar', 'tar', 'gz'];

                        if (in_array($extension, $compressedFormats)) {
                            return 'Compressed';
                        }

                        return 'File';
                    }

                    // Function to check if a file is a text file based on its extension
                    function isTextFile($file) {
                        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $textFormats = ['txt', 'log', 'csv'];

                        return in_array($extension, $textFormats);
                    }

                    // Function to format file size for better readability
                    function formatSizeUnits($bytes) {
                        if ($bytes >= 1073741824) {
                            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
                        } elseif ($bytes >= 1048576) {
                            $bytes = number_format($bytes / 1048576, 2) . ' MB';
                        } elseif ($bytes >= 1024) {
                            $bytes = number_format($bytes / 1024, 2) . ' KB';
                        } elseif ($bytes > 1) {
                            $bytes = $bytes . ' bytes';
                        } elseif ($bytes == 1) {
                            $bytes = $bytes . ' byte';
                        } else {
                            $bytes = '0 bytes';
                        }

                        return $bytes;
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

