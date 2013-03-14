<?php
/**
 * Custom of Controller
 *
 * @author alejandroacevedoosorio
 */
Class Controller extends Kohana_Controller_Template{
    
    /**
     * Define the tempate to load
     * @var String
     */
    public $template            = 'login';
    
    /**
     * Yahoo session object
     * @var Yahoo_Session Object
     */
    protected $yahoo_session    = NULL;
    
    
    public function __construct(\Request $request, \Response $response) {
        parent::__construct($request, $response);
        
        $this->loadLibrary('libraries','Yahoo','inc');
        
        // Let' create a Yahoo session everywhere
        // oauth dance if not authenticated
        $this->yahoo_session = YahooSession::requireSession(
                Kohana::$config->load('app')->get('OAUTH_CONSUMER_KEY'),
                Kohana::$config->load('app')->get('OAUTH_CONSUMER_SECRET'), 
                Kohana::$config->load('app')->get('OAUTH_APP_ID'));
    }

    
    /**
     * We try to found the requested library
     * @param String $dir
     * @param String $file
     * @param String $ext
     */
    protected function loadLibrary($dir,$file,$ext){
        try{
            if ($path = Kohana::find_file($dir, $file, $ext)){

                ini_set('include_path',
                ini_get('include_path').PATH_SEPARATOR.dirname(dirname($path)));

                require_once $dir . DIRECTORY_SEPARATOR.$file . '.' . $ext;
            }else{
                echo 'Path not found: ' . $dir . DIRECTORY_SEPARATOR . $file . '.' . $ext . '</br>';
            }       
        }  catch (Exception $e){
            print_r($e);
        }          

    }
    
}

?>
