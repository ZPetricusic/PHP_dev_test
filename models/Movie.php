<?php

require_once "db/db.php";

class Movie extends DB {

    private $id;
    private $refcode;
    private $title;
    private $category;
    private $image;
    private $year;


    # create a Movie object
    function __construct($id, $refcode, $title, $category, $image, $year)
    {
        $this->id = $id;
        $this->refcode = $refcode;
        $this->title = $title;
        $this->category = $category;
        $this->image = $image;
        $this->year = $year;
    }

    // task #1
    public static function getByTitle($title){

        try{
            $sql = "SELECT * FROM movie WHERE title LIKE :title";

            $db = new DB();

            #prepare the statement
            $stmt = $db->connect()->prepare($sql);

            $stmt->execute([
                "title" => "%".$title."%"
            ]);

            #save objects into the result field, tmp
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            return json_encode($result);

        } catch(PDOException $e){
            
            return json_encode([
                'error' => 'Error while connecting to database'
            ]);

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

            $result = $stmt->fetch(PDO::FETCH_OBJ);

            return $result;

        } catch (PDOException $e) {
            return json_encode([
                'error' => 'Error while connecting to database'
            ]);
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

            return json_encode($result);

        } catch (PDOException $e) {
            
            return json_encode([
                'error' => 'Error while connecting to database'
            ]);

        }
    }
}

?>