<?php

/**
 * MiraiTravel 核心软件 
 * 赋予 MiraiTravel 高并发能力
 * 赋予 MiraiTravel 主动能力
 * 
 */

namespace MiraiTravel\Software\Stay;

// 载入依赖文件
require_once "Stay/loder.php";

use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MiraiTravel;
use MiraiTravel\MiraiTravelSoftware;
use MiraiTravel\Software\Stay\Connection\TcpConnection;
use MiraiTravel\Software\Stay\Events\EventInterface;
use MiraiTravel\Software\Stay\Events\Select;
use MiraiTravel\Software\Stay\Protocols\Http\Request;

class Stay extends MiraiTravelSoftware
{

    const information = "实现MiraiTravel的常驻功能,会监听缓存区的消息列表并处理消息。";
    const commandsInformation = array(
        "help" => "帮助。"
    );

    static $fd; // 保存文件句柄
    static $logSystem = null; // 保存日志系统句柄

    static $miraiTravelInter = "";

    public $mainSocket = null;
    public $globalEvent = null;
    public $connections = array();

    /**
     * 构造函数 , 会传入启动参数
     */
    function __construct($argc, $argv)
    {

        // 锁
        if (!$this::lock()) {
            echo "运行失败！";
            return false;
        }

        // 初始化句柄
        self::$logSystem = new LogSystem("Stay", "System");

        $errno = 0;
        $flags =  \STREAM_SERVER_BIND | \STREAM_SERVER_LISTEN;
        $errmsg = '';
        $context_option = array();
        $context_option['socket']['backlog'] = 102400;
        $_context = \stream_context_create($context_option);

        $this->mainSocket = \stream_socket_server("tcp://0.0.0.0:3046", $errno, $errmsg, $flags, $_context);

        $this->globalEvent = new Select();

        $this->globalEvent->add($this->mainSocket, EventInterface::EV_READ, array($this, 'acceptConnection'));
        $this->globalEvent->add(STDIN, EventInterface::EV_READ, array($this, 'stic'));

        if (!$this->mainSocket) {
            echo "$errmsg ($errno)<br />\n";
        } else {
            while (true) {
                $this->globalEvent->loop();
            }
        }

        // 把所有 LogSystem 的对象都使用句柄的对象来实现
        $this->logSystem->println("该功能正在计划开发阶段。", "Red");
    }

    static function lock($flag = \LOCK_EX)
    {
        if (\DIRECTORY_SEPARATOR !== '/') {
            return false;
        }
        $lock_file = MiraiTravel::getInstance()->get_path() . '/core/miraiTravelSoftware/Stay/Stay.lock';
        if (self::$fd) {
            return false;
        } else {
            self::$fd = \fopen($lock_file, 'a+');
        }
        if (self::$fd) {
            if (!flock(self::$fd, $flag)) {
                return false;
            }
            if ($flag === \LOCK_UN) {
                fclose(self::$fd);
                self::$fd = null;
                clearstatcache();
                if (\is_file($lock_file)) {
                    unlink($lock_file);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    // 解锁
    static function unlock()
    {
        return self::lock(\LOCK_UN);
    }

    // 检测是否为当前进程进行的加锁
    static function isLock()
    {
        if (self::$fd) {
            return true;
        } else {
            return false;
        }
    }

    public function acceptConnection($socket)
    {
        $conn = stream_socket_accept($socket, 0, $remote_address);
        $connection = new TcpConnection($conn, $remote_address, $this->globalEvent);
        $this->connections[] = $connection;
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
            echo "OnMessage!";
        };
        $connection->onError        = null;
        $connection->onBufferDrain  = null;
        $connection->onBufferFull   = null;

        echo "connect!";
    }


    public function stic($stdin)
    {
        self::$miraiTravelInter = fgets($stdin);
        $miraiTravelInter = MiraiTravel::getInstance()->commands_split(self::$miraiTravelInter);
        if ($miraiTravelInter[0] === "exit") {
            $this->stop();
            return 0;
        } elseif (MiraiTravel::getInstance()->is_software($miraiTravelInter[0])) {
            $argv = $miraiTravelInter;
            unset($argv[0]);
            $argv = array_values($argv);
            $argc = count($argv);
            $software = "MiraiTravel\Software\\" . $miraiTravelInter[0];
            new $software($argc, $argv);
        } else {
            $this->logSystem->println("您输入的命令有误 请重试 !" . "\r\n", "Red");
        }
    }

    static function stop()
    {
    }

    function help($argc, $argv, $commandList = array())
    {
    }
}
