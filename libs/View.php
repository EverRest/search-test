<?php
class View {

    public static $data = false;

    /**
     * View constructor.
     */
    public function __construct()
    {
    }

    /**
     * assign variable data to view
     * @param bool $data
     */
    public function assign($data = false) {

        self::$data = $data;
    }
    public function render($name, $noInclude = false) {

        if($noInclude == true) {
            require 'views/'.$name.'.php';
        } else {
            require 'views/layouts/header.php';
            require 'views/'.$name.'.php';
            require 'views/layouts/footer.php';
        }
    }
}
?>