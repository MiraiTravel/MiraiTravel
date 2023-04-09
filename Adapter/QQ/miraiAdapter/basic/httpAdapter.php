<?php

namespace MiraiTravel\Adapter\QQ\miraiAdapter\basic\HttpAdapter;

use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\LogSystem\LogSystem;

/**
 * http 适配器
 */
function http_adapter($url, $command, $content, $others = array())
{
    $command = func_to_command($command);
    if ($others['apiType'] === 'GET') {
        return json_decode(curl_get($url . $command . "?" . http_build_query($content)), true);
    } else if ($others['apiType'] === 'POSTFILE') {
        return json_decode(curl_post($content, $url . $command), true);
    } else {
        return json_decode(curl_post(json_encode($content), $url . $command), true);
    }
}

/**
 * http
 * 函数名转命令函数
 * @param string $funcName 函数名 
 */
function func_to_command($funcName)
{
    $flag = stripos($funcName, "_");
    while ($flag !== false) {
        $flag2 = $funcName[$flag + 1];
        if ($flag2 <= 'z' && $flag2 >= 'a') {
            $funcName = str_replace("_" . $flag2, strtoupper($flag2), $funcName);
        } elseif ($flag2 === "_") {
            $funcName = str_replace("__", "/", $funcName);
        }
        $flag = stripos($funcName, "_");
    }
    return "/" . $funcName;
}

function curl_get($url, $cookie = '', $referer = '', $header = '', $setopt = array(), $UserAgent = 'MiraiTravel')
{
    $logSystem = new LogSystem("MiraiTravel", "System");
    $logSystem->write_log("httpAdapter", "curl_get", "A CGET URL=[$url] ");
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    if ($UserAgent != "")
        curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
    if ($header != '')
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    if ($referer != '')
        curl_setopt($curl, CURLOPT_REFERER, $referer);
    if ($cookie != '')
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    #关闭SSL
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    if (!empty($setopt) && is_array($setopt)) {
        foreach ($setopt as $value) {
            curl_setopt($curl, $value[0], $value[1]);
        }
    }
    #返回数据不直接显示
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);

    //适配 gzip 压缩
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip, deflate');

    $response = curl_exec($curl);
    curl_close($curl);
    $logSystem->write_log("httpAdapter", "curl_get", "A CGET URL=[$url] , RETURN=[$response] ");
    return $response;
}

function curl_post($payload, $url, $cookie = '', $referer = '', $header = array(), $setopt = array(), $UserAgent = 'MiraiTravel')
{
    $logSystem = new LogSystem("MiraiTravel", "System");
    $logSystem->write_log("httpAdapter", "curl_post", "A CPOST URL=[$url] , BODY=[$payload]");

    $header = is_array($header) ? $header : array();
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
    if (count($header) > 0)
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    if ($referer != '')
        curl_setopt($curl, CURLOPT_REFERER, $referer);
    if ($cookie != '')
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    if (!empty($setopt) && is_array($setopt)) {
        foreach ($setopt as $value) {
            curl_setopt($curl, $value[0], $value[1]);
        }
    }
    #关闭SSL
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    #返回数据不直接显示
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);

    //适配 gzip 压缩
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip, deflate');

    $response = curl_exec($curl);
    curl_close($curl);
    $logSystem->write_log("httpAdapter", "curl_post", "A CPOSTOK URL=[$url] , BODY=[$payload] , RETURN=[$response]");
    return $response;
}
