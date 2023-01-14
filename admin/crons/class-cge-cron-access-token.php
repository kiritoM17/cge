<?php
$full_path = dirname(__FILE__);
$path = explode("wp-", $full_path);

require $path[0] . 'wp-config.php';

@ini_set('display_errors', 1);

require plugin_dir_path(dirname(__FILE__,2)) . 'includes/class-cge-api.php';
class Cron_Access_Token
{
    private $username = "";
    private $password = "";

    public function __construct()
    {
        $this->username = get_option("_CGE_CLIENT_USERNAME");
        $this->password = get_option("_CGE_CLIENT_PWD");
    }

    public function getAccessToken()
    {
        $api = new API_CGE();
        $request_response = $api->getAccessToken($this->username, $this->password);
        
        if($request_response)
            echo __('token updated successfully at ', 'cge') . date('Y-m-d : H:m:s');
        else
            echo __('token have not been update at try if you have correct settings ', 'cge') . date('Y-m-d : H:m:s');
    }

}

$cron_Access_Token = new Cron_Access_Token();
$cron_Access_Token->getAccessToken();