<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, height=device-height, inital-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="static/login.css" type="text/css" media="all" />
        <title>文件上传</title>
        <script>
            function uploadFun(){
                //var form = document.getElementById('upload_form');
                //console.log(form.submit());
                //frm.reset()
            }
        </script>
    </head>
    
    <body>
        <div><a href="./admin.php">管理页面</a></div>
        </br>
        <div>
            <span>上传文件</span></br>
            <form enctype="multipart/form-data" action="upload.php" id='upload_form' method="POST">
                <input type="hidden" name="MAX_FILE_SIZE" value=104857600 />
                uid：<input type="number" name="uid"  /></br>
                code：<input type="text" name="code" /></br>
                file: <input name="file" type="file" required/></br>
                <input type="submit" value="Send File" />
            </form>
        <div>
        </br>
        <div>
        <span>删除文件</span></br>
            <form enctype="multipart/form-data" action="delete.php" id='delete_form' method="POST">
                filename: <input type="text" name="filename" /></br>
                code：<input type="text" name="code" /></br>
                <input type="submit" value="Delete File" />
            </form>
        </div>
    </body>
</html>