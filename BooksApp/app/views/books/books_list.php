<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Knihovna - Seznam knih</title>
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
                <li><a href="<?= BASE_URL ?>/index.php?url=book/create" class="text-slate-800 font-semibold transition-colors duration-300 hover:text-blue-600">Přidat novou knihu</a></li>
            </ul>
        </nav>
    </header>

    <main class="max-w-[900px] mx-auto px-6 overflow-x-auto">
        <?php if (!empty($_SESSION['flash_messages'])): ?>
            <div class="flex flex-col gap-3 mb-6">
                <?php foreach ($_SESSION['flash_messages'] as $msg): ?>
                    <?php 
                        // Jednoduché přiřazení Tailwind barev podle typu zprávy
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
        <h2 class="mb-2 text-[1.8rem] font-bold">Dostupné knihy</h2>

        <?php if (empty($books)): ?>
        <p class="text-slate-500 mb-6">V databázi se zatím nenachází žádné knihy.</p>
        <?php else: ?>
        <table class="w-full border-separate border-spacing-0 bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200 mt-4 text-xs sm:text-[0.95rem]">
            <thead class="bg-slate-100">
                <tr>
                    <th class="text-center p-4 font-bold text-[0.85rem] uppercase tracking-wider text-slate-600 border-b border-slate-200">ID</th>
                    <th class="text-center p-4 font-bold text-[0.85rem] uppercase tracking-wider text-slate-600 border-b border-slate-200">Název knihy</th>
                    <th class="text-center p-4 font-bold text-[0.85rem] uppercase tracking-wider text-slate-600 border-b border-slate-200">Autor</th>
                    <th class="text-center p-4 font-bold text-[0.85rem] uppercase tracking-wider text-slate-600 border-b border-slate-200">Rok vydání</th>
                    <th class="text-center p-4 font-bold text-[0.85rem] uppercase tracking-wider text-slate-600 border-b border-slate-200">Cena</th>
                    <th class="text-center p-4 font-bold text-[0.85rem] uppercase tracking-wider text-slate-600 border-b border-slate-200">Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr class="hover:bg-slate-50 group">
                    <td class="text-center p-4 border-b border-slate-200 align-middle group-last:border-b-0"><?= htmlspecialchars($book['id']) ?></td>
                    <td class="text-center p-4 border-b border-slate-200 align-middle group-last:border-b-0"><strong class="font-bold"><?= htmlspecialchars($book['title']) ?></strong></td>
                    <td class="text-center p-4 border-b border-slate-200 align-middle group-last:border-b-0"><?= htmlspecialchars($book['author']) ?></td>
                    <td class="text-center p-4 border-b border-slate-200 align-middle group-last:border-b-0"><?= htmlspecialchars($book['year']) ?></td>
                    <td class="text-center p-4 border-b border-slate-200 align-middle group-last:border-b-0"><?= htmlspecialchars($book['price']) ?> Kč</td>
                    <td class="text-center p-4 border-b border-slate-200 align-middle group-last:border-b-0">
                        <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" class="text-blue-600 font-semibold text-[0.85rem] transition-colors hover:text-blue-800 hover:underline">Detail</a> |
                        <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="text-blue-600 font-semibold text-[0.85rem] transition-colors hover:text-blue-800 hover:underline">Upravit</a> |
                        <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" class="text-red-500 font-semibold text-[0.85rem] transition-colors hover:text-red-700 hover:underline" onclick="return confirm('Opravdu chcete tuto knihu smazat?')">Smazat</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </main>

    <footer class="text-center mt-12 p-8 border-t border-slate-200 text-sm text-slate-400">
        <p>&copy; WA 2026 - Výukový projekt</p>
    </footer>

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