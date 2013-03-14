<?php

/*
 * Class that makes the requests and stores the information of a fantasy game
 */

/**
 * Description of Yahoo_Requests
 *
 * @author aacevedo
 */
abstract class Yahoo_Fantasygames {
    
    /**
     * Debug or not debug
     */
    private $debug = TRUE;
    

    /**
     * @private oauth client
     */
    private $client = NULL;

    
     /*
     * To store the instance of the Yahoo_Fantasysports
     * @var Yahoo_Fantasysports instance 
     */
    protected static $instance  = NULL;
    
    /**
     * Driver that we are loading
     * @var String 
     */
    protected static $driver    = NULL;    
    
    
    /**
     * Constructor of the Yahoo_Fantasysports instance 
     * 
     * @param YahooSession Object $session
     */
    public function __construct() {
        
    }
    
    /**
     * Creates a new Yahoo_Fantasysports instance and returns it.
     * @param String $driver Name of the driver to instantiate Ex. Teams, Players
     * @return Yahoo_Fantasysports
     */
    public static function instance($driver)
    {
        if (self::$instance == NULL OR self::$driver != $driver)
        {
            $class = 'Yahoo_Resources_'.$driver;
            self::$instance = new $class;
            self::$driver   = $driver;
        }
        return self::$instance;
    }
    
    /**
     * 
     * @global type $YahooConfig
     * @param String $resource
     * @param array $parameters
     * @return array
     */
    function get_resource($resource, $parameters=array("format" => 'xml'))
    {
        // Complete the parameters
        $parameters['client'] = $this->client;
        
        // Instantiate the Model to make the request to Fantasy Sports API
        $model_object = Model::factory(self::$driver);
        
        $response = NULL;
        
        try {
            // Check if we have the response already Cached
            $yahoo_resources_object = Cache::instance('default')->get($this->client->token->guid . self::$driver);
            if( ! isset($yahoo_resources_object)){
                $yahoo_resources_object = $model_object->get_resource($resource, $parameters);
                Cache::instance('default')->set($this->client->token->guid . self::$driver,$yahoo_resources_object);
            }
            
            $this->parse_response($yahoo_resources_object);
            
            
        } catch (Exception $exc) {
            //echo $exc->getMessage();
            //echo $exc->getTrace();
            echo $exc->getTraceAsString();
        }



        return self::$instance;
    }
    
    /**
     * Sets the debug flag
     * @param type $debug
     */
    public function set_debug($debug) {
        $this->debug = $debug;
        
        return self::$instance;
    }

    /**
     * Adds a row to the log
     * @param String $level
     * @param String $message
     */
    protected function log($level = Log::DEBUG, $message){
        if($this->debug){
            Log::instance()->add($level, $message);
        }
    }
    
    public function set_client($client) {
        $this->client = $client;
        
        return self::$instance;
    }

    
    public function build_html($type){
        return "<div></div>";
    }
    
    
    protected function return_json($response){
        return json_encode($response);
    }

}

?>
