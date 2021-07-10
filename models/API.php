<?php

require_once "db/db.php";

abstract class API extends DB {

    public static function checkAPIKey($provided_key){

        try{

            $db = new DB();

            #I was thinking of using transactions for this (numOfReq) but decided it's not worth it

            #try to find the provided key in the base
            $sql = "SELECT * FROM api WHERE api_key = :provided_key";

            $stmt = $db->connect()->prepare($sql);

            $stmt->execute([
                "provided_key" => $provided_key
            ]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result){
                $db_key = $result['api_key'];
                $req_num = $result['requests'];
            }else{
                return false;
            }

            #compare it with the given key
            if($db_key !== $provided_key){
                return false;
            }
            else{
                
                #increase the request count
                $sql_req = "UPDATE api SET requests = :new_number";

                $stmt = $db->connect()->prepare($sql_req);

                # requests++
                $stmt->execute([
                    "new_number" => ($req_num + 1)
                ]);

                return true;
            }
        } catch(PDOException $e){
            return false;
        }
    }

}

?>