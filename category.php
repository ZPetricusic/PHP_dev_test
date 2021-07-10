<?php

require_once "models/API.php";
require_once "models/Movie.php";


function main() {
    $provided_api_key = " ";
    
    # MIME type
    header("Content-Type: application/json");
    
    #$_SERVER['HTTP_API_KEY'] = "4985ba90ece24c965c2d3c4b64ebff49f301a2bc";
    
    # look for the key in the header
    if(isset($_SERVER['HTTP_API_KEY']))
        $provided_api_key = $_SERVER['HTTP_API_KEY'];
    else
        return json_encode(API::NO_API_KEY_PROVIDED);
    
    # try to validate the key
    $key_validity = API::checkAPIKey($provided_api_key);

    if($key_validity === API::API_SUCCESS){

        # match only ASCII letters
        if(isset($_GET['category']) && preg_match("/^[A-Za-z]+$/", $_GET['category'])){
            
            $movie = Movie::getByCategory($_GET['category']);
            
            # if there are movies in the selected category
            if($movie !== Movie::NO_CATEGORY_MATCH)
                return json_encode(['body' => $movie]);
            else
                return json_encode(Movie::NO_CATEGORY_MATCH);    
        }
        else{
            return json_encode(Movie::BAD_CATEGORY_FORMAT);
        }
    } else {
        # returns any possible other errors
        return json_encode($key_validity);    
    }    
}

$result = main();

echo $result;
?>
