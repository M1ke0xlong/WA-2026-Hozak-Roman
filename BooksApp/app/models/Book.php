<?php

class Book {
    // Definice, že proměnná $db musí být vždy instancí třídy PDO
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    // Vytvoření nové knihy s vazbou na uživatele (created_by)
    public function create(
        string $title,
        string $author,
        int $category,
        int $subcategory,
        int $year,
        float $price,
        string $isbn,
        string $description,
        string $link,
        array $images,
        int $userId // NOVÝ PARAMETR PRO ID UŽIVATELE
    ): bool {
        // Přidali jsme created_by do INSERT i VALUES
        $sql = "INSERT INTO books (title, author, category, subcategory, year, price, isbn, description, link, images, created_by)
                VALUES (:title, :author, :category, :subcategory, :year, :price, :isbn, :description, :link, :images, :created_by)";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':subcategory' => $subcategory ?: null,
            ':year' => $year,
            ':price' => $price,
            ':isbn' => $isbn,
            ':description' => $description,
            ':link' => $link,
            ':images' => json_encode($images),
            ':created_by' => $userId // Předání ID do databáze
        ]);
    }

    // Získání všech knih z databáze
        // Získání všech knih z databáze (Nyní včetně názvu kategorie)
    public function getAll() {
        
        // 💡 ZMĚNA: Místo "SELECT *" použijeme přesnější dotaz s JOINem
        $sql = "SELECT books.*, categories.name AS category_name 
                FROM books 
                LEFT JOIN categories ON books.category = categories.id 
                ORDER BY books.id DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Získání jedné konkrétní knihy podle jejího ID
    public function getById($id) {
    // Použijeme LEFT JOIN, aby se kniha ukázala, i kdyby náhodou kategorii neměla
    $sql = "SELECT 
                books.*, 
                categories.name AS category_name, 
                subcategories.name AS subcategory_name
            FROM books
            LEFT JOIN categories ON books.category = categories.id
            LEFT JOIN subcategories ON books.subcategory = subcategories.id
            WHERE books.id = :id";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    // Aktualizace existující knihy
    public function update(
        $id, $title, $author, $category, $subcategory, 
        $year, $price, $isbn, $description, $link, $images = []
    ) {
        $sql = "UPDATE books 
                SET title = :title, 
                    author = :author, 
                    category = :category, 
                    subcategory = :subcategory, 
                    year = :year, 
                    price = :price, 
                    isbn = :isbn, 
                    description = :description, 
                    link = :link, 
                    images = :images
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':subcategory' => $subcategory ?: null,
            ':year' => $year,
            ':price' => $price,
            ':isbn' => $isbn,
            ':description' => $description,
            ':link' => $link,
            ':images' => json_encode($images)
        ]);
    }

    // Trvalé smazání knihy z databáze
    public function delete($id) {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([':id' => $id]);
    }
}