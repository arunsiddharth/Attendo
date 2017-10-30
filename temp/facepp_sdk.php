<?PHP
/**
 * Class Facepp - Face++ PHP SDK
 *
 * @author Tianye
 * @author Rick de Graaff <rick@lemon-internet.nl>
 * @since  2013-12-11
 * @version  1.1
 * @modified 16-01-2014
 * @copyright 2013 - 2015 Tianye
 **/
class Facepp
{
    ######################################################
    ### If you choose Amazon(US) server,please use the ###
    ### http://apius.faceplusplus.com/v2               ###
    ### or                                             ###
    ### https://apius.faceplusplus.com/v2              ###
    ######################################################
    /*
    curl -X POST "https://api-us.faceplusplus.com/facepp/v3/search" \
-F "api_key=<api_key>" \
-F "api_secret=<api_secret>" \
-F "face_token=c2fc0ad7c8da3af5a34b9c70ff764da0" \
-F "outer_id=facesetid"
    
    
    
    */
    public $server          = 'https://api-us.faceplusplus.com/facepp/v3';
    #public $server          = 'http://apicn.faceplusplus.com/v3';
    #public $server         = 'https://apicn.faceplusplus.com/v2';
    #public $server         = 'http://api-us.faceplusplus.com/v2';
    #public $server         = 'https://apius.faceplusplus.com/v2';
    public $api_key         = '';        // set your API KEY or set the key static in the property
    public $api_secret      = '';        // set your API SECRET or set the secret static in the property
    private $useragent      = 'Faceplusplus PHP SDK/1.1';
    /**
     * @param $method - The Face++ API
     * @param array $params - Request Parameters
     * @return array - {'http_code':'Http Status Code', 'request_url':'Http Request URL','body':' JSON Response'}
     * @throws Exception
     */
    public function execute($method, array $params)
    {
        if( ! $this->apiPropertiesAreSet()) {
            throw new Exception('API properties are not set');
        }
        $params['api_key']      = $this->api_key;
        $params['api_secret']   = $this->api_secret;
        return $this->request("{$this->server}{$method}", $params);
    }
    private function request($request_url, $request_body)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $request_url);//URL to fetch
        curl_setopt($curl_handle, CURLOPT_FILETIME, true);// time of modification of file to be fetched
        curl_setopt($curl_handle, CURLOPT_FRESH_CONNECT, false);//true for new conn instead of cached 
        if(version_compare(phpversion(),"5.5","<=")){
            curl_setopt($curl_handle, CURLOPT_CLOSEPOLICY,CURLCLOSEPOLICY_LEAST_RECENTLY_USED);
        }else{
            curl_setopt($curl_handle, CURLOPT_SAFE_UPLOAD, false);
        }
        curl_setopt($curl_handle, CURLOPT_MAXREDIRS, 5);//maximum http redirection allowed
        curl_setopt($curl_handle, CURLOPT_HEADER, false);//true to include header in o/p
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);//true for string value of curl_exec()
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 5184000);//maximum secs curl can execute
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 120);//no. of seconds to wait while trying to connect
        curl_setopt($curl_handle, CURLOPT_NOSIGNAL, true);//true to ignore func. sending signal to php process
        curl_setopt($curl_handle, CURLOPT_REFERER, $request_url);//referer header in HTTP
        curl_setopt($curl_handle, CURLOPT_USERAGENT, $this->useragent);//useragent in HTTP
        
        if (extension_loaded('zlib')) {
            curl_setopt($curl_handle, CURLOPT_ENCODING, '');
        }
        curl_setopt($curl_handle, CURLOPT_POST, true);//HTTP POST REQUEST
        if (array_key_exists('image_file', $request_body)) {
            $request_body['image_file'] = '@' . $request_body['image_file'];//append @ before img
        } else {
            $request_body = http_build_query($request_body); // genrate url_encoded
        }
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $request_body);//Set postfields
        echo print_r($request_body);
        
        $response_text      = curl_exec($curl_handle);
        $response_header    = curl_getinfo($curl_handle);
        curl_close($curl_handle);
        return array (
            'http_code'     => $response_header['http_code'],
            'request_url'   => $request_url,
            'body'          => $response_text
        );
    }
    private function apiPropertiesAreSet()
    {
        if( ! $this->api_key) {
            return false;
        }
        if( ! $this->api_secret) {
            return false;
        }
        
        return true;
    }
}