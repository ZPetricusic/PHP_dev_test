<?php

require_once "db/db.php";

abstract class API extends DB {

    # error mapping
    const NO_API_KEY_PROVIDED = [
        "error" => "No API key provided"
    ];

    const INVALID_API_KEY = [
        "error" => "Invalid API key provided"
    ];

    const REQUEST_QUOTA_REACHED = [
        "error" => "You have reached your allowed requests quota (1000)"
    ];

    const API_CALL_DELAY = [
        "error" => "You can only make a request every 2 seconds"
    ];

    const DB_ERROR = [
        "error" => "Errored while contacting the API database"
    ];

    # not really necessary but makes the code cleaner and easier to understand
    const API_SUCCESS = true;

    public static function checkAPIKey($provided_key){

        try{

            $db = new DB();

            # I was thinking of using transactions for this (numOfReq) but decided it's not worth it

            # try to find the provided key in the base
            $sql = "SELECT * FROM api WHERE api_key = :provided_key";

            $stmt = $db->connect()->prepare($sql);

            $stmt->execute([
                "provided_key" => $provided_key
            ]);

            # fetch instead of fetchAll for obvious reasons (primary key in DB)
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            # if there exists a record in the DB store its contents
            if($result){
                $db_key = $result['api_key'];
                $req_num = $result['requests'];
                $last_req_time = $result['last_request_time'];
            }else{
                return API::INVALID_API_KEY;
            }

            # disallow more than 1k requests
            if($req_num >= 1000) 
                return API::REQUEST_QUOTA_REACHED;
            
            # only allow calls every 2 seconds
            if(strtotime($last_req_time) + 2 > time())
                return API::API_CALL_DELAY;

            # compare it with the given key
            if($db_key !== $provided_key){
                return API::INVALID_API_KEY;
            }
            else{
                
                # increase the request count
                # and update the last api call time
                $sql_req = "UPDATE api SET requests = :new_number, last_request_time = :new_time
                            WHERE api_key = :api_key";

                $stmt = $db->connect()->prepare($sql_req);

                $stmt->execute([
                    "new_number" => ($req_num + 1),
                    # XXXX-XX-XX 24h:XX:XX
                    "new_time" => date("Y-m-d H:i:s"), #check the PHP docs for the format
                    "api_key" => $provided_key
                ]);

                return API::API_SUCCESS;
            }
        } catch(PDOException $e){
            return API::DB_ERROR;
        }
    }

}

?>