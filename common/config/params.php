<?php

use yii\base\Exception;
use yii\helpers\FileHelper;

/**
 * @param string $fileName
 * @return string
 * @throws Exception
 */
function jsonFile($fileName){
    $dir = __DIR__. '/json_params/';
    $file = $dir.$fileName.'.json';
    if (!is_dir($dir)){
        FileHelper::createDirectory($dir);
    }

    if (!is_file($file)){
        file_put_contents($file, '{}');
    }

    return json_decode(file_get_contents($file), true);
}

try {
    $contact = jsonFile('contact');
} catch (Exception $e) {
}

try {
    $history = jsonFile('history');
} catch (Exception $e) {
}

try {
    $library = jsonFile('library');
} catch (Exception $e) {
}

try {
    $shop = jsonFile('shop');
} catch (Exception $e) {
}

try {
    $school = jsonFile('school');
} catch (Exception $e) {
}

try {
    $sisterhood = jsonFile('sisterhood');
} catch (Exception $e) {
}

try {
    $privatePolicy = jsonFile('privatePolicy');
} catch (Exception $e) {
}

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@blagoapp.ru',
    'notificEmail' => 'support@blagoapp.ru',
    'user.passwordResetTokenExpire' => 3600,
    'Contact' => $contact,
    'ContactApi' => $contact,
    'History' => $history,
    'HistoryApi' => $history,
    'Library' => $library,
    'LibraryApi' => $library,
    'Shop' => $shop,
    'ShopApi' => $shop,
    'School' => $school,
    'SchoolApi' => $school,
    'Sisterhood' => $sisterhood,
    'SisterhoodApi' => $sisterhood,
    'PrivatePolicy' => $privatePolicy,
    'PrivatePolicyApi' => $privatePolicy,
];
