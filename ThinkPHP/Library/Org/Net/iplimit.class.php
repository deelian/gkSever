<?php

namespace Org\Net;

class iplimit
{

    private $path;
    private $iptable;

	function __construct() {
		header('content-type:text/html;charset=utf-8;');
		$this->path = dirname(__FILE__).'/'."ipdata.db";
	}

	function setup($ip = '') {
		$content = file_get_contents($this->path);
		if(empty($content)) {
			$this->show('1');
			exit('IP数据库破损');
		}
		$this->iptable = $content;
		return $this->CheckIp($ip);
	}

	function GetIP() {
		if ($ip = getenv('HTTP_CLIENT_IP'));
		elseif ($ip = getenv('HTTP_X_FORWARDED_FOR'));
		elseif ($ip = getenv('HTTP_X_FORWARDED'));
		elseif ($ip = getenv('HTTP_FORWARDED_FOR'));
		elseif ($ip = getenv('HTTP_FORWARDED'));
		else    $ip = $_SERVER['REMOTE_ADDR'];
		return  $ip;
	}

	function CheckIp($ip = '') {
		!$ip && $ip = $this->GetIp();
		$ip2 = sprintf('%u',ip2long($ip));
		$tag = reset(explode('.',$ip));
		if(!$ip) {
			return $this->show(2);
		}
		if('192'== $tag || '127'== $tag) {
			return $this->show(4);
		}
		if(!isset($this->iptable[$tag])) {
			return $this->show(3);
		}
		foreach($this->iptable[$tag] as $k =>$v) {
			if($v[0] <= $ip2 &&$v[1] >= $ip2) {
				return $this->show('in');
			}
		}
		return $this->show('out');
	}

	function show($code) {
		$msg = array(
            1     => 0, //"IP数据库文件破损",
            2     => 2, //"取不到IP地址 可能使用了代理",
            4     => 4, //"在局域网内",
            'out' => 'out', //"IP地址在国外",
            'in'  => 'in',  //"IP地址在国内,
		);
		return $msg[$code];
	}

	function __destruct() {
		unset($this->iptable);
	}
}
?>