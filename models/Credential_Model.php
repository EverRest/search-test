<?php
class Credential_Model extends Model
{
    private  $id;
    private $email;
    private $password;
    private $app_key;
    private $url;

    /**
     * Credential_Model constructor.
     * return void
     */
    public function __construct()
    {
        parent::__construct();

        $credentials = $this->getById(1);
        $this->id = $credentials['id'];
        $this->email = $credentials['email'];
        $this->password = $credentials['password'];
        $this->app_key = $credentials['app_key'];
        $this->url = $credentials['url'];
    }

    /**
     * get auth token
     * @return integer
     */
    public function getToken()
    {
        $xml =  '<?xml version="1.0" encoding="UTF-8" ?>' .
            '<AUTH><USR>' . $this->email .'</USR>' .
            '<PASSWD>' . $this->password . '</PASSWD>' .
            '<DEVICEID>e138231a68ad82f054e3d756c6634ba1</DEVICEID>' .
            '<PCATEGORY>RocketRoute</PCATEGORY>' .
            '<APPMD5>' . $this->app_key . '</APPMD5></AUTH>';

        // send credentials to api by curl to get token
        $url = $this->url;
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
     * add token
     * @param array $token
     * return void
     */
//    private function update($token = '')
//    {
//        $this->token = $token;
//        try {
//            $sql = "UPDATE credentials SET  token=:token  WHERE id = :credential_id LIMIT 1";
//            $sth = $this->db->prepare($sql);
//            $sth->bindParam(':token', $this->token, PDO::PARAM_STR);
//            $sth->execute();
//        } catch (Exception $e) {
//            echo 'Model error: ',  $e->getMessage(), "\n";
//        }
//
//    }

    /**
     * get credential by id
     * @param integer $id
     * @return mixed credential by id
     */
    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM credentials WHERE id =  :id LIMIT 1";
            $sth = $this->db->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            return $sth->fetch();
        }
        catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * get all credentials
     * @return array credentials
     */
    public function all()
    {
        try {
            $sth = $this->db->prepare('SELECT * FROM credentials ORDER BY id ASC');
            $sth->execute();
            return $sth->fetchAll();
        }
        catch (Exception $e) {
            echo 'Model error: ',  $e->getMessage(), "\n";
        }
    }

    public function getInfo($ciao = '')
    {
        $xml =  '<?xml version="1.0" encoding="UTF-8" ?>' .
            '<REQWX><USR>' . $this->email .'</USR>' .
            '<PASSWD>' . $this->password . '</PASSWD>' .
            '<ICAO>' . $ciao . '</ICAO></REQWX>';

        // get info from api
        $url = 'https://apidev.rocketroute.com/notam/v1/service.wsdl';

        $client = new SoapClient($url);
        echo $client->getNotam($xml);
    }
}
?>
