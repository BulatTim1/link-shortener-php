<?php
//ini_set("xdebug.overload_var_dump", "off");
require_once $_SERVER['DOCUMENT_ROOT'].'/app/libs/Database.php';

function generateRandomString($length = 6){
    $chars = "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789";
    $sets = explode('|', $chars);
    $all = '';
    $randString = '';
    foreach($sets as $set){
        $randString .= $set[array_rand(str_split($set))];
        $all .= $set;
    }
    $all = str_split($all);
    for($i = 0; $i < $length - count($sets); $i++){
        $randString .= $all[array_rand($all)];
    }
    return str_shuffle($randString);
}

function checkUniqueLink($url)
{
    $db = new Database();
    $sql = "SELECT * FROM links WHERE short_link = :url";
    $result = Database::query($sql, ['url' => $url], true);
    if (count($result) > 0) {
        return false;
    } else {
        return true;
    }
}

function normalizeLink($url)
{
    $url = strpos($url, 'http') === 0 ? $url : 'http://'.$url;
    $url = trim($url);
    return $url;
}

if(isset($_POST['url'])) {
    $url = $_POST['url'];
    $url = normalizeLink($url);
    $short_url = generateRandomString();
    while(!checkUniqueLink($short_url)) {
        $short_url = generateRandomString();
    }
    if (strlen($short_url) > 5) {
        Database::query('INSERT INTO links (link, short_link) VALUES (:link, :short_link)', [
                'short_link' => $short_url,
                'link' => $url,
            ]
        );
        echo $short_url;
    } else {
        echo 'Не удалось создать короткую ссылку';
    }
} else {
    echo 'Не задана ссылка';
}
