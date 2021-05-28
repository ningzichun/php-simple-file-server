<?php
require("./config.php");

header("Content-type:application/json");



# 检测剩余空间
if (disk_free_space('.') < 1024*1024*100){   # 预留100MB空间
    returnJson(500,"服务器剩余空间不足");
}

if ($_SERVER['REQUEST_METHOD']!='POST'){    #非POST请求
    returnJson(403,"请使用POST请求");
}


# 鉴权
if(!isset($_POST["uid"])){
    returnJson(403,"缺少uid");
}
$uid = $_POST["uid"];

if(!isset($_POST["code"])){
    returnJson(403,"缺少code");
}
$code = $_POST["code"];
if($code!=$code_from_api and $code!=$code_from_admin){
    returnJson(403,"code无效");
}

# 从POST获取文件

$file = $_FILES["file"]["name"];    # 获取原始文件名
$ext = substr($file,strrpos($file,".")); # 获取文件后缀名
$md5 = md5($file);  # 设置新文件名

$temp = explode(".", $file);
# if ($_FILES["file"]["size"] > 1024*1024*100)

if ($_FILES["file"]["error"] > 0){
    $result = array(
        "code" => 500,
        "msg" => "上传失败：".$_FILES["file"]["error"]
    );
    header ("HTTP/1.1 500 Internal Server Error");
    echo json_encode($result,true);
    exit();    
}

if(!move_uploaded_file($_FILES["file"]["tmp_name"], $filedir. $md5.$ext)){
    returnJson(500,"图片保存失败");
}

$imgurl = $_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['HTTP_HOST'].substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],'/')+1).$filedir.$md5.$ext;
   
$result = array(
    "code" => 200,
    "msg" => "上传成功",
    "data" => array(
        "url" => $imgurl,
        "origin" => $_FILES["file"]["name"],
        "type" => $_FILES["file"]["type"],
        "size" => $_FILES["file"]["size"],
    )
);

echo json_encode($result,true);


# 写入数据库
require_once('./database.php');
newLog($db,$md5,$uid,$file,$_FILES["file"]["size"],$md5.$ext);
$db->close();

 
# 另 删除逻辑：根据最后修改时间设置过期值 等到应该维护的时候 例如定时任务 删除过期的文件


?>