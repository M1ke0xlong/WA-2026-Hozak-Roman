<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-[80vw] mx-auto px-6 py-8">
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

    <div class="mb-6 flex justify-between items-end">
        <div>
            <h2 class="text-[1.8rem] font-bold text-slate-800">Dostupné knihy</h2>
            <p class="text-slate-500 text-sm italic">Procházejte katalog nebo přidejte vlastní kousek.</p>
        </div>
    </div>

    <?php if (empty($books)): ?>
        <div class="bg-white rounded-xl p-12 border border-slate-200 text-center shadow-sm">
            <p class="text-slate-400 font-medium">V databázi se zatím nenachází žádné knihy.</p>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full border-separate border-spacing-0 text-sm sm:text-base text-left">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-4 font-bold text-[0.8rem] uppercase tracking-wider text-slate-500 border-b border-slate-200 text-center">ID</th>
                        <th class="p-4 font-bold text-[0.8rem] uppercase tracking-wider text-slate-800 border-b border-slate-200">Název knihy</th>
                        <th class="p-4 font-bold text-[0.8rem] uppercase tracking-wider text-slate-500 border-b border-slate-200">Autor</th>
                        <th class="p-4 font-bold text-[0.8rem] uppercase tracking-wider text-slate-500 border-b border-slate-200">Kategorie</th>

                        <th class="p-4 font-bold text-[0.8rem] uppercase tracking-wider text-slate-500 border-b border-slate-200 text-center">Rok</th>
                        <th class="p-4 font-bold text-[0.8rem] uppercase tracking-wider text-slate-500 border-b border-slate-200 text-right">Cena</th>
                        <th class="p-4 font-bold text-[0.8rem] uppercase tracking-wider text-slate-500 border-b border-slate-200 text-center">Akce</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($books as $book): ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="p-4 text-center text-slate-400 font-mono text-xs"><?= htmlspecialchars($book['id']) ?></td>
                        <td class="p-4">
                            <strong class="text-slate-800 font-bold block group-hover:text-blue-600 transition-colors">
                                <?= htmlspecialchars($book['title']) ?>
                            </strong>
                        </td>
                        <td class="p-4 text-slate-600 italic"><?= htmlspecialchars($book['author']) ?></td>
                        <td class="p-4 text-center text-slate-600">
                            <?= htmlspecialchars($book['category_name'] ?? 'Nezařazeno') ?>
                        </td>
                        <td class="p-4 text-center text-slate-600"><?= htmlspecialchars($book['year']) ?></td>
                        <td class="p-4 text-right font-semibold text-emerald-600"><?= number_format($book['price'], 0, ',', ' ') ?> Kč</td>
                        
                        <td class="p-4">
                            <div class="flex justify-center items-center gap-4 text-[0.85rem]">
                                
                                <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" 
                                   class="text-blue-600 font-bold transition-colors hover:text-blue-800 underline decoration-blue-200 decoration-2 underline-offset-4 hover:decoration-blue-600">
                                   Detail
                                </a>

                                <?php
                                $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
                                if ((isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$book['created_by']) || $isAdmin): ?>
                                    <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" 
                                       class="text-emerald-600 font-bold transition-colors hover:text-emerald-800 underline decoration-emerald-200 decoration-2 underline-offset-4 hover:decoration-emerald-600">
                                       Upravit
                                    </a>
                                    
                                    <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" 
                                       onclick="return confirm('Opravdu chcete tuto knihu smazat?')" 
                                       class="text-rose-500 font-bold transition-colors hover:text-rose-700 underline decoration-rose-200 decoration-2 underline-offset-4 hover:decoration-rose-600">
                                       Smazat
                                    </a>
                                <?php endif; ?>
                                
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>