<?php

/**
 * curl获取文件类
 */
class CurlGetContents {

	/**
	 * 随机IP
	 * @return [type] [description]
	 */
	public static function getRandIP() {
		//随机国内ip
		$ip_long = array(
			array('607649792', '608174079'), //36.56.0.0-36.63.255.255
			array('975044608', '977272831'), //58.30.0.0-58.63.255.255
			array('999751680', '999784447'), //59.151.0.0-59.151.127.255
			array('1019346944', '1019478015'), //60.194.0.0-60.195.255.255
			array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
			array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
			array('1947009024', '1947074559'), //116.13.0.0-116.13.255.255
			array('1987051520', '1988034559'), //118.112.0.0-118.126.255.255
			array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
			array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
			array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
			array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
			array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
			array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
			array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
		);
		$rand_key = mt_rand(0, 14);
		$ip = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
		return $ip;
	}

	/**
	 * 随机浏览器代理
	 * @return [type] [description]
	 */
	public static function getRandAgent() {
		$agentarry = [
			"safari 5.1 – MAC" => "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11",
			"safari 5.1 – Windows" => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50",
			"Firefox 38esr" => "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0",
			"IE 11" => "Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729; InfoPath.3; rv:11.0) like Gecko",
			"IE 9.0" => "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0",
			"IE 8.0" => "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
			"IE 7.0" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)",
			"IE 6.0" => "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)",
			"Firefox 4.0.1 – MAC" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
			"Firefox 4.0.1 – Windows" => "Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
			"Opera 11.11 – MAC" => "Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.8.131 Version/11.11",
			"Opera 11.11 – Windows" => "Opera/9.80 (Windows NT 6.1; U; en) Presto/2.8.131 Version/11.11",
			"Chrome 17.0 – MAC" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
			"傲游（Maxthon）" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Maxthon 2.0)",
			"腾讯TT" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; TencentTraveler 4.0)",
			"世界之窗（The World） 2.x" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
			"世界之窗（The World） 3.x" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; The World)",
			"360浏览器" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; 360SE)",
			"搜狗浏览器 1.x" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SE 2.X MetaSr 1.0; SE 2.X MetaSr 1.0; .NET CLR 2.0.50727; SE 2.X MetaSr 1.0)",
			"Avant" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Avant Browser)",
			"Green Browser" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
			//移动端口
			"safari iOS 4.33 – iPhone" => "Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
			"safari iOS 4.33 – iPod Touch" => "Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
			"safari iOS 4.33 – iPad" => "Mozilla/5.0 (iPad; U; CPU OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
			"Android N1" => "Mozilla/5.0 (Linux; U; Android 2.3.7; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
			"Android QQ浏览器 For android" => "MQQBrowser/26 Mozilla/5.0 (Linux; U; Android 2.3.7; zh-cn; MB200 Build/GRJ22; CyanogenMod-7) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
			"Android Opera Mobile" => "Opera/9.80 (Android 2.3.4; Linux; Opera Mobi/build-1107180945; U; en-GB) Presto/2.8.149 Version/11.10",
			"Android Pad Moto Xoom" => "Mozilla/5.0 (Linux; U; Android 3.0; en-us; Xoom Build/HRI39) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13",
			"BlackBerry" => "Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.337 Mobile Safari/534.1+",
			"WebOS HP Touchpad" => "Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.0; U; en-US) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/233.70 Safari/534.6 TouchPad/1.0",
			"UC标准" => "NOKIA5700/ UCWEB7.0.2.37/28/999",
			"UCOpenwave" => "Openwave/ UCWEB7.0.2.37/28/999",
			"UC Opera" => "Mozilla/4.0 (compatible; MSIE 6.0; ) Opera/UCWEB7.0.2.37/28/999",
			"微信内置浏览器" => "Mozilla/5.0 (Linux; Android 6.0; 1503-M02 Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/37.0.0.0 Mobile MQQBrowser/6.2 TBS/036558 Safari/537.36 MicroMessenger/6.3.25.861 NetType/WIFI Language/zh_CN",
			// ""=>"",
		]; //PC端的UserAgent
		return $agentarry[array_rand($agentarry, 1)];
	}

	/**
	 * 随机来源网站
	 * @return [type] [description]
	 */
	public static function getRandReferUrl() {
		$referurls = [
			// "local" => "http://www.zimuku.net",
			"baidu" => "http://www.baidu.com/",
			"sina" => "http://www.sina.com.cn/",
			"qq" => "http://www.qq.com/",
			"sohu" => "http://www.sohu.com/",
			"wangyi" => "http://www.163.com/",
			"sogou" => "https://www.sogou.com/",
		];
		return $referurls[array_rand($referurls, 1)];
	}

	/**
	 * curl部分设置
	 */
	public static function setOpt($ch, $url) {
		$header = array(
			'CLIENT-IP:' . self::getRandIP(),
			'X-FORWARDED-FOR:' . self::getRandIP(),
		); //构造ip
		$referurl = self::getRandReferUrl(); //模拟来源网址
		$useragent = self::getRandAgent(); //模拟&随机浏览器useragent
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); //发起连接前等待的时间，设置0，则无限等待
		// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 0); //尝试连接等待的时间，单位毫秒。设置0，则无限等待
		curl_setopt($ch, CURLOPT_TIMEOUT, 60); // 设置cURL允许执行的最长秒数，如大文件下载
		// curl_setopt($ch, CURLOPT_TIMEOUT_MS, 0); //设置cURL允许执行的最长毫秒数
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_REFERER, $referurl);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //跟踪重定向
		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
	}

	/**
	 * curl获取数据
	 * @param  array  $urls     [抓取的urls]
	 * @param  string $callback [回调函数，下载数据]
	 * @param  string $type     [是否为并发模式]
	 * @return [type]           [抓取的数据：array(返回的信息数组;错误信息;抓取的内容;抓取的真实url)]
	 */
	public function getContents($urls = array(), $callback = '', $type = 0) {
		$urls = array_filter($urls);
		switch ($type) {
		case 0:
			$response = array();
			if (empty($urls)) {
				return $response;
			}
			$map = array();
			$ch = curl_init();
			foreach ($urls as $url) {
				self::setOpt($ch, $url);
				$response = curl_exec($ch);
				$info = curl_getinfo($ch);
				$error = curl_error($ch);
				$result = curl_multi_getcontent($ch);
				$rtn = compact('info', 'error', 'result', 'url');
				if (trim($callback)) {
					call_user_func_array($callback, array($rtn));
				}
				$response = $rtn;
			}
			curl_close($ch);
			return $response;
		case 1:
			$response = array();
			if (empty($urls)) {
				return $response;
			}
			$chs = curl_multi_init();
			$map = array();
			foreach ($urls as $url) {
				$ch = curl_init();
				self::setOpt($ch, $url);
				curl_multi_add_handle($chs, $ch);
				$map[strval($ch)] = $url;
			}
			do {
				if (($status = curl_multi_exec($chs, $active)) != CURLM_CALL_MULTI_PERFORM) {
					if ($status != CURLM_OK) {
						break;
					} //如果没有准备就绪，就再次调用curl_multi_exec
					while ($done = curl_multi_info_read($chs)) {
						$info = curl_getinfo($done["handle"]);
						$error = curl_error($done["handle"]);
						$result = curl_multi_getcontent($done["handle"]);
						$url = $map[strval($done["handle"])];
						$rtn = compact('info', 'error', 'result', 'url');
						if (trim($callback)) {
							call_user_func_array($callback, array($rtn));
						}
						$response[$url] = $rtn;
						curl_multi_remove_handle($chs, $done['handle']);
						curl_close($done['handle']);
						//如果仍然有未处理完毕的句柄，那么就select
						if ($active > 0) {
							curl_multi_select($chs, 1); //此处会导致阻塞大概1秒。
						}
					}
				}
			} while ($active > 0); //还有句柄处理还在进行中
			curl_multi_close($chs);
			return $response;
		default:
			echo '未指定抓取的方式!';
			break;
		}
	}

}
