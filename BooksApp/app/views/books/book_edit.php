<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Upravit knihu</title>
    <style>
        /* Ponecháno pouze pro vlastní animaci zobrazení notifikací */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="font-sans bg-slate-50 text-slate-800 leading-relaxed py-8">
    
    <div class="max-w-[700px] mx-auto px-4 sm:px-6">
        
        <a href="<?= BASE_URL ?>/index.php" class="inline-block no-underline text-blue-600 font-semibold mb-6 transition-colors hover:text-blue-800 hover:underline">
            &larr; Zpět na seznam knih
        </a>

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
            <h2 class="text-[1.8rem] font-bold mb-2">Upravit knihu (ID: <?= htmlspecialchars($book['id']) ?>)</h2>
            <p class="text-slate-500 text-[0.95rem]">Upravujete data pro knihu: <strong class="text-slate-800 font-bold"><?= htmlspecialchars($book['title']) ?></strong></p>
        </div>
        
        <form action="<?= BASE_URL ?>/index.php?url=book/update/<?= htmlspecialchars($book['id']) ?>" method="post" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-slate-200">
            
            <div class="mb-5 flex flex-col">
                <label for="id_display" class="font-semibold mb-1.5 text-[0.9rem]">ID v databázi</label>
                <input type="text" id="id_display" value="<?= htmlspecialchars($book['id']) ?>" readonly class="p-3 border border-slate-200 rounded-md font-sans text-base bg-slate-100 cursor-not-allowed text-slate-500">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="title" class="font-semibold mb-1.5 text-[0.9rem]">Název knihy <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="author" class="font-semibold mb-1.5 text-[0.9rem]">Autor <span class="text-red-500">*</span></label>
                <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="isbn" class="font-semibold mb-1.5 text-[0.9rem]">ISBN <span class="text-red-500">*</span></label>
                <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="category" class="font-semibold mb-1.5 text-[0.9rem]">Kategorie</label>
                <input type="text" id="category" name="category" value="<?= htmlspecialchars($book['category']) ?>" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="subcategory" class="font-semibold mb-1.5 text-[0.9rem]">Podkategorie</label>
                <input type="text" id="subcategory" name="subcategory" value="<?= htmlspecialchars($book['subcategory'] ?? '') ?>" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="year" class="font-semibold mb-1.5 text-[0.9rem]">Rok vydání <span class="text-red-500">*</span></label>
                <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>" required class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="price" class="font-semibold mb-1.5 text-[0.9rem]">Cena knihy (Kč)</label>
                <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($book['price']) ?>" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="link" class="font-semibold mb-1.5 text-[0.9rem]">Odkaz (URL)</label>
                <input type="text" id="link" name="link" value="<?= htmlspecialchars($book['link']) ?>" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="description" class="font-semibold mb-1.5 text-[0.9rem]">Popis knihy</label>
                <textarea id="description" name="description" rows="5" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10"><?= htmlspecialchars($book['description']) ?></textarea>
            </div>    

            <div class="mb-5 flex flex-col">
                <label class="font-semibold mb-1.5 text-[0.9rem]">Obrázky knihy</label>
                
                <label for="images" class="group flex flex-col items-center justify-center text-center border-2 border-dashed border-slate-200 rounded-xl p-10 bg-white cursor-pointer transition-all text-slate-500 hover:border-blue-600 hover:bg-blue-50">
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="sr-only">
                    
                    <span class="font-bold text-[1.1rem] mb-1.5 text-slate-800 transition-colors group-hover:text-blue-600">Klikněte pro výběr obrázků</span>
                    <span class="text-[0.85rem] opacity-80">nebo je sem přetáhněte</span>
                    <span class="text-[0.85rem] opacity-80 mt-1">(JPG, PNG, WebP)</span>
                </label>
            </div>

            <button type="submit" class="w-full mt-2 bg-blue-600 text-white py-3 px-6 rounded-md font-bold text-base cursor-pointer transition-colors hover:bg-blue-700">Uložit změny do DB</button>
        </form>
    </div>

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