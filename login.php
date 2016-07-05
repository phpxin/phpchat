<?php
session_start();
include_once('./config.php') ;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include_once('./header.php') ;
    ?>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">登录</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="./act.php?act=doLogin" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="输入姓名，只为标记用户" name="nickname" type="text" autofocus>
                                </div>
                                <!--<div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>-->
                                <!-- Change this to a button or input when using this as a form-->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

    include "./footer.php";

    ?>

</body>

</html>
