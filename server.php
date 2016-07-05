<?php
/**
 * Swoole websocket 实现，依赖 PHP Swoole 插件
 *
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/8 0008
 * Time: 下午 14:50
 */
include "./config.php" ;

//创建websocket服务器对象，监听0.0.0.0:9502端口
$ws = new swoole_websocket_server("0.0.0.0", $envs['port']);

//监听WebSocket连接打开事件
$ws->on('open', function ($ws, $request) {

    writeLog('收到连接');
    //$ws->push($request->fd, "hello, welcome\n");
});

//监听WebSocket消息事件
$ws->on('message', function ($ws, $frame) {

    $msg = json_decode($frame->data, true) ;

    writeLog('收到消息 ' . $frame->data) ;

    $msg['content'] = htmlspecialchars($msg['content']) ;
    $msg['date'] = date('H:i:s');
    $msg_json = json_encode($msg);

    global $ws;
    $clist = $ws->connection_list( 0, 64);
    foreach($clist as $fd)
    {
        $ws->push($fd, $msg_json);
    }
});

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();

/**
 * 写日志
 * @param $msg 内容
 */
function writeLog($msg){
    $msg = date('Y-m-d H:i:s') . ' ' . $msg . PHP_EOL ;
    echo $msg ;
}