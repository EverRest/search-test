<?php
    include 'config/paths.php';
    include 'config/db_param.php';

    include 'libs/Bootstrap.php';
    include 'libs/Controller.php';
    include 'libs/Model.php';
    include 'libs/View.php';
    include 'libs/Database.php';
    include 'libs/Helper.php';
    include 'libs/Xss.php';
    include 'libs/Validator.php';
    include 'libs/Session.php';

    Session::init();
    $app = new Bootstrap();
?>