<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Detail knihy - <?= htmlspecialchars($book['title']) ?></title>
    <style>
        /* Animace zobrazení notifikací */
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

    <main class="max-w-[800px] mx-auto px-4 sm:px-6">
        
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

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            
            <div class="bg-slate-100 px-6 py-5 border-b border-slate-200">
                <h2 class="text-2xl font-bold text-slate-800"><?= htmlspecialchars($book['title']) ?></h2>
                <p class="text-slate-500 mt-1">Detailní informace o záznamu (ID: <?= htmlspecialchars($book['id']) ?>)</p>
            </div>

            <div class="px-6 py-2">
                <dl class="divide-y divide-slate-100">
                    
                    <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                        <dt class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Autor</dt>
                        <dd class="text-base text-slate-800 sm:col-span-2 font-medium"><?= htmlspecialchars($book['author']) ?></dd>
                    </div>

                    <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                        <dt class="text-sm font-semibold text-slate-500 uppercase tracking-wide">ISBN</dt>
                        <dd class="text-base text-slate-800 sm:col-span-2"><?= htmlspecialchars($book['isbn'] ?? 'Nezadáno') ?></dd>
                    </div>

                    <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                        <dt class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Kategorie</dt>
                        <dd class="text-base text-slate-800 sm:col-span-2">
                            <?= htmlspecialchars($book['category'] ?? 'Nezadáno') ?>
                            <?php if (!empty($book['subcategory'])): ?>
                                <span class="text-slate-400 mx-2">/</span> <?= htmlspecialchars($book['subcategory']) ?>
                            <?php endif; ?>
                        </dd>
                    </div>

                    <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                        <dt class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Rok vydání</dt>
                        <dd class="text-base text-slate-800 sm:col-span-2"><?= htmlspecialchars($book['year']) ?></dd>
                    </div>

                    <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                        <dt class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Cena</dt>
                        <dd class="text-base text-slate-800 sm:col-span-2">
                            <?php if (!empty($book['price'])): ?>
                                <span class="font-bold text-green-600"><?= htmlspecialchars($book['price']) ?> Kč</span>
                            <?php else: ?>
                                <span class="italic text-slate-400">Nezadáno</span>
                            <?php endif; ?>
                        </dd>
                    </div>

                    <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                        <dt class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Odkaz</dt>
                        <dd class="text-base text-slate-800 sm:col-span-2">
                            <?php if (!empty($book['link'])): ?>
                                <a href="<?= htmlspecialchars($book['link']) ?>" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline break-all">
                                    <?= htmlspecialchars($book['link']) ?>
                                </a>
                            <?php else: ?>
                                <span class="italic text-slate-400">Bez odkazu</span>
                            <?php endif; ?>
                        </dd>
                    </div>

                    <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                        <dt class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Popis</dt>
                        <dd class="text-base text-slate-800 sm:col-span-2 whitespace-pre-wrap"><?= htmlspecialchars($book['description'] ?? 'Popis není k dispozici.') ?></dd>
                    </div>

                </dl>
            </div>

            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex flex-col sm:flex-row gap-3 sm:justify-end">
                <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= htmlspecialchars($book['id']) ?>" class="text-center px-5 py-2 bg-white border border-slate-300 text-slate-700 font-semibold rounded-md transition-colors hover:bg-slate-100 hover:text-blue-600">
                    Upravit knihu
                </a>
                <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= htmlspecialchars($book['id']) ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="text-center px-5 py-2 bg-red-50 text-red-600 font-semibold border border-red-200 rounded-md transition-colors hover:bg-red-600 hover:text-white">
                    Smazat knihu
                </a>
            </div>

        </div>
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