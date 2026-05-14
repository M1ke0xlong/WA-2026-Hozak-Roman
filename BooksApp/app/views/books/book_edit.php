<?php require_once '../app/views/layout/header.php'; ?>

<body class="font-sans bg-slate-50 text-slate-800 leading-relaxed py-8">
    <div class="max-w-[700px] mx-auto px-4 sm:px-6">
        
        <!-- Notifikace -->
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

        <!-- Hlavička formuláře -->
        <div class="mb-8">
            <h2 class="text-[1.8rem] font-bold mb-2">Upravit knihu (ID: <?= htmlspecialchars($book['id']) ?>)</h2>
            <p class="text-slate-500 text-[0.95rem]">Upravujete data pro knihu: <strong class="text-slate-800 font-bold"><?= htmlspecialchars($book['title']) ?></strong></p>
        </div>
        
        <!-- Formulář -->
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
                <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" required class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <!-- ZMĚNA: Použití selectu s logikou isSelected -->
                <div class="flex flex-col">
                    <label for="category" class="font-semibold mb-1.5 text-[0.9rem]">Kategorie <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select id="category" name="category" required class="w-full appearance-none p-3 border border-slate-200 rounded-md font-sans text-base bg-white transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10 cursor-pointer">
                            <option value=""></option>
                            
                            <?php foreach ($categories as $cat): ?>
                                <?php 
                                // Kontrola, zda ID aktuálně vykreslované kategorie odpovídá ID uloženému u knihy
                                $isSelected = ($book['category'] == $cat['id']) ? 'selected' : ''; 
                                ?>
                                <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $isSelected ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col">
                    <label for="subcategory" class="font-semibold mb-1.5 text-[0.9rem]">Podkategorie</label>
                    <div class="relative">
                        <select id="subcategory" name="subcategory" class="w-full appearance-none p-3 border border-slate-200 rounded-md font-sans text-base bg-white transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10 cursor-pointer text-slate-700">
                            <!-- Možnost pro vymazání podkategorie -->
                            <option value="" <?= empty($book['subcategory']) ? 'selected' : '' ?>></option>
                            
                            <?php if (!empty($subcategories)): ?>
                                <?php foreach ($subcategories as $subcat): ?>
                                    <?php 
                                    // Porovnáme ID uložené u knihy s ID právě vypisované podkategorie
                                    $isSelected = ($book['subcategory'] == $subcat['id']) ? 'selected' : ''; 
                                    ?>
                                    <option value="<?= htmlspecialchars($subcat['id']) ?>" <?= $isSelected ?>>
                                        <?= htmlspecialchars($subcat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                        </select>
                        <!-- Šipečka -->
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div class="flex flex-col">
                    <label for="year" class="font-semibold mb-1.5 text-[0.9rem]">Rok vydání <span class="text-red-500">*</span></label>
                    <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>" required class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                </div>

                <div class="flex flex-col">
                    <label for="price" class="font-semibold mb-1.5 text-[0.9rem]">Cena knihy (Kč)</label>
                    <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($book['price']) ?>" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                </div>
            </div>

            <div class="mb-5 flex flex-col">
                <label for="link" class="font-semibold mb-1.5 text-[0.9rem]">Odkaz (URL)</label>
                <input type="text" id="link" name="link" value="<?= htmlspecialchars($book['link']) ?>" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="description" class="font-semibold mb-1.5 text-[0.9rem]">Popis knihy</label>
                <textarea id="description" name="description" rows="5" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10"><?= htmlspecialchars($book['description']) ?></textarea>
            </div>    

            <hr class="my-8 border-slate-200">

            <!-- SEKCE OBRÁZKY -->
            <div class="mb-5">
                <h3 class="font-bold text-[1.1rem] text-slate-800 mb-4">Správa obrázků</h3>
                
                <?php 
                $currentImages = [];
                $dbImages = $book['images'] ?? $book['image'] ?? null;
                if (!empty($dbImages)) {
                    $currentImages = is_string($dbImages) ? json_decode($dbImages, true) : $dbImages;
                }
                ?>
                
                <?php if (!empty($currentImages)): ?>
                    <div class="mb-6 bg-slate-50 p-5 rounded-xl border border-slate-200">
                        <span class="block text-sm font-semibold text-slate-700 mb-3">Aktuálně nahrané obrázky:</span>
                        <div class="flex flex-wrap gap-4">
                            <?php foreach ($currentImages as $img): ?>
                                <div class="relative group">
                                    <img src="<?= BASE_URL ?>/public/<?= htmlspecialchars($img) ?>" 
                                         alt="Obrázek knihy" 
                                         class="h-32 w-24 object-cover rounded-md shadow-sm border border-slate-300 transition-transform group-hover:scale-105">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mb-6 bg-slate-50 p-4 rounded-lg border border-slate-200 text-center">
                        <p class="text-sm text-slate-500 italic">Ke knize zatím nejsou nahrány žádné obrázky.</p>
                    </div>
                <?php endif; ?>

                <div class="flex flex-col">
                    <label for="images" class="group flex flex-col items-center justify-center text-center border-2 border-dashed border-slate-300 rounded-xl p-8 bg-white cursor-pointer transition-all hover:border-blue-500 hover:bg-blue-50">
                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="sr-only">
                        <div class="bg-blue-100 text-blue-600 rounded-full p-3 mb-3 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                        </div>
                        <span id="file-title" class="font-bold text-[1.05rem] mb-1 text-slate-800 transition-colors group-hover:text-blue-600">Klikněte pro nahrání nových obrázků</span>
                        <span id="file-info" class="text-[0.85rem] text-slate-500">Tímto nahradíte stávající obrázky</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full mt-4 bg-blue-600 text-white py-3.5 px-6 rounded-md font-bold text-[1.05rem] cursor-pointer shadow-sm transition-all hover:bg-blue-700 hover:shadow-md hover:-translate-y-0.5">Uložit změny</button>
        </form>
    </div>

    <script>
        const fileInput = document.getElementById('images');
        const fileTitle = document.getElementById('file-title');
        const fileInfo = document.getElementById('file-info');

        fileInput.addEventListener('change', function(event) {
            const files = event.target.files;
            if (files.length === 0) {
                fileTitle.textContent = 'Klikněte pro nahrání nových obrázků';
                fileTitle.classList.remove('text-blue-600');
                fileInfo.textContent = 'Tímto nahradíte stávající obrázky';
            } else if (files.length === 1) {
                fileTitle.textContent = 'Nový soubor vybrán';
                fileTitle.classList.add('text-blue-600');
                fileInfo.textContent = files[0].name;
            } else {
                fileTitle.textContent = 'Nové soubory vybrány';
                fileTitle.classList.add('text-blue-600');
                fileInfo.textContent = 'Celkem: ' + files.length + ' souborů';
            }
        });
    </script>
    
<?php require_once '../app/views/layout/footer.php'; ?>