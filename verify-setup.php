<?php

/**
 * Setup Verification Script untuk Arsip Digital USBR
 * Run: php verify-setup.php
 */

echo "\n";
echo "════════════════════════════════════════════════════════════════════════════════════\n";
echo "   ARSIP DIGITAL USBR - SETUP VERIFICATION\n";
echo "════════════════════════════════════════════════════════════════════════════════════\n\n";

$checks = [];

// PHP Version
$phpVersion = phpversion();
$phpVersionOK = version_compare($phpVersion, '8.1', '>=');
$checks[] = [
    'name' => 'PHP Version',
    'current' => $phpVersion,
    'required' => '8.1+',
    'status' => $phpVersionOK
];

// Check Extensions
$extensions = ['curl', 'fileinfo', 'filter', 'gd', 'hash', 'mbstring', 'openssl', 'pdo', 'pdo_mysql'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    $checks[] = [
        'name' => "Extension: $ext",
        'current' => $loaded ? 'Loaded' : 'Not Loaded',
        'required' => 'Loaded',
        'status' => $loaded
    ];
}

// Check Directories
$dirs = [
    'storage' => 'Storage Directory',
    'bootstrap/cache' => 'Bootstrap Cache Directory',
    'database' => 'Database Directory',
    'app' => 'App Directory'
];

foreach ($dirs as $dir => $name) {
    $exists = is_dir($dir);
    $writable = $exists ? is_writable($dir) : false;
    $checks[] = [
        'name' => "$name (writable)",
        'current' => $exists ? ($writable ? 'Writable' : 'Not Writable') : 'Not Found',
        'required' => 'Writable',
        'status' => $writable
    ];
}

// Check Files
$files = [
    'composer.json' => 'Composer Config',
    'package.json' => 'NPM Config',
    '.env.example' => 'Environment Example',
    'artisan' => 'Laravel CLI',
    'public/index.php' => 'Entry Point'
];

foreach ($files as $file => $name) {
    $exists = file_exists($file);
    $checks[] = [
        'name' => $name,
        'current' => $exists ? 'Found' : 'Not Found',
        'required' => 'Found',
        'status' => $exists
    ];
}

// Check Configuration Uploads
$uploads = [
    '.htaccess' => '.htaccess Config',
    '.user.ini' => 'PHP Configuration',
    'NIAGAHOSTER_SETUP.md' => 'Setup Guide',
    'QUICK_DEPLOY.sh' => 'Deploy Script'
];

foreach ($uploads as $file => $name) {
    $exists = file_exists($file);
    $checks[] = [
        'name' => $name,
        'current' => $exists ? 'Found' : 'Not Found',
        'required' => 'Found',
        'status' => $exists
    ];
}

// Display Results
$passed = 0;
$failed = 0;

echo "VERIFICATION RESULTS:\n\n";

foreach ($checks as $check) {
    $status = $check['status'] ? '✓' : '✗';
    $color = $check['status'] ? "\033[32m" : "\033[31m";
    $reset = "\033[0m";
    
    if ($check['status']) {
        $passed++;
    } else {
        $failed++;
    }
    
    printf(
        "%s %s %s - Current: %s (Required: %s)\n",
        $color . $status . $reset,
        str_pad($check['name'], 35),
        str_repeat(".", max(0, 50 - strlen($check['name']))),
        $check['current'],
        $check['required']
    );
}

echo "\n════════════════════════════════════════════════════════════════════════════════════\n";
echo "SUMMARY\n";
echo "════════════════════════════════════════════════════════════════════════════════════\n";
printf("Passed: \033[32m%d\033[0m\n", $passed);
printf("Failed: \033[31m%d\033[0m\n", $failed);
echo "\n";

if ($failed === 0) {
    echo "\033[32m✓ All checks passed! Ready for deployment.\033[0m\n\n";
} else {
    echo "\033[31m✗ Some checks failed. Please fix the issues above.\033[0m\n\n";
}

echo "════════════════════════════════════════════════════════════════════════════════════\n\n";