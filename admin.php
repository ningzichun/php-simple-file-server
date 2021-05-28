<?php
require_once('./config.php');
session_start();
if ($_SERVER['REQUEST_METHOD']=='POST'){    #非POST请求
    if(!isset($_POST["pass"])){
        returnJson(403,"缺少口令");
    }
    if($_POST["pass"]!='travel'){
        returnJson(403,"口令无效");
    }
    $_SESSION["user_12"]=true;
}

if (null == $_SESSION['user_12']){
    print <<< END
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width, height=device-height, inital-scale=1.0, maximum-scale=1.0, user-scalable=no" />
            <link rel="stylesheet" href="static/login.css" type="text/css" media="all" />
            <title>登录到系统 - 学生选课信息管理系统</title>
        </head>
        
        <body>
            <div class="loginbox">
                <form action="" method="post">
                <div class="inputbox">
                    <span>口令</span>
                    <input name="pass" required type="password">
                </div>
                <div class="submitbox">
                    <input name="submit" type="submit" value="提交">
                </div>
                </form>
            </div>
        </body>
    </html>
END;
exit();
}

require_once('./database.php');

$sql = "SELECT * from t_file;";
$ret = $db->query($sql);
if($ret){
    echo "<table>";
    echo "<th>uid</td>";
    echo "<th>filename</td>";
    echo "<th>original_name</td>";
    echo "<th>size</td>";
    echo "<th>create_time</td>";
    echo "<th>update_time</td>";
    echo "<th>operation</td>";
}
while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
    echo "<tr><td>". $row['uid'] . "</td>";
    echo "<td><a target='_blank' href='".$filedir.$row['filename']."'>". $row['filename'] . "</a></td>";
    echo "<td>". $row['original_name'] . "</td>";
    echo "<td>". $row['size'] . "</td>";
    echo "<td>". $row['create_time'] . "</td>";
    echo "<td>". $row['update_time'] . "</td>";
    echo "<td><form action='delete.php' method='post' <form><input type='hidden' name='filename' value='".$row['filename']."' ><input type='hidden' name='code' value='FROM_ADMIN' > <input type='submit' value='删除' /></form></td></tr>";
}
echo "</table>";
$db->close();

?>