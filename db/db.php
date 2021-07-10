<?php

class DB {

    /*
    This would usually go into a seperate file
    or env variable but for the purposes of this test
    I won't be doing that
    */

    # DB info
    private $server = "127.0.0.1";
    private $username = "root";
    private $password = "";
    private $dbname = "movies";

    protected function connect(){

        #save the credentials in a string to clean the code
        $creds = "mysql:host=".$this->server.";dbname=".$this->dbname;

        #connect
        $con = new PDO($creds, $this->username, $this->password);

        # set error reporting mode to throw an exception
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $con;

    }
}
?>