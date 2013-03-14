<?php

/*
 * Yahoo Games stores all the information of a user fantasy games
 */

/**
 * Description of Yahoo_Resources_Teams
 *
 * @author aacevedo
 */
class Yahoo_Resources_Teams extends Yahoo_Fantasygames{
    
    /**
     * Actual season
     * @var int 
     */
    private $season = 2013;
    
    /**
     * User teams
     * @var array 
     */
    private $teams = array();
    
    /**
     * User leagues
     * @var array 
     */
    private $leagues = array();
    
    
    public function parse_response($response){

        // Create the SimpleXML Object
        $xmlObject = new SimpleXMLElement($response);
        if( ! is_object($xmlObject->users->user->games->game->teams))
            throwException ("No teams available for the user");

        $this->season = (int)$xmlObject->users->user->games->game->season;
        
        foreach($xmlObject->users->user->games->game->teams->team as $team){
            $object                                 = new stdClass();
            $object->team_key                       = (String)$team->team_key;
            $object->team_id                        = (int)$team->team_id;
            $object->name                           = (String)$team->name;
            $object->url                            = (String)$team->url;
            $object->team_logos                     = json_decode(json_encode($team->team_logos));
            
            // Parse the league id
            $team_key_array                         = explode('.', $object->team_key,4);
            array_pop($team_key_array);
            $object->league                         = new stdClass();
            $object->league->key                    = implode('.',$team_key_array);
            $this->leagues[]                        = $object->league->key;
            
            $this->teams[(String)$team->team_key]   = $object;
        }
        
        return $this;
    }
    
    /**
     * Returns the actual season ontained from the API call
     * @return int
     */
    public function get_season() {
        return $this->season;
    }

    
    /**
     * Builds a custom html response for this object
     */
    public function build_html($type='html') {
        $html = '<table>';
        
        foreach($this->teams as $team_object){
            $html .= '<tr>';
            $html .= "<td>".$team_object->name."</td>" . 
                        "<td>".html::anchor($team_object->url,$team_object->name,array('target' => '_blank'))."</td>" .
                        "<td>".html::image($team_object->team_logos->team_logo->url)."</td>" .
                        "<td>".$team_object->name."</td>"
                ;
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        
        return $html;
    }
    
    /**
     * Get the diferent leagues of the user
     * @return array
     */
    public function get_leagues() {
        return $this->leagues;
    }


    public function merge_league_info($leagues_array){
        foreach($leagues_array as $league_key => $league_object){
            foreach($this->teams as $team_key => $team_object){
                if($league_key === $team_object->leagues->key){
                    echo "Encontrada: " . $league_key;
                    print_r($this->teams[$team_key]);
                    break;
                }    
            }
        }
    }
    
}

?>
