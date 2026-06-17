<?php
/**
 * Laravel cPanel Packaging Script
 * Run locally: php package.php
 * Creates deploy.zip ready to upload to cPanel
 */

$projectRoot = __DIR__;
$publicSrc   = $projectRoot . '/public';
$deployDir   = $projectRoot . '/deploy';
$publicDst   = $deployDir . '/public_html';
$coreDst     = $deployDir . '/laravel';

// Clean old deploy folder
if (is_dir($deployDir)) {
    system("rm -rf " . escapeshellarg($deployDir));
}
mkdir($deployDir);
mkdir($publicDst, 0777, true);
mkdir($coreDst, 0777, true);

// Copy Laravel core (everything except /public)
$exclude = ['public', 'deploy'];
$dirIterator = new RecursiveDirectoryIterator($projectRoot, RecursiveDirectoryIterator::SKIP_DOTS);
$iterator = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);

foreach ($iterator as $item) {
    $path = $iterator->getSubPathName();
    $parts = explode(DIRECTORY_SEPARATOR, $path);
    if (in_array($parts[0], $exclude)) continue;

    $destPath = $coreDst . '/' . $path;
    if ($item->isDir()) {
        mkdir($destPath, 0777, true);
    } else {
        copy($item, $destPath);
    }
}

// Copy public files into public_html
$dirIterator = new RecursiveDirectoryIterator($publicSrc, RecursiveDirectoryIterator::SKIP_DOTS);
$iterator = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);

foreach ($iterator as $item) {
    $path = $iterator->getSubPathName();
    $destPath = $publicDst . '/' . $path;
    if ($item->isDir()) {
        mkdir($destPath, 0777, true);
    } else {
        copy($item, $destPath);
    }
}

// Fix index.php paths
$indexPath = $publicDst . '/index.php';
if (file_exists($indexPath)) {
    $indexContent = file_get_contents($indexPath);
    $indexContent = str_replace(
        "__DIR__.'/../vendor/autoload.php'",
        "__DIR__.'/../laravel/vendor/autoload.php'",
        $indexContent
    );
    $indexContent = str_replace(
        "__DIR__.'/../bootstrap/app.php'",
        "__DIR__.'/../laravel/bootstrap/app.php'",
        $indexContent
    );
    file_put_contents($indexPath, $indexContent);
}

// Create zip archive
$zip = new ZipArchive();
$zipFile = $projectRoot . '/deploy.zip';
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($deployDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    foreach ($files as $file) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($deployDir) + 1);
        $zip->addFile($filePath, $relativePath);
    }
    $zip->close();
    echo "✅ deploy.zip created successfully!\n";
} else {
    echo "❌ Failed to create zip file.\n";
}
