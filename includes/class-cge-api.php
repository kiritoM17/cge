<?php 
$full_path = dirname(__FILE__);
$path = explode("wp-", $full_path);

require $path[0] . 'wp-config.php';

@ini_set('display_errors', 1);
if (!class_exists('API_CGE')) {
    class API_CGE
    {
        protected $url = '';
        protected $api = '';
        /**
         * Static Singleton Holder
         * @var self
         */
        protected static $instance;

        /**
         * Get (and instantiate, if necessary) the instance of the class
         *
         * @return self
         */
        public static function instance()
        {
            if (!self::$instance) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function __construct()
        {
            $this->url = 'https://api.cge.asso.fr';
        }

        public function getAccessToken($username, $password)
        {
            @set_time_limit(0);
            if (get_option("_CGE_CLIENT_ACCESS_TOKEN"))
                    update_option("_CGE_CLIENT_ACCESS_TOKEN", '');
            $accessTokent = $this->postApi('/authentication_token', [
                "username" => $username,
                "password" => $password
            ]);

            if (isset($accessTokent->token) && !empty($accessTokent->token)) {
                if (get_option("_CGE_CLIENT_ACCESS_TOKEN"))
                    update_option("_CGE_CLIENT_ACCESS_TOKEN", $accessTokent->token);
                else
                    add_option("_CGE_CLIENT_ACCESS_TOKEN", $accessTokent->token);
                return get_option("_CGE_CLIENT_ACCESS_TOKEN");
            }
            return null;
        }

        public function getApi($slug, $body = [])
        {
            @set_time_limit(0);
            $accessTokent = get_option("_CGE_CLIENT_ACCESS_TOKEN");
            $query = '';
            if($body)
                $query = http_build_query($body, '', '&amp;');
            try {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $this->url . $slug .'?'.$query,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => [
                        (isset($accessTokent) && !empty($accessTokent)) ? 'Authorization: Bearer ' . $accessTokent  : ''
                    ],
                ));
                $response = curl_exec($curl);
                die(var_dump($response));
                // Check the return value of curl_exec(), too
                if ($response === false) {
                    throw new Exception(curl_error($curl), curl_errno($curl));
                }
                return json_decode($response);
            } catch (Exception $e) {

                trigger_error(
                    sprintf(
                        'Curl failed with error #%d: %s',
                        $e->getCode(),
                        $e->getMessage()
                    ),
                    E_USER_ERROR
                );
            } finally {
                // Close curl handle unless it failed to initialize
                if (is_resource($curl)) {
                    curl_close($curl);
                }
            }
        }

        public function postApi($slug, $body = [])
        {
            @set_time_limit(0);
            $accessTokent = get_option("_CGE_CLIENT_ACCESS_TOKEN");
            try {
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $this->url . $slug,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($body),
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json',
                        'Accept: */*',
                        (isset($accessTokent) && !empty($accessTokent)) ? 'Authorization: Bearer ' . $accessTokent  : ''
                    ],
                ]);
                $response = curl_exec($curl);
                // Check the return value of curl_exec(), too
                if ($response === false) {
                    throw new Exception(curl_error($curl), curl_errno($curl));
                }

                return json_decode($response);
            } catch (Exception $e) {
                trigger_error(
                    sprintf(
                        'Curl failed with error #%d: %s',
                        $e->getCode(),
                        $e->getMessage()
                    ),
                    E_USER_ERROR
                );
            } finally {
                // Close curl handle unless it failed to initialize
                if (is_resource($curl)) {
                    curl_close($curl);
                }
            }
        }

        public function putApi($slug, $body = [])
        {
            $accessTokent = get_option("_CGE_CLIENT_ACCESS_TOKEN");
            try {
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $this->url . $slug,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'PUT',
                    CURLOPT_POSTFIELDS => json_encode($body),
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        (isset($accessTokent) && !empty($accessTokent)) ? 'Authorization: Bearer ' . $accessTokent  : ''
                    ],
                ]);
                $response = curl_exec($curl);
                // Check the return value of curl_exec(), too
                if ($response === false) {
                    throw new Exception(curl_error($curl), curl_errno($curl));
                }

                return json_decode($response);
            } catch (Exception $e) {

                trigger_error(
                    sprintf(
                        'Curl failed with error #%d: %s',
                        $e->getCode(),
                        $e->getMessage()
                    ),
                    E_USER_ERROR
                );
            } finally {
                // Close curl handle unless it failed to initialize
                if (is_resource($curl)) {
                    curl_close($curl);
                }
            }
        }

        public function deleteApi($slug, $body = [])
        {
            @set_time_limit(0);
            $accessTokent = get_option("_CGE_CLIENT_ACCESS_TOKEN");
            try {
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $this->url . $slug,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'DELETE',
                    CURLOPT_POSTFIELDS => json_encode($body),
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        (isset($accessTokent) && !empty($accessTokent)) ? 'Authorization: Bearer ' . $accessTokent  : ''
                    ],
                ]);
                $response = curl_exec($curl);
                // Check the return value of curl_exec(), too
                if ($response === false) {
                    throw new Exception(curl_error($curl), curl_errno($curl));
                }

                return json_decode($response);
            } catch (Exception $e) {

                trigger_error(
                    sprintf(
                        'Curl failed with error #%d: %s',
                        $e->getCode(),
                        $e->getMessage()
                    ),
                    E_USER_ERROR
                );
            } finally {
                // Close curl handle unless it failed to initialize
                if (is_resource($curl)) {
                    curl_close($curl);
                }
            }
        }
    }
}