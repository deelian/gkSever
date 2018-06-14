<?php
namespace Home\Controller;

use Think\Controller;
use Predis\Autoloader;
use Predis\Client;

class XkController extends Controller {

    //Obj_Redis
    public $RED;

    public function __construct(){
        parent::__construct();
        Autoloader::register();
        $host = [
            'scheme'                => 'tcp',
            'host'                  => C('REDIS_HOST'),
            'port'                  => C('REDIS_PORT'),
            'read_write_timeout'    => 0
        ];
        $this->RED = new Client($host);
    }
}