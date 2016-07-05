<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/8 0008
 * Time: 下午 14:30
 */
include "config.php" ;

class Action{

    const AJAX_SUCC = 200 ;
    const AJAX_NOT_FOUND = 404 ;
    const AJAX_SYS_ERR = 500 ;
    const AJAX_USER_ERR = 403 ;


    public function __construct()
    {


    }

    public function logout()
    {
        session_start() ;

        $_SESSION['islogin'] = 0 ;
        $_SESSION['nickname'] = '' ;
        $_SESSION['id'] = '';

        session_destroy();

        header("Location: ./login.php");
    }

    public function doLogin()
    {

        session_start() ;

        if (isset($_POST['nickname'])){
            $nickname = trim($_POST['nickname']) ;
            $nickname = htmlspecialchars($nickname);

        }else{
            $nickname = uniqid();
        }

        $nickname = mb_substr($nickname, 0, 10, CHARSET) ;

        $_SESSION['islogin'] = 1 ;
        $_SESSION['nickname'] = $nickname ;
        $_SESSION['id'] = uniqid();


        header("Location: ./index.php");

    }

    /**
     * 输出标准json格式
     * @param $code  状态码
     * @param $data  数据
     * @param bool $isexit   是否立刻结束php程序
     */
    private function ajax_echo($code, $data, $isexit=true){

        $ret['code'] = $code ;
        $ret['data'] = $data ;

        echo json_encode($ret) ;

        if ($isexit) {
            exit();
        }

    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        echo 'hello world' ;
    }

}

$act = trim($_GET['act']) ;

$app = new Action();
$app->$act();