<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Login extends Controller {

    /**
     * Define the template to load
     * @var String 
     */
    public $template = 'login';
    
    public function __construct(\Request $request, \Response $response) {
//        $this->loadLibrary('libraries','Yahoo','inc');
        parent::__construct($request, $response);
    }

    public function index(){
        
        // invoke a view
        $this->template->message = 'hello, bitch!';
        
    }
    
    public function login(){
        //require_once APPPATH.'libraries/Yahoo/Yahoo.inc';
        
        YahooLogger::setDebug(TRUE);
        YahooLogger::setDebugDestination('CONSOLE');

        $benchmark = Profiler::start('Login_Teams', __FUNCTION__);
 

        $header   = '<h2><img src="http://delicious.com/favicon.ico" title="Delicious" width="16" height="16" />Delicious // social bookmarking</h2>';
        $content
        = '<div id="bookmarks">';
        echo 'Ahora';

        // if user is logged in and oauth is valid
        if(is_object($this->yahoo_session))
        {

            $this->redirect('/dashboard/init/');
            
          // get oauthed user guid + profile
          //$user = $session->getSessionedUser();

        }
        
        //
        
    }

} // End Welcome
