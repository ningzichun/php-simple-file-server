<?php
require("./config.php");
header("Content-type:application/json");


if ($_SERVER['REQUEST_METHOD']!='POST'){    #非POST请求
    returnJson(200,"请使用POST请求");
}


# 获取信息
if(!isset($_POST["code"])){
    returnJson(403,"缺少code");
}
$code = $_POST["code"];
if($code!=$code_from_api and $code!=$code_from_admin){
    returnJson(403,"code无效");
}

if(!isset($_POST["filename"])){
    returnJson(403,"缺少filename");
}
$filename = $_POST["filename"];
$md5 = substr($filename,0,strrpos($filename,'.'));



# 写入数据库
require_once('./database.php');
delLog($db,$md5);
$db->close();

if(file_exists($filedir.$filename)){
    if(unlink(($filedir.$filename))){
        returnJson(200,"文件删除成功");
    }
    else{
        returnJson(500,"文件删除失败");
    }
}
else{
    returnJson(403,"文件不存在");
}

?>