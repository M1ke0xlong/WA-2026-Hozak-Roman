<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Aplikace Knihovna</h1>
        
        <nav>
            <ul>
                <li><a href="/WA-2026-Hozak-Roman/BooksApp/public/index.php">Seznam knih (Domů)</a></li>
                <li><a href="/WA-2026-Hozak-Roman/BooksApp/public/index.php?url=book/create">Přidat novou knihu</a></li>
            </ul>
        </nav>
    </header>
    <div>
        <div>
            <h2>Přidat novou knihu</h2>
            <p>Vyplňte údaje a uložte knihu do databáze.</p>
        </div>
        <div>
            <form action="/WA-2026-Hozak-Roman/BooksApp/public/index.php?url=book/store" method="POST">
                <div>
                    <div>
                        <label for="title">Název knihy <span>*</span></label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div>
                        <label for="author">Autor knihy <span>*</span></label>
                        <input type="text" id="author" name="author" placeholder="Přijmení, jméno" required>
                    </div>
                    <div>
                        <label for="isbn">ISBN <span>*</span></label>
                        <input type="text" id="ISBN" name="ISBN" required>
                    </div>
                    <div>
                        <label for="category">Kategorie </label>
                        <input type="text" id="category" name="category">
                    </div>
                    <div>
                        <label for="subcategory">Podkategorie </label>
                        <input type="text" id="subcategory" name="subcategory">
                    </div>
                    <div>
                        <label for="year">Rok vydání  <span>*</span></label>
                        <input type="number" id="year" name="year" required>
                    </div>
                    <div>
                        <label for="price">Cena </label>
                        <input type="number" id="price" name="price" step="0.5">
                    </div>
                    <div>
                        <label for="link">Odkaz </label>
                        <input type="text" id="link" name="link">
                    </div>
                    <div>
                        <label for="description">Popis knihy </label>
                        <textarea id="description" name="description" rows="10" cols="50"></textarea>
                    </div>
                    <div>
                        <button type="submit">Uložit knihu do DB</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</body>
</html>