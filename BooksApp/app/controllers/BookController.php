<?php

class BookController {

    // 0. Výchozí metoda pro zobrazení úvodní stránky
    public function index() {
        // V dalších krocích se zde přidá komunikace s Modelem pro získání dat z databáze
        // (např. načtení všech uložených knih)
        
        // Nyní se pouze načte (vloží) připravený soubor s HTML strukturou
        require_once '../app/views/books/books_list.php';
    }

    // 1. Zobrazení formuláře pro přidání nové knihy
    public function create() {
        // Zde se pouze načte (vloží) připravený soubor s HTML formulářem
        require_once '../app/views/books/book_create.php';
    }

    // 2. Zpracování dat odeslaných z formuláře
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Získání a očištění všech polí z tvého formuláře
            $title       = htmlspecialchars(trim($_POST['title'] ?? ''));
            $author      = htmlspecialchars(trim($_POST['author'] ?? ''));
            $isbn        = htmlspecialchars(trim($_POST['ISBN'] ?? '')); // Pozor, v HTML máš name="ISBN"
            $category    = htmlspecialchars(trim($_POST['category'] ?? ''));
            $subcategory = htmlspecialchars(trim($_POST['subcategory'] ?? ''));
            $year        = htmlspecialchars(trim($_POST['year'] ?? ''));
            $price       = htmlspecialchars(trim($_POST['price'] ?? ''));
            $link        = htmlspecialchars(trim($_POST['link'] ?? ''));
            $description = htmlspecialchars(trim($_POST['description'] ?? ''));

            // 2. Kontrola povinných polí (podle required z tvého HTML)
            if (empty($title) || empty($author) || empty($isbn) || empty($year)) {
                $this->addErrorMessage('Vyplňte prosím všechna povinná pole označená hvězdičkou.');
                header('Location: /WA-2026-Hozak-Roman/BooksApp/public/index.php?url=book/create');
                exit;
            }

            require_once '../app/models/Book.php';

            // 3. Odeslání všech dat do Modelu k uložení
            $isSaved = Book::create([
                'title'       => $title,
                'author'      => $author,
                'isbn'        => $isbn,
                'category'    => $category,
                'subcategory' => $subcategory,
                'year'        => $year,
                'price'       => $price,
                'link'        => $link,
                'description' => $description
            ]);

            // Zbytek logiky pro přesměrování při úspěchu/neúspěchu zůstává stejný...
            if ($isSaved) {
                $this->addSuccessMessage('Kniha byla úspěšně uložena.');
                header('Location: /WA-2026-Hozak-Roman/BooksApp/public/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nepodařilo se uložit knihu do databáze.');
                header('Location: /WA-2026-Hozak-Roman/BooksApp/public/index.php?url=book/create');
                exit;
            }
        } else {
            $this->addNoticeMessage('Pro přidání knihy je nutné odeslat formulář.');
            header('Location: /WA-2026-Hozak-Roman/BooksApp/public/index.php?url=book/create');
            exit;
        }
    }

    // --- Pomocné metody pro systém notifikací ---
    // (V reálném projektu by tyto metody ideálně ležely v hlavní nadřazené třídě Controller)

    protected function addSuccessMessage($message) {
        // Zde by byla logika pro uložení zelené zprávy o úspěchu (např. do $_SESSION)
    }

    protected function addNoticeMessage($message) {
        // Zde by byla logika pro uložení žluté informativní zprávy (např. do $_SESSION)
    }

    protected function addErrorMessage($message) {
        // Zde by byla logika pro uložení červené chybové zprávy (např. do $_SESSION)
    }
}