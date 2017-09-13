<?php

date_default_timezone_set("Asia/Shanghai");
/**
 * 单线程&多线程抓取url嵌套的数据
 */
require 'CurlGetContents.class.php';
$curl = new CurlGetContents();
//1.初始化数据(每项都需单独配置)
$source_url_format = 'http://www.zimuzu.tv/subtitle?page='; //source_url的格式（必须）
$start_index = 1;
$end_index = 1;
$prefix_source = 'http://www.zimuzu.tv'; //源网页的正则前缀
$prefix_downlaod = ''; //子网页的正则前缀
$preg_source = '/\/subtitle\/\d+/'; //源网页的正则
$preg_download = '/http:\/\/tu.zmzjstu.com\/ftp\/.*(zip|rar)(?=")/'; //下载网页的正则
$postfix = '.rar'; //默认下载文件的格式
$is_in_time = 0; //抓取的download_url是否是永久的，默认为不过期，下载后用迅雷下载（有些网站下载链接会过期，就同步下载文件）
$is_sync = 1; //是否并发跑
//2.初始化文件（自定义）
$download_path = 'downloads/';
$file_s = 'source_success_urls.txt';
$file_e = 'source_error_urls.txt';
$file_d_s = 'downfile_success_urls.txt';
$file_d_e = 'downfile_error_urls.txt';
$file_unmatch = 'unmatch.txt'; //未匹配到源网页的记录
//3.执行抓取
$curl_type = $is_sync == 1 ? 1 : 0;
if (file_exists($file_s) && filesize($file_s) > 0) {
	/**
	 * 从下载的列表页URL文件-》获得下载rar|zip的URL
	 */
	//打开下载的urls
	$fp_s = fopen($file_s, 'r'); //打开下载源表
	$fp_d_s = fopen($file_d_s, 'w+'); //建立下载文件（成功）
	$fp_d_e = fopen($file_d_e, 'w+'); //建立下载文件（失败）
	$fp_unmatch = fopen($file_unmatch, 'w+'); //建立下载文件（失败）
	$rows = array();
	while (!feof($fp_s)) {
		$row = fgets($fp_s);
		if (!empty($row)) {
			$rows[] = trim($row);
		}
	}
	$a = time();
	$curl->getContents($rows, "readUrl", $curl_type);
	$b = time();
	echo "写入download_url耗时：" . ($b - $a) . 's' . "\n";
	fclose($fp_s);
	fclose($fp_d_s);
	fclose($fp_d_e);
	fclose($fp_unmatch);
} else {
	/**
	 * 从获取列表页的URL
	 */
	$start = $start_index ? $start_index : 1;
	$end = $end_index ? $end_index : 100;
	$urls = array();
	for ($i = $start; $i <= $end; $i++) {
		$urls[] = $source_url_format . $i;
	}
	$fp_s = fopen($file_s, 'w+'); //建立下载源文件（成功）
	$fp_e = fopen($file_e, 'w+'); //建立下载源文件（失败）
	$a = time();
	if ($curl->getContents($urls, "writeUrl", $curl_type)) {
		$b = time();
		echo "写入source_url耗时：" . ($b - $a) . 's' . "\n";
	} else {
		echo "写入source_url失败！\n";
	}
	fclose($fp_s);
	fclose($fp_e);
}

//获得sourceURL的回调函数
function writeUrl($data) {
	global $preg_source, $fp_s, $fp_e, $prefix_source;
	preg_match_all($preg_source, $data['result'], $matches);
	if ($matches) {
		//拼接成可访问url
		$arr = array();
		$res = array_unique($matches[0]);
		foreach ($res as $v) {
			$n = $prefix_source . $v;
			$arr[] = $n;
			if (fwrite($fp_s, $n . "\n")) {
				echo date('Y-m-d H:i:s', time()) . ':文件写入源url：' . $n . "(ok)\n";
			} else {
				fwrite($fp_e, $n . "\n");
			}
		}
	} else {
		echo '未找到匹配源url' . "\n";
	}
}

//读取sourceURL并download Files的回调函数
function readUrl($data) {
	global $preg_download, $fp_d_s, $fp_d_e, $fp_unmatch, $prefix_downlaod, $curl, $is_in_time, $curl_type;
	preg_match_all($preg_download, $data['result'], $matches);
	if (!empty($matches[0])) {
		//拼接成可访问url
		$arr = array();
		$res = array_unique($matches[0]);
		if ($is_in_time) {
			foreach ($res as $v) {
				$n = $prefix_downlaod . $v;
				$arr[] = $n;
				if (fwrite($fp_d_s, $n . "\n")) {
					echo date('Y-m-d H:i:s', time()) . ':文件写入down_url：' . $n . "(ok)\n";
					$re = array(trim($n));
					if ($curl->getContents($re, "downloadFile", $curl_type)) {
						return true;
					} else {
						return false;
					}
				} else {
					fwrite($fp_d_e, $n . "\n");
					return false;
				}
			}
		} else {
			if (fwrite($fp_d_s, $res[0] . "\n")) {
				echo date('Y-m-d H:i:s', time()) . ':文件写入down_url：' . $res[0] . "(ok)\n";
			} else {
				fwrite($fp_d_e, $res[0] . "\n");
				return false;
			}

		}
	} else {
		echo '未找到匹配源url' . "\n";
		fwrite($fp_unmatch, $data['url'] . "\n");
		return false;
	}
}

//download Files的回调函数
function downloadFile($data) {
	global $download_path, $fp_d_e;
	if ($data['result']) {
		$file = basename($data['url']);
		if (file_put_contents($download_path . $file, $data['result'])) {
			if (!empty($postfix)) {
				rename($download_path . $file, $download_path . $file . $postfix);
			}
			echo date('Y-m-d H:i:s', time()) . "下载ok\n";
			return false;
		} else {
			echo "download faile\n";
			fwrite($fp_d_e, $data['url'] . "\n");
			return false;
		}
	} else {
		echo "no result to download \n";
		fwrite($fp_d_e, $data['url'] . "\n");
		return false;
	}
}

//测试方法
function deal($data, $fp_s, $fp_e) {
	if ($data["error"] == '') {
		echo $data["url"] . " -- " . $data["info"]["http_code"] . "\n";
		fwrite($fp_s, $data['url'] . "\n");
	} else {
		echo $data["url"] . " -- " . $data["error"] . "\n";
		fwrite($fp_e, $data["url"] . "\r\n");
	}
}