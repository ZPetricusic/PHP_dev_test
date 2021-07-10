<?php

require_once "models/API.php";
require_once "models/Movie.php";

$provided_api_key = " ";
$result;

header("Content-Type: application/json");

//$_SERVER['HTTP_API_KEY'] = "4985ba90ece24c965c2d3c4b64ebff49f301a2bc";

if(isset($_SERVER['HTTP_API_KEY'])){
    $provided_api_key = $_SERVER['HTTP_API_KEY'];
}
else{
    $result =  json_encode([
        'error' => 'Wrong API key provided'
    ]);
    
}
if(API::checkAPIKey($provided_api_key)){
    if(isset($_GET['id'])){
        
        $movie = Movie::getById($_GET['id']);

        if($movie)
            $result =  json_encode($movie);
        else
            $result = json_encode([
                'error' => 'Wrong movie id provided'
            ]);    
    }
    else{
        $result = json_encode([
            'error' => 'Wrong movie id provided'
        ]);
    }
}else{
    $result = json_encode([
        'error' => 'Sta se desilo'
    ]);    
}

echo "
<p>
        ".$result."
</p>";
?>
