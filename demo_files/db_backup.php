<?php

$db_name = "yuyue_shop";
$dir = "backup/$db_name";
if (!is_dir($dir)) {
    if (!mkdir($dir, 0777, TRUE)) {
        die('<p>无法创建备份目录</p>');
    }
}
$time = time();
$dbc = mysqli_connect('localhost', 'root', 'root', $db_name, '3306') or die('The database ' . $db_name . '-could not be backed up.' . '<br>');
mysqli_query($dbc, "set charset gbk");
$r = mysqli_query($dbc, 'show tables;');
if (mysqli_num_rows($r) > 0) {
    echo 'Backing up datase: ' . $db_name . '<br>';
    while (list($table) = mysqli_fetch_array($r, MYSQLI_NUM)) {
        $q = "select * from " . $table;
        $r2 = mysqli_query($dbc, $q);
        if (mysqli_num_rows($r2) > 0) {
            if ($fp = gzopen("$dir/{$table}_{$time}.sql.gz", 'w9')) {
                while ($row = mysqli_fetch_array($r2, MYSQLI_NUM)) {
                    foreach ($row as $key => $value) {
                        $value = addslashes($value);
                        gzwrite($fp, "'$value',");
                    }
                    gzwrite($fp, '\n');
                }
                gzclose($fp);
                echo "$table" . ' backed up.' . '<br>';
            }
            else {
                echo "The file -$dir/{$table}_{$time}.sql.gz--could not be opend for writing." . '<br>';
                break;
            }
        }
    }
}
else {
    echo 'The submitted database--' . $db_name . '--contains no tables.' . '<br>';
}
