<?php

// Pokud nepoužíváš autoloader, je dobré se ujistit, že máme načtený základní Model a připojení k DB
require_once '../app/models/Database.php';

class Book {

    /**
     * Uloží novou knihu do databáze.
     * * @param array $data Pole obsahující 'title', 'author', 'year', 'description'
     * @return bool Vrací true při úspěchu, false při chybě
     */
    public static function create($data) {
        $database = new Database(); 
        $db = $database->getConnection(); 

        // SQL dotaz pro všechna pole z tvého formuláře
        $sql = "INSERT INTO books (title, author, isbn, category, subcategory, year, price, link, description) 
                VALUES (:title, :author, :isbn, :category, :subcategory, :year, :price, :link, :description)";

        try {
            $stmt = $db->prepare($sql);

            // Spárování hodnot
            $result = $stmt->execute([
                ':title'       => $data['title'],
                ':author'      => $data['author'],
                ':isbn'        => $data['isbn'],
                ':category'    => $data['category'],
                ':subcategory' => $data['subcategory'],
                ':year'        => $data['year'],
                ':price'       => $data['price'],
                ':link'        => $data['link'],
                ':description' => $data['description']
            ]);

            return $result;
        } catch (PDOException $e) {
            // die("Chyba DB: " . $e->getMessage()); // Odkomentuj pro ladění, pokud by to nechtělo ukládat
            return false;
        }
    }
}