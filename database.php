<?php
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('log.db');
    }
}
$db = new MyDB();
if (!$db) {
    echo $db->lastErrorMsg();
}

$sql = <<<EOF
    CREATE TABLE IF NOT EXISTS t_file(
        md5  CHAR(32)  PRIMARY KEY   NOT NULL,
        uid  INT  NOT NULL,
        original_name CHAR(256),
        size INT NOT NULL,
        filename CHAR(256) NOT NULL,
        create_time TIMESTAMP NOT NULL DEFAULT current_timestamp,
        update_time TIMESTAMP NOT NULL DEFAULT current_timestamp
    );
EOF;

$ret = $db->exec($sql);
if (!$ret) {
    echo $db->lastErrorMsg();
}

function newLog($db, $md5, $uid, $ori, $size, $filename)
{
    
    $sql = sprintf("INSERT OR REPLACE INTO t_file (md5,uid,original_name,size,filename) VALUES ('%s',%d,'%s',%d,'%s' );", $md5, $uid, $ori, $size, $filename);
    $ret = $db->exec($sql);
    if (!$ret) {
        echo $db->lastErrorMsg();
    }
    return $ret;
}

function delLog($db, $md5)
{
    $sql = sprintf("DELETE from t_file WHERE md5='%s';", $md5);
    $ret = $db->exec($sql);
    if (!$ret) {
        echo $db->lastErrorMsg();
    }
    return $ret;
}

?>