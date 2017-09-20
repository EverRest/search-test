<?php
include 'models/Credential_Model.php';
class Index extends Controller
{
    private $cmodel;

    /**
     * Index constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->cmodel = new Credential_Model();
    }

    /**
     *  Show book view
     */
    public function index() {
        $this->view->render('index/index');
    }

    /**
     * Ajax auth user
     * return json
     */
    public function auth()
    {
        $this->cmodel->getToken();
    }

    /**
     * Ajax get info by CIAO code
     * return mixed
     */
    public function info()
    {
        $post = XSS::clean($_POST);
        $errors = Validator::searchForm($post);

        if ($errors['count'] === 0) {
            $this->cmodel->getInfo($post['code']);
        } else {
            echo json_encode(array('errors'=>$errors));
        }
    }
}
?>