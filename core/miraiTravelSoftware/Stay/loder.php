<?php

$path = "core/miraiTravelSoftware/stay/Events";
$coreFiles = scandir($path);
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./$path/$coreFile";
    }
}

$path = "core/miraiTravelSoftware/stay/Protocols";
$coreFiles = scandir($path);
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./$path/$coreFile";
    }
}

$path = "core/miraiTravelSoftware/stay/Protocols/Http";
$coreFiles = scandir($path);
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./$path/$coreFile";
    }
}

$path = "core/miraiTravelSoftware/stay/Protocols/Http/Session";
$coreFiles = scandir($path);
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./$path/$coreFile";
    }
}


$path = "./core/miraiTravelSoftware/stay/Connection";
$coreFiles = scandir($path);
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./$path/$coreFile";
    }
}
