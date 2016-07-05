<?php
session_start();
include_once('./config.php') ;

if (!isset($_SESSION['islogin'])){
    header('Location: ./login.php');
    exit();
}

$nickname = $_SESSION['nickname'] ;
$id = $_SESSION['id'] ;

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include_once('./header.php') ;
    ?>

    <style type="text/css">

        .mt-top{
            margin-top: 10px;
        }

        .img-avatar{
            width: 50px;
            height: 50px;
        }


        #alert-box{
            display: none;
        }
    </style>
</head>

<body>
    <div class="mt-top">  </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="chat-panel panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-comments fa-fw"></i>
                        Chat
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu slidedown">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-refresh fa-fw"></i> Refresh
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-check-circle fa-fw"></i> Available
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-times fa-fw"></i> Busy
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-clock-o fa-fw"></i> Away
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="./act.php?act=logout">
                                        <i class="fa fa-sign-out fa-fw"></i> Sign Out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" id="chat-body">
                        <ul class="chat" id="chat">

                        </ul>
                    </div>
                    <!-- /.panel-body -->
                    <div class="panel-footer">
                        <div class="input-group">
                            <input id="btn-input" type="text" class="form-control input-sm" placeholder="输入消息...">
                                <span class="input-group-btn">
                                    <button class="btn btn-warning btn-sm" id="btn-chat">
                                        Send
                                    </button>
                                </span>
                        </div>
                    </div>
                    <!-- /.panel-footer -->
                </div>


                <div class="alert alert-warning alert-dismissible" role="alert" id="alert-box">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Warning!</strong> <span id="alert-box-msg">Better check yourself, you're not looking too good.</span>
                </div>
            </div>
        </div>
    </div>

    <?php

    include "./footer.php";

    ?>

<script type="text/javascript">


    var ws = new WebSocket("ws://<?=$envs['ip']?>:<?=$envs['port']?>");

    ws.onopen = function(){
        console.log("握手成功");
    };

    ws.onclose = function () {
        console.log("closed") ;
    };

    ws.onmessage = function(e){
        console.log("message:" + e.data);
        recvMessage(e.data) ;
    };

    ws.onerror = function(){
        showErrMsg("服务器已关闭");
        console.log("error");
    };

    function recvMessage(data){
        data = $.parseJSON(data) ;
        var uid = '<?=$id?>' ;

        var _c = 'left' ;

        if (data.id == uid){
            _c = 'right' ;
        }

        var html = '\
            <li class="'+_c+' clearfix">\
            <span class="chat-img pull-right">\
            <img src="./imgs/1.jpg" alt="User Avatar" class="img-circle img-avatar">\
            </span>\
            <div class="chat-body clearfix">\
            <div class="header">\
            <small class=" text-muted">\
            <i class="fa fa-clock-o fa-fw"></i> '+data.date+'</small>\
            <strong class="pull-right primary-font">'+data.nickname+'</strong>\
            </div>\
            <p>\
            '+data.content+'\
            </p>\
            </div>\
            </li>\
        ' ;

        $('#chat').append(html) ;
        $('#chat-body').scrollTop(parseInt($('#chat').height()));

    }

    function showErrMsg(msg){

        $('#alert-box-msg').html(msg);
        $('#alert-box').show();

    }

    $('#btn-chat').click(function () {
        if(ws.readyState == WebSocket.OPEN){
            console.log("ok send ...") ;
            try{
                var content = $('#btn-input').val();


                if (content == ''){
                    showErrMsg('消息不能为空');
                    return ;
                }

                var msg_json = {} ;
                msg_json.nickname = '<?=$nickname?>' ;
                msg_json.id = '<?=$id?>' ;
                msg_json.content = content ;
                var msg = JSON.stringify(msg_json);
                //console.log(msg);
                ws.send(msg);
            }catch(ex){
                console.log(ex.toString()) ;
            }

        }
    });


</script>

</body>

</html>
