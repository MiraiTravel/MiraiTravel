<?php

require_once "loder.php";

use MiraiTravel\Software\Stay\Connection\TcpConnection;
use MiraiTravel\Software\Stay\Events\EventInterface;
use MiraiTravel\Software\Stay\Events\Select;
use MiraiTravel\Software\Stay\Protocols\Http\Request;

$errno = 0;
$flags =  \STREAM_SERVER_BIND | \STREAM_SERVER_LISTEN;
$errmsg = '';
$context_option = array();
$context_option['socket']['backlog'] = 102400;
$_context = \stream_context_create($context_option);

$socket = \stream_socket_server("tcp://0.0.0.0:3046", $errno, $errmsg, $flags, $_context);

$connections = array();
$globalEvent = new Select();

$globalEvent->add($socket, EventInterface::EV_READ, 'acceptConnection');
$globalEvent->add(STDIN, EventInterface::EV_READ, 'stic');

function acceptConnection($socket)
{
    global $connections;
    global $globalEvent;
    $conn = stream_socket_accept($socket, 0, $remote_address);
    $connection = new TcpConnection($conn, $remote_address, $globalEvent);
    $connections[] = $connection;
    $connection->protocol = 'MiraiTravel\\Software\\Stay\\Protocols\\Http';
    $connection->transport      = 'tcp';
    $connection->onMessage = function (TcpConnection $connection, Request $data) {
        print_r($data->get());
        $connection->send(json_encode(array(
            "code" => "200",
            "data" => array(
                "qq" => "a",
                'ipv4' => "b"
            ),
            "message" => "上报成功,感谢你~",
        )));
        echo "OnMessage!";
    };
    $connection->onClose = function (TcpConnection $connection, Request $data) {
        $connection->send(json_encode(array(
            "code" => "200",
            "data" => array(
                "qq" => "a",
                'ipv4' => "b"
            ),
            "message" => "上报成功,感谢你~",
        )));
        echo "OnMessage!";
    };;
    $connection->onError        = null;
    $connection->onBufferDrain  = null;
    $connection->onBufferFull   = null;

    echo "connect!";
}

function stic($stdin)
{
    $data = stream_get_line($stdin, 1);
    echo $data;
}


if (!$socket) {
    echo "$errmsg ($errno)<br />\n";
} else {
    while (true) {
        $globalEvent->loop();
    }
}
