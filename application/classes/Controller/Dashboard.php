<?php defined('SYSPATH') or die('No direct script access.');


Class Controller_Dashboard extends Controller {

    /**
     * Define the template to load
     * @var String 
     */
    public $template = 'general';
    
    public function __construct(\Request $request, \Response $response) {
        $this->loadLibrary('libraries','Yahoo','inc');
        parent::__construct($request, $response);
    }

    
    public function init(){
        $this->template->message = 'Hey there';
        $yahoo_teams_object     = $this->get_teams();
        
        $yahoo_leagues_object   = $this->get_leagues($yahoo_teams_object->get_leagues());
        //print_r($yahoo_leagues_object);
        
        $yahoo_teams_object->merge_league_info($yahoo_leagues_object->get_leagues());
        
        $this->template->content = $yahoo_teams_object->build_html();
        
    }


    public function action(){
        
        $action = $this->request->param('parm1');
        $method = 'get_'.$action;
        
        // invoke a view
        $this->template->message = 'Hey there';
        
        // Depending on the action we request the different type of data
        $yahoo_resources_object = $this->yahoo_session->$method();
        
        $html_response = $yahoo_resources_object->build_html();
        

        $this->template->content = $html_response;
        
        
//        if (isset($benchmark))
//        {
//            // Stop the benchmark
//            Profiler::stop($benchmark);
//        }         
//        echo View::factory('profiler/stats');
        
    }

    
   /**
     * Gets the user teams.
     *
     * @return Yahoo_Resources_Teams The currently sessioned Yahoo_Resources_Teams.
     */
    function get_teams() {

        $yahoo_resources_teams = Yahoo_Fantasygames::instance('teams')
                ->set_client($this->yahoo_session->client)
                ->get_resource(Kohana::$config->load('teams')->get('default'));


        return $yahoo_resources_teams;
    }
    
    
   /**
     * Gets the user leagues.
     * @param array $teams_array
     * @return Yahoo_Resources_Leagues The currently sessioned Yahoo_Resources_Leagues.
     */
    function get_leagues($teams_array) {

        $yahoo_resources_leagues = Yahoo_Fantasygames::instance('leagues')
                ->set_client($this->yahoo_session->client)
                ->get_resource(Kohana::$config->load('leagues')->get('default') . implode(',', $teams_array));


        return $yahoo_resources_leagues;
    }
    
} // End Dashboard
