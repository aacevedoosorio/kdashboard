<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Custom model to make requests to Yahoo Fantasy Sports API
 *
 * @author alejandroacevedoosorio
 */
class FantasygamesModel extends Model{
    
    /**
     * 
     * @global type $YahooConfig
     * @param type $resource
     * @param type $parameters
     * @return type
     */
    function get_resource($resource, $parameters=array())
    {        
        global $YahooConfig;

        $request_url = sprintf("http://%s/fantasy/v2/users;use_login=1/%s",$YahooConfig["FANTASY_WS_HOSTNAME"], $resource);
        
        $request_url = 'http://' . $YahooConfig["FANTASY_WS_HOSTNAME"] . $resource;
        
        $client = $parameters['client'];
        unset($parameters['client']);
        
        $response = $client->get($request_url,$parameters);
        
        return (YahooUtil::is_response_error($response)) ? null : $response["responseBody"];
    }
    
}

?>
