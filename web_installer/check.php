<?php

$key = $_GET['key'];

$result = true;
$message = '';

switch ($key) {
    case "directoryPermission" :
        $checkFile = '/checkFile';

        $paths = [
            realpath( __DIR__ . '/../bootstrap/cache'),
            realpath( __DIR__ . '/../config/cms'),
            realpath( __DIR__ . '/../storage/'),
        ];

        foreach ($paths as $path) {
            $fp = @fopen($path . $checkFile, 'a');
            if ($fp === false) {
                $result = false;
                $message = 'Write permission required to "'.$path.'" directory ';
                break;
            } else {
                fclose($fp);
                unlink($path.$checkFile);
            }
        }

        break;

    case "envFile" :
        $path = realpath(__DIR__ . '/../').'/.env';
        if (file_exists($path) === false) {
            $result = false;
            $message = 'Make ".env"('.$path.') file ';
        } else if (is_writable($path) === false) {
            $result = false;
            $message = 'Write permission required to ".env"('.$path.') file';
        }

        break;

    case "phpVersion" :
        $phpVersion = 50509;
        $result = PHP_VERSION_ID < $phpVersion ? false : true;
        break;

    case "mcrypt" :
        $result = extension_loaded('mcrypt');
        break;

    case "curl" :
        $result = extension_loaded('curl');
        break;

    case "gd" :
        $result = extension_loaded('gd');
        break;
}

echo json_encode([
    'result' => $result,
    'message' => $message,
]);
