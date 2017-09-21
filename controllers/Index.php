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
//        if (!Session::get('_token')) {
//            $xml = $this->getToken();
//        }
        $this->view->render('index/index');
    }
    /**
     * get auth token
     * @return integer
     */
    public function getToken()
    {
        $credentials = $this->cmodel->getById(1);

        $xml =  '<?xml version="1.0" encoding="UTF-8" ?>' .
            '<AUTH><USR>' . $credentials['email'] .'</USR>' .
            '<PASSWD>' . $credentials['password'] . '</PASSWD>' .
            '<DEVICEID>e138231a68ad82f054e3d756c6634ba1</DEVICEID>' .
            '<PCATEGORY>RocketRoute</PCATEGORY>' .
            '<APPMD5>' . $credentials['app_key'] . '</APPMD5></AUTH>';

        // send credentials to api by curl to get token
        $url = $credentials['url'];
        $fields_string = '';

        $fields = array(
            'req' => urlencode($xml),
        );

        //url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_POST, 1);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        return $result;
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

        // check for errors
        if ($errors['count'] === 0) {
            $this->cmodel->getInfo($post['code']);
        } else {
            echo json_encode(array('errors'=>$errors));
        }
    }
}
?>