<?php
$filedir = "uploads/";

$code_from_api = 'travel';
$code_from_admin = 'FROM_ADMIN';

#error_reporting(0);

function mkdirs($dir, $mode = 0777)
{
    if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
    if (!mkdirs(dirname($dir), $mode)) return FALSE;
    return @mkdir($dir, $mode);
}
mkdirs($filedir);

function returnJson($code,$msg)
{
    $result = array(
        "code" => $code,
        "msg" => $msg
    );
    //if ($code==403) header ("HTTP/1.1 403 Forbidden");
    //if ($code==500) header ("HTTP/1.1 500 Internal Server Error");
    echo json_encode($result,true);
    exit();
}


?>