<?php

require_once "models/API.php";
require_once "models/Movie.php";


function main() {
    $provided_api_key = " ";
    
    # MIME type
    header("Content-Type: application/json");
    
    #$_SERVER['HTTP_API_KEY'] = "4985ba90ece24c965c2d3c4b64ebff49f301a2bc";
    
    # try to find the key in the HTTP header
    if(isset($_SERVER['HTTP_API_KEY']))
        $provided_api_key = $_SERVER['HTTP_API_KEY'];
    else
        return json_encode(API::NO_API_KEY_PROVIDED);
    
    # try to validate it
    $key_validity = API::checkAPIKey($provided_api_key);

    if($key_validity === API::API_SUCCESS){
        # accept letters, numbers and spaces
        if(isset($_GET['title']) && preg_match("/^[0-9a-zA-Z ]+$/", $_GET['title'])){
            
            $movie = Movie::getByTitle($_GET['title']);
            
            # if there are movies resembling the queried title return them
            if($movie !== Movie::NO_TITLE_MATCH)
                return json_encode(['body' => $movie]);
            else
                return json_encode(Movie::NO_TITLE_MATCH);    
        }
        else{
            return json_encode(Movie::BAD_TITLE_FORMAT);
        }
    } else {
        # other errors
        return json_encode($key_validity);    
    }    
}

$result = main();

echo $result;
?>
