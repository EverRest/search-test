<?php
class Bootstrap {
    /**
     * Bootstrap constructor.
     * parse url and run controllers
     * @return mixed
     */
    public function __construct() {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        $book_path = 'controllers/Index.php';

        if(file_exists($book_path)) {
            include $book_path;
            $controller = new Index();
        } else {
            include 'controllers/Error.php';
            $controller = new Error();
            return false;
        }

        if(isset($url[1]) && isset($url[0])) {
            if(method_exists($controller, $url[0])) {
                $controller->{$url[0]}($url[1]);
            } else {
                echo 'Error: NO ROUTE!';
            }
        } else {
            if(isset($url[0]) && method_exists($controller, $url[0])) {
                $controller->{$url[0]}($url[1]);
            } else {
                $controller->index();
            }
        }
    }
}
?>