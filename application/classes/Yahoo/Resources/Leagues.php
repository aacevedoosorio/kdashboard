<?php

/*
 * Yahoo Games stores all the information of a user fantasy games
 */

/**
 * Description of Yahoo_Resources_Teams
 *
 * @author aacevedo
 */
class Yahoo_Resources_Leagues extends Yahoo_Fantasygames{
    
    /**
     * User leagues
     * @var array 
     */
    private $leagues = array();
    
    
    public function parse_response($response){

        // Create the SimpleXML Object
        $xmlObject = new SimpleXMLElement($response);


        if( ! is_object($xmlObject->leagues->league))
            throwException ("No teams available for the user");
        
        foreach($xmlObject->leagues->league as $league){
            $object                                 = new stdClass();
            $object->league_key                     = (String)$league->league_key;
            $object->league_id                      = (int)$league->league_id;
            $object->name                           = (String)$league->name;
            $object->url                            = (String)$league->url;
            
            $this->leagues[(String)$league->league_key]   = $object;
        }
        
        return $this;        
        
    }

    /**
     * Gets the leagues info
     * @return array
     */
    public function get_leagues() {
        return $this->leagues;
    }



}

?>
