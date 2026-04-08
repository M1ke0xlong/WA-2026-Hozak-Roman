<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Přidat novou knihu</title>
    <style>
        /* Ponecháno pouze pro vlastní animaci zobrazení notifikací */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="font-sans bg-slate-50 text-slate-800 leading-relaxed pb-8">
    
    <header class="bg-white border-b border-slate-200 py-6 px-6 sm:px-[5%] flex flex-col sm:flex-row justify-between items-center shadow-sm mb-8 gap-4 sm:gap-0">
        <h1 class="text-2xl text-blue-600 font-bold">Aplikace Knihovna</h1>

        <nav>
            <ul class="list-none flex flex-col sm:flex-row gap-2 sm:gap-6 text-center">
                <li><a href="<?= BASE_URL ?>/index.php" class="text-slate-800 font-semibold transition-colors duration-300 hover:text-blue-600">Seznam knih (Domů)</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?url=book/create" class="text-blue-600 font-semibold transition-colors duration-300 hover:text-blue-800">Přidat novou knihu</a></li>
            </ul>
        </nav>
    </header>

    <main class="max-w-[700px] mx-auto px-4 sm:px-6">
        
        <?php if (!empty($_SESSION['flash_messages'])): ?>
            <div class="flex flex-col gap-3 mb-6">
                <?php foreach ($_SESSION['flash_messages'] as $msg): ?>
                    <?php 
                        $bgColors = [
                            'success' => 'bg-green-100 text-green-800 border-green-200',
                            'error'   => 'bg-red-100 text-red-800 border-red-200',
                            'notice'  => 'bg-yellow-100 text-yellow-800 border-yellow-200'
                        ];
                        $type = $msg['type'] ?? 'notice';
                        $colorClasses = $bgColors[$type] ?? $bgColors['notice'];
                    ?>
                    <div class="alert px-6 py-4 rounded-lg text-[0.95rem] font-semibold flex justify-between items-center shadow-sm border animate-[slideDown_0.3s_ease-out_forwards] <?= $colorClasses ?>">
                        <span><?= htmlspecialchars($msg['text']) ?></span>
                        <button type="button" class="bg-transparent border-none text-inherit text-xl leading-none cursor-pointer opacity-60 ml-4 p-0 transition-opacity hover:opacity-100" onclick="this.parentElement.remove();">&times;</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['flash_messages']); ?>
        <?php endif; ?>

        <div class="mb-8">
            <h2 class="text-[1.8rem] font-bold mb-2">Přidat novou knihu</h2>
            <p class="text-slate-500 text-[0.95rem]">Vyplňte údaje a uložte knihu do databáze.</p>
        </div>
        
        <form action="<?= BASE_URL ?>/index.php?url=book/store" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-slate-200">
            
            <div class="mb-5 flex flex-col">
                <label for="title" class="font-semibold mb-1.5 text-[0.9rem]">Název knihy <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" required class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="author" class="font-semibold mb-1.5 text-[0.9rem]">Autor knihy <span class="text-red-500">*</span></label>
                <input type="text" id="author" name="author" placeholder="Přijmení, jméno" required class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="ISBN" class="font-semibold mb-1.5 text-[0.9rem]">ISBN <span class="text-red-500">*</span></label>
                <input type="text" id="ISBN" name="ISBN" required class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="category" class="font-semibold mb-1.5 text-[0.9rem]">Kategorie</label>
                <input type="text" id="category" name="category" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="subcategory" class="font-semibold mb-1.5 text-[0.9rem]">Podkategorie</label>
                <input type="text" id="subcategory" name="subcategory" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="year" class="font-semibold mb-1.5 text-[0.9rem]">Rok vydání <span class="text-red-500">*</span></label>
                <input type="number" id="year" name="year" required class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="price" class="font-semibold mb-1.5 text-[0.9rem]">Cena (Kč)</label>
                <input type="number" id="price" name="price" step="0.5" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="link" class="font-semibold mb-1.5 text-[0.9rem]">Odkaz (URL)</label>
                <input type="text" id="link" name="link" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="description" class="font-semibold mb-1.5 text-[0.9rem]">Popis knihy</label>
                <textarea id="description" name="description" rows="6" class="p-3 w-full border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10"></textarea>
            </div>

            <div class="mb-5 flex flex-col">
                <label class="font-semibold mb-1.5 text-[0.9rem]">Obrázky (můžete nahrát více)</label>
                
                <label for="images" class="group flex flex-col items-center justify-center text-center border-2 border-dashed border-slate-200 rounded-xl p-10 bg-white cursor-pointer transition-all text-slate-500 hover:border-blue-600 hover:bg-blue-50">
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="sr-only">
                    
                    <span class="font-bold text-[1.1rem] mb-1.5 text-slate-800 transition-colors group-hover:text-blue-600">Klikni pro výběr souborů</span>
                    <span class="text-[0.85rem] opacity-80">JPG / PNG / WebP – více souborů najednou</span>
                </label>
            </div>

            <button type="submit" class="w-full mt-2 bg-blue-600 text-white py-3 px-6 rounded-md font-bold text-base cursor-pointer transition-colors hover:bg-blue-700">Uložit knihu do DB</button>
        </form>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alerts = document.querySelectorAll('.alert');
            
            if(alerts.length > 0) {
                setTimeout(() => {
                    alerts.forEach(alert => {
                        alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        
                        setTimeout(() => alert.remove(), 500);
                    });
                }, 4000);
            }
        });
    </script>
</body>

</html>