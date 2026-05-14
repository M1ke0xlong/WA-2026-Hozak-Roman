<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-[800px] mx-auto px-4 sm:px-6 py-8">
    
    <!-- PŘÍMÁ IMPLEMENTACE FLASH MESSAGES (aby to neházelo Warning) -->
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
        
        <!-- Hlavička karty -->
        <div class="bg-slate-100 px-6 py-5 border-b border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800"><?= htmlspecialchars($book['title']) ?></h2>
            <p class="text-slate-500 mt-1">Detailní informace o záznamu (ID: <?= htmlspecialchars($book['id']) ?>)</p>
        </div>

        <!-- SEKCE: GALERIE OBRÁZKŮ -->
        <?php 
            $images = [];
            // Dekódování JSONu z databáze
            if (!empty($book['images'])) {
                $images = json_decode($book['images'], true) ?: [];
            }
        ?>

        <?php if (!empty($images)): ?>
            <div class="p-6 bg-slate-50 border-b border-slate-100">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 text-center sm:text-left">Galerie obrázků</h3>
                <div class="flex flex-wrap justify-center sm:justify-start gap-4">
                    <?php foreach ($images as $img): ?>
                        <div class="relative w-28 h-40 overflow-hidden rounded-lg shadow-md border-2 border-white cursor-zoom-in hover:scale-105 hover:ring-2 hover:ring-blue-500 transition-all duration-200">
                            <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($img) ?>" 
                                 alt="Náhled knihy" 
                                 class="w-full h-full object-cover"
                                 onclick="openModal(this.src)">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- SEKCE: DATA KNIHY -->
        <div class="px-6 py-2">
            <dl class="divide-y divide-slate-100">
                
                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 italic text-sm text-slate-400">
                    <dt class="font-semibold uppercase tracking-wide">Autor</dt>
                    <dd class="text-base text-slate-800 sm:col-span-2 font-medium not-italic"><?= htmlspecialchars($book['author']) ?></dd>
                </div>

                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 italic text-sm text-slate-400">
                    <dt class="font-semibold uppercase tracking-wide">ISBN</dt>
                    <dd class="text-base text-slate-800 sm:col-span-2 not-italic"><?= htmlspecialchars($book['isbn'] ?? 'Nezadáno') ?></dd>
                </div>

                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 italic text-sm text-slate-400">
                    <dt class="font-semibold uppercase tracking-wide">Kategorie</dt>
                    <dd class="text-base text-slate-800 sm:col-span-2 not-italic">
                        <span class="font-bold text-blue-600">
                            <?= htmlspecialchars($book['category_name'] ?? 'Nezadáno') ?>
                        </span>
                        <?php if (!empty($book['subcategory_name'])): ?>
                            <span class="text-slate-300 mx-2">|</span> 
                            <span class="text-slate-600 font-medium"><?= htmlspecialchars($book['subcategory_name']) ?></span>
                        <?php endif; ?>
                    </dd>
                </div>

                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 italic text-sm text-slate-400">
                    <dt class="font-semibold uppercase tracking-wide">Rok vydání</dt>
                    <dd class="text-base text-slate-800 sm:col-span-2 not-italic"><?= htmlspecialchars($book['year']) ?></dd>
                </div>

                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 italic text-sm text-slate-400">
                    <dt class="font-semibold uppercase tracking-wide">Cena</dt>
                    <dd class="text-base sm:col-span-2 not-italic">
                        <?php if (!empty($book['price'])): ?>
                            <span class="font-black text-green-600"><?= number_format($book['price'], 0, ',', ' ') ?> Kč</span>
                        <?php else: ?>
                            <span class="italic text-slate-400">Cena není uvedena</span>
                        <?php endif; ?>
                    </dd>
                </div>

                <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 italic text-sm text-slate-400">
                    <dt class="font-semibold uppercase tracking-wide">Odkaz</dt>
                    <dd class="text-base sm:col-span-2 not-italic">
                        <?php if (!empty($book['link'])): ?>
                            <a href="<?= htmlspecialchars($book['link']) ?>" target="_blank" class="text-blue-500 hover:text-blue-700 underline decoration-blue-200 underline-offset-4 break-all transition-colors">
                                Přejít na web &rarr;
                            </a>
                        <?php else: ?>
                            <span class="italic text-slate-400">Bez odkazu</span>
                        <?php endif; ?>
                    </dd>
                </div>

                <div class="py-6 flex flex-col">
                    <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Popis knihy</dt>
                    <dd class="text-slate-700 leading-relaxed whitespace-pre-wrap bg-slate-50 p-4 rounded-lg border border-slate-100 italic"><?= htmlspecialchars($book['description'] ?? 'Popis zatím nebyl přidán.') ?></dd>
                </div>

            </dl>
        </div>

        <!-- Akční tlačítka -->
        <div class="bg-slate-100 px-6 py-5 border-t border-slate-200 flex flex-col sm:flex-row gap-3 sm:justify-end items-center">
            
            <a href="<?= BASE_URL ?>/index.php" class="text-slate-500 hover:text-slate-800 transition-colors font-semibold text-sm mr-auto group">
                <span class="group-hover:-translate-x-1 inline-block transition-transform">&larr;</span> Zpět na seznam
            </a>

            <!-- Tlačítka se ukáží jen přihlášenému autorovi -->
            <?php if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$book['created_by']): ?>
                <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= htmlspecialchars($book['id']) ?>" class="w-full sm:w-auto text-center px-6 py-2.5 bg-white border border-slate-300 text-slate-700 font-bold rounded-lg shadow-sm hover:bg-slate-50 hover:border-blue-300 hover:text-blue-600 transition-all">
                    Upravit
                </a>
                <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= htmlspecialchars($book['id']) ?>" 
                   onclick="return confirm('Vážně chceš tuhle knihu smazat z existence?')" 
                   class="w-full sm:w-auto text-center px-6 py-2.5 bg-red-50 text-red-600 font-bold border border-red-200 rounded-lg hover:bg-red-600 hover:text-white transition-all">
                    Smazat
                </a>
            <?php endif; ?>
        </div>

    </div>
</main>

<!-- MODÁLNÍ OKNO PRO GALERII (ROZKLIKNUTÍ) -->
<div id="imageModal" class="fixed inset-0 bg-slate-900/95 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm cursor-zoom-out" onclick="closeModal()">
    <div class="relative max-w-5xl max-h-full">
        <button class="absolute -top-12 right-0 text-white text-4xl hover:text-blue-400 transition-colors">&times;</button>
        <img id="modalImg" src="" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl border-4 border-white/10 transition-all duration-300 scale-95 opacity-0">
    </div>
</div>

<script>
    function openModal(src) {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImg');
        
        modal.classList.remove('hidden');
        img.src = src;
        
        // Animace náběhu
        setTimeout(() => {
            img.classList.remove('scale-95', 'opacity-0');
            img.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImg');
        
        img.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Zavření pomocí klávesy Esc
    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape") closeModal();
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>