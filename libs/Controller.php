<?php
class Controller
{
    public function __construct() {
        $this->view = new View();
    }

    public function loadModel($name)
    {
        $path = 'models/' . $name . '_Model.php';
        $modelName = $name . '_Model';

        if (file_exists($path)) {
            include $path;
            $this->model = new $modelName();
        } else {
            include 'models/Book_Model.php';
        }
    }
}
?>