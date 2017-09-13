<?php

$db = new mysqli("localhost", "root", "root", "db_name");
if ($db->connect_errno) {
	die("can't not connect the DB server!");
}
mysqli_set_charset($db, "utf8");
$file_ext = '.txt';
$is_preg = 0; //是否正则匹配（0|1）
$preg = '/(?<=喝).*(?=吗)/';
$sentence_arr = array(
	'.*(糖尿病|高血糖|血糖高).*饮食.*(注意|控制).*',
	'.*(糖尿病|高血糖|血糖高).*(值|多少).*控制.*',
	'.*(糖尿病|高血糖|血糖高).*(怎么?.*控制|控制饮食|注意什么).*',
	'.*(糖尿病|高血糖|血糖高).*是不是.*药物.*控制好.*',
	'.*(糖尿病|高血糖|血糖高).*食疗.*怎么做.*',
	'.*(糖尿病|高血糖|血糖高).*控制.*(不满意|不好|欠佳|差).*(怎么办)?.*',
	'.*(糖尿病|高血糖|血糖高).*(是否跟饮食有关).*',
	'.*(糖尿病|高血糖|血糖高).*(吃什么|吃多少).*控制血糖.*',
	'.*(糖尿病|高血糖|血糖高).*肉.*严格控制.*',
	'.*(糖尿病|高血糖|血糖高).*饭.*控制.*多少.*',
	'.*(高血压|血压高).*饮食.*(注意|控制).*',
	'.*(高血压|血压高).*(值|多少).*控制.*',
	'.*(高血压|血压高).*(怎么?.*控制|控制饮食|注意什么).*',
	'.*(高血压|血压高).*是不是.*药物.*控制好.*',
	'.*(高血压|血压高).*食疗.*怎么做.*',
	'.*(高血压|血压高).*控制.*(不满意|不好|欠佳|差).*(怎么办)?.*',
	'.*(高血压|血压高).*(是否跟饮食有关).*',
	'.*(高血压|血压高).*(吃什么|吃多少).*控制血糖.*',
	'.*(高血压|血压高).*肉.*严格控制.*',
	'.*(高血压|血压高).*饭.*控制.*多少.*',
);
//////////////////////////////////////////////////////
foreach ($sentence_arr as $key => $value) {
	$file = $key + 1;
	if (file_exists($file . $file_ext)) {
		sentenceOption($db, $file . $file_ext, $value);
	}
}
//插入数据库
function sentenceOption($db, $file, $sentence) {
	global $preg, $is_preg;
	$fp = fopen($file, 'r');
	if (!$fp) {
		fclose($fp);
		return false;
	}
	$sql = "insert into sentence(regular_expression)values ('$sentence')";
	if ($db->query($sql)) {
		$sentence_id = $db->insert_id;
		echo $sentence_id . "\n";
		$str = '';
		while (!feof($fp)) {
			$row = fgets($fp);
			if ($row == '') {
				continue;
			}
			$insert = explode('-->', $row);
			if (!empty($insert)) {
				$first = $insert[0] ? trim($insert[0]) : '';
				$second = $insert[1] ? trim($insert[1]) : '';
				if (!empty($first) && !empty($second)) {
					if ($is_preg == 1) {
						preg_match_all($preg, $first, $mat);
						$key = $mat ? $mat[0][0] : '';
						if (!empty($key)) {
							$key = $key;
						}
					} else {
						$key = '';
					}
					$sql = "insert into qa_lib(`query`,`answer`)values('$first','$second')";
					if ($db->query($sql)) {
						$qa_lib_id = $db->insert_id;
						echo $qa_lib_id . '插入表qa_lib  ok' . "\n";
						$str .= "('" . $qa_lib_id . "'," . "'" . $sentence_id . "'" . ",'" . $key . "')" . ',';
					}
				}
			}
		}
		fclose($fp);
		$strr = substr($str, 0, -1);
		$sql = "insert into qa_key_info(qa_lib_id,sentence_id,`key`)values" . $strr;
		$db->query($sql);
		echo '插入qa_key_info完成';
		echo "\n";
	}
}
