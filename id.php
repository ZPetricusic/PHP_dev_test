<?php

require_once "models/API.php";
require_once "models/Movie.php";


function main() {
    $provided_api_key = " ";
    
    # necessary for HTTP (MIME type)
    header("Content-Type: application/json");
    
    #$_SERVER['HTTP_API_KEY'] = "4985ba90ece24c965c2d3c4b64ebff49f301a2bc";
    
    # if the HTTP api-key request header is set
    if(isset($_SERVER['HTTP_API_KEY']))
        $provided_api_key = $_SERVER['HTTP_API_KEY'];
    else
        return json_encode(API::NO_API_KEY_PROVIDED);
    
    # validate the key
    $key_validity = API::checkAPIKey($provided_api_key);

    # if it exists and is below the requests quota
    if($key_validity === API::API_SUCCESS){

        # check if the get param is set and if it's a numerical value
        if(isset($_GET['id']) && preg_match("/^[0-9]+$/", $_GET['id'])){
            
            $movie = Movie::getById($_GET['id']);
    
            # if there's a movie with the selected id return it
            if($movie !== Movie::NO_ID_MATCH)
                return json_encode(['body' => $movie]);
            else
                return json_encode(Movie::NO_ID_MATCH);    
        }
        else{
            return json_encode(Movie::BAD_ID_FORMAT);
        }
    } else {
        # evaluates to one of the possible remaining errors
        return json_encode($key_validity);    
    }    
}

$result = main();

echo $result;
?>
