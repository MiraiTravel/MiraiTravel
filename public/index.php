<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Workerman\Worker;
use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;

// 创建一个Worker监听2345端口，使用http协议通讯
$http_worker = new Worker("http://0.0.0.0:2345");

// 启动4个进程对外提供服务
$http_worker->count = 4;
$http_worker->onWorkerStart = function ($worker) {
    // 将db实例存储在全局变量中(也可以存储在某类的静态成员中)
    global $db;
    $db = new \Workerman\MySQL\Connection('sh-cynosdbmysql-grp-h3x0qxg8.sql.tencentcdb.com', '20291', 'MiraiTravel', 'MiraiTravel2023', 'miraitravel_botqq');
};

$http_worker->onMessage = function (TcpConnection $connection, Request $data) {
    global $db;
    // 类型分流
    if ($data->path() == '/') {
        if ($data->get('qq') !== null && $data->header('x-real-ip') !== null) {
            $insert_id = $db->insert('qq')->cols(array(
                'qq' => $data->get('qq'),
                'ipv4' => $data->header('x-real-ip')
            ))->query();
            $connection->send(json_encode(array(
                "code" => "200",
                "data" => array(
                    "qq" => $data->get('qq'),
                    'ipv4' => $data->header('x-real-ip')
                ),
                "message" => "上报成功,感谢你~",
            )));
        } else {
            $connection->send('What are you doing??');
        }
    } else {
        $connection->send('What are you doing?');
    }
};

Worker::runAll();
