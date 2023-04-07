<?php

$path = "core/miraiTravelSoftware/Stay/Events";
$coreFiles = scandir($path);
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./$path/$coreFile";
    }
}

$path = "core/miraiTravelSoftware/Stay/Protocols";
$coreFiles = scandir($path);
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./$path/$coreFile";
    }
}

$path = "core/miraiTravelSoftware/Stay/Protocols/Http";
$coreFiles = scandir($path);
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./$path/$coreFile";
    }
}

$path = "core/miraiTravelSoftware/Stay/Protocols/Http/Session";
$coreFiles = scandir($path);
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./$path/$coreFile";
    }
}


$path = "./core/miraiTravelSoftware/Stay/Connection";
$coreFiles = scandir($path);
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./$path/$coreFile";
    }
}
