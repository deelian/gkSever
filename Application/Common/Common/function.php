<?php

function jRet($val, $die = true){
    echo json_encode($val);
    if($die){
        exit();
    }
}

function isMobile() {
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    if (isset($_SERVER['HTTP_VIA'])) {
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

function checkWord($str){
    $rule = "/".implode('|', C('FORBIDDEN_WORDS'))."/i";
    if(preg_match_all($rule, $str, $matches)){
        $res = implode(',',$matches[0]);
        return $res;
    } else {
        return false;
    }
}

function httpsPost($url,$post_data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // post数据
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    // post的变量
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output=json_decode(curl_exec($ch),true);
    curl_close($ch);
    return $output;
}

function httpsGet($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);// https请求不验证证书和hosts
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    $res = json_decode(curl_exec($curl), true);
    curl_close($curl);
    return $res;
}

function httpGet($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $res=json_decode(curl_exec($curl),true);
    curl_close($curl);
    return $res;
}

/**
 * Thinkphp默认分页样式转Bootstrap分页样式
 * @author H.W.H
 * @param string $page_html tp默认输出的分页html代码
 * @return string 新的分页html代码
 */
function bootstrap_page_style($page_html){
    if ($page_html) {
        $page_show = str_replace('<div>','<nav><ul class="pagination">',$page_html);
        $page_show = str_replace('</div>','</ul></nav>',$page_show);

        $page_show = str_replace('<span class="current">','<li class="active"><a>',$page_show);
        $page_show = str_replace('</span>','</a></li>',$page_show);

        $page_show = str_replace(array('<a class="num"','<a class="prev"','<a class="next"','<a class="end"','<a class="first"'),'<li><a',$page_show);
        $page_show = str_replace('</a>','</a></li>',$page_show);
        return $page_show;
    } else {
        return false;
    }
}

/**
 * 调试打印
 * @param  array $arr    待打印数组
 * @param  string $detail 描述字符串
 */
function p($arr=[], $die=0, $detail=''){
    header('Content-type:text/html;charset=utf-8');
    if ($detail) {
        $detail = '【'.$detail.'】';
    }
    $count = count($arr);
    echo "<pre>";
    echo '详细打印'.$detail.$count.'条记录>>开始<br/>';
    if ($arr) {
        print_r($arr);
    } else {
        echo $detail. '<strong style=color:#ff0344>暂无数据！！！</strong>';
    }
    echo "<br/>";
    echo '详细打印'.$detail.'>>结束<br/>';
    echo "<br/><br/>";
    if($die){die();}
}

/**
 * 调试日志输出
 * @param  string $value  日志内容
 * @param  string $name   文件名
 * @param  string $detail 日志描述
 */
function pLog($value, $detail='调试日志', $name='logs.txt')
{
    if (is_array($value)) {
        $value = json_encode($value);
    }
    $file = RUNTIME_PATH.$name;
    if (filesize($file) >= C('LOG_FILE_SIZE')) {
        @unlink($file);
    }
    $value = '【'.date('Y-m-d H:i:s').'】'.$detail.PHP_EOL.$value.PHP_EOL;
    file_put_contents($file, $value.PHP_EOL, FILE_APPEND);
}

/**
 * 加密函数
 *
 * @param $data
 * @return string
 */
function encrypt($data)
{
    $data   =   strval($data);
    $key    =   md5(C('ENCRYPT_CODE'));
    $x      =   0;
    $len    =   strlen($data);
    $l      =   strlen($key);
    $char   =   '';
    $str    =   '';
    for ($i = 0; $i < $len; $i++)
    {
        if ($x == $l)
        {
            $x = 0;
        }
        $char .= $key{$x};
        $x++;
    }
    for ($i = 0; $i < $len; $i++)
    {
        $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
    }
    return base64_encode($str);
}

/**
 * 解密函数
 *
 * @param $data
 * @return string
 */
function decrypt($data)
{
    $key    = md5(C('ENCRYPT_CODE'));
    $x      = 0;
    $data   = base64_decode($data);
    $len    = strlen($data);
    $l      = strlen($key);
    $char   = '';
    $str    = '';
    for ($i = 0; $i < $len; $i++)
    {
        if ($x == $l)
        {
            $x = 0;
        }
        $char .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++)
    {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
        {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }
        else
        {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return $str;
}

/**
 * 解密cookie信息
 * @return string 返回明文内容
 */
function deCookie()
{
    return explode('|', str_replace('=','',base64_decode($_COOKIE['auto'])^md5(C('secret_key'))));
}

/**
 * 检测提交方式
 *
 * @param  int $value 提交值，默认为检测POST，1位检测GET，2位件AJAX提交
 */
function check($value='')
{
    switch ($value) {
        case '1':
            if (!IS_GET) {
                halt('页面不存在！');
            }
            break;
        case '2':
            if (!IS_AJAX) {
                halt('页面不存在！');
            }
            break;
        default:
            if (!IS_POST) {
                halt('页面不存在！');
            }
            break;
    }
}

/**
 * 返回当前请求方式
 * @return string 请求类型
 */
function qMeth()
{
    return $_SERVER['REQUEST_METHOD'];
}

/**
 * 后台防伪码
 * @return string 防伪码
 */
function loginCode()
{
    return str_replace('-', C('LOGINKEY'), date('m-d', time()));
}

/**
 * 返回UTF-8字符编码
 */
function utf8()
{
    return header('Content-type:text/html;charset=utf-8');
}

/**
 * 保存用户登录凭证
 * @param $account
 */
function savePassScrip($account)
{
    $ip=get_client_ip();
    $value = $ip.'|'.$account;
    $value = str_replace('=','',base64_encode($value^md5(C('secret_key'))));
    @setcookie('auto',$value,C('cookie_time'),'/');
}

/**
 * 获取查询ip的归属地
 * @param  string $ip 锁查询的ip
 * @return array     详细ip信息
 */
function getIpLocation($ip='')
{
    //获取IP归属地
    $Ip = new Org\Net\IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
    $area = $Ip->getlocation($ip); // 获取某个IP地址所在的位置
    return $area;
}
?>