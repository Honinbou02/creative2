<?php

// Define the path to update.txt and the source directory for the files
$updateTxtPath = __DIR__ . '/update.txt';  // Path to your update.txt in the Laravel root
$sourceDirectory = __DIR__;  // Use the current directory (which should be the root of your Laravel project)
$uploadDirectory = __DIR__ . '/update_uploads'; // Save files into the 'update_uploads' directory

// Check if update.txt exists
if (!file_exists($updateTxtPath)) {
    die("The update.txt file does not exist.\n");
}

// Read the update.txt file into an array of file paths
$updateInstructions = file($updateTxtPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (!$updateInstructions) {
    die("Failed to read update.txt or it is empty.\n");
}

// Create the 'update_uploads' directory if it doesn't exist
if (!is_dir($uploadDirectory)) {
    if (!mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $uploadDirectory));
    }  // Create the 'update_uploads' directory with correct permissions
    echo "Created directory: $uploadDirectory\n";
}

// Iterate over the file paths in update.txt
foreach ($updateInstructions as $filePath) {
    $sourceFilePath = $sourceDirectory . '/' . $filePath;  // Full source path relative to Laravel root
    $destinationFilePath = $uploadDirectory . '/' . $filePath;  // Destination path inside 'update_uploads'

    // Check if the source file exists
    if (file_exists($sourceFilePath)) {
        // Get the directory part of the destination file path
        $destinationDir = dirname($destinationFilePath);

        // Create the directory if it doesn't exist
        if (!is_dir($destinationDir)) {
            if (!mkdir($destinationDir, 0755, true) && !is_dir($destinationDir)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $destinationDir));
            }  // Create the directory with correct permissions
            echo "Created directory: $destinationDir\n";
        }

        // Copy the file to the destination
        if (copy($sourceFilePath, $destinationFilePath)) {
            echo "Copied: $filePath\n";
        } else {
            echo "Failed to copy: $filePath\n";
        }
    } else {
        echo "File not found: $filePath\n";
    }
}

echo "Update process completed!\n";

echo "===============================================\n";
echo "*************** ThemeTags Bot v1.0 ***************\n";
echo "===============================================\n";
echo "\n";


echo "                  ###       ###\n";
echo "                ###       ###\n";
echo "        ##########################\n";
echo "   #########################\n";
echo "         ###       ###\n";
echo "       ###       ###\n";


echo "===============================================\n";


// Define the folder and zip file paths
$folderToZip = __DIR__ . '/update_uploads'; // Path to the folder to zip
$zipFile = __DIR__ . '/update_uploads.zip'; // Name of the zip file

// Check if the folder exists
if (!is_dir($folderToZip)) {
    die("The folder $folderToZip does not exist.\n");
}

// Check if a file already exists and rename it before zipping
if (file_exists($zipFile)) {
    // Change the name of the zip file to avoid overwriting it
    $timestamp = time();
    $zipFile = __DIR__ . "/update_uploads.zip";
}

// Create a new ZipArchive instance
$zip = new ZipArchive();

// Open the zip file for writing (create it if it doesn't exist)
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    // Recursively add files and folders to the zip
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($folderToZip),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $file) {
        // Skip directories (we only want files)
        if ($file->isDir()) {
            continue;
        }

        // Get the relative path of the file inside the zip
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($folderToZip) + 1);

        // Add the file to the zip archive
        $zip->addFile($filePath, $relativePath);
    }

    // Close the zip file
    $zip->close();

    echo "Zip file created successfully: $zipFile\n";
} else {
    echo "Failed to create the zip file.\n";
}

?>
