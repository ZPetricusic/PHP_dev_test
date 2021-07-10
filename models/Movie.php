<?php

require_once "db/db.php";

class Movie extends DB {

    # error mapping
    const BAD_TITLE_FORMAT = [
        'error' => 'Incorrect or no movie title provided'
    ]; 

    const NO_TITLE_MATCH = [
        'error' => 'No movie title matches the search query'
    ];

    const BAD_CATEGORY_FORMAT = [
        'error' => 'Incorrect or no movie category provided'
    ];

    const NO_CATEGORY_MATCH = [
        'error' => 'No movies match the requested category'
    ];

    const BAD_ID_FORMAT = [
        'error' => 'Incorrect or no movie ID provided'
    ];

    const NO_ID_MATCH = [
        'error' => 'No movie matches the requested ID'
    ];

    const DB_ERROR = [
        "error" => "Errored while contacting the Movie database"
    ];

    private $id;
    private $refcode;
    private $title;
    private $category;
    private $image;
    private $year;

    # create a Movie object
    # currently unnecessary, might need it in the future
    
    /*function __construct($id, $refcode, $title, $category, $image, $year)
    {
        $this->id = $id;
        $this->refcode = $refcode;
        $this->title = $title;
        $this->category = $category;
        $this->image = $image;
        $this->year = $year;
    }*/

    
    // task #1
    public static function getByTitle($title){

        try{
            $sql = "SELECT * FROM movie WHERE title LIKE :title";

            $db = new DB();

            #prepare the statement
            $stmt = $db->connect()->prepare($sql);

            # title contains $title somewhere
            $stmt->execute([
                "title" => "%".$title."%"
            ]);

            #save objects into the result field
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            #if records exist in the DB
            if($stmt->rowCount() > 0)
                #encode this because otherwise it goes out as an array
                return json_encode($result);
            else
                return Movie::NO_TITLE_MATCH;

        } catch(PDOException $e){
            return Movie::DB_ERROR;
        }
    }

    // task #2
    public static function getById($id){

        try {

            $sql = "SELECT * FROM movie WHERE id = :id";

            $db = new DB();

            $stmt = $db->connect()->prepare($sql);

            $stmt->execute([
                "id" => $id
            ]);

            #fetchAll instead of fetch for consistency sake (JSON parsing)
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            # if records exist in the DB
            if($stmt->rowCount() > 0)
                return json_encode($result);
            else
                return Movie::NO_ID_MATCH;

        } catch (PDOException $e) {
            return Movie::DB_ERROR;
        }
    }

    public static function getByCategory($category){

        try {

            $sql = "SELECT * FROM movie WHERE category = :category";

            $db = new DB();

            $stmt = $db->connect()->prepare($sql);

            $stmt->execute([
                "category" => $category
            ]);

            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            # if records exist in the DB
            if($stmt->rowCount() > 0)
                return json_encode($result);
            else
                return Movie::NO_CATEGORY_MATCH;

        } catch (PDOException $e) {
            return Movie::DB_ERROR;
        }
    }
}

?>