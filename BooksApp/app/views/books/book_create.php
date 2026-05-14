<?php require_once '../app/views/layout/header.php'; ?>
    <main class="max-w-[700px] mx-auto px-4 sm:px-6 py-8">
        
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
                <label for="isbn" class="font-semibold mb-1.5 text-[0.9rem]">ISBN <span class="text-red-500">*</span></label>
                <!-- Zde jsem upravil 'id' i 'name' na malá písmena 'isbn', jak jsme řešili minule -->
                <input type="text" id="isbn" name="isbn" required class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                
                <!-- ZMĚNA: Použití select místo input a iterace přes $categories -->
                <div class="flex flex-col">
                    <label for="category" class="font-semibold mb-1.5 text-[0.9rem]">Kategorie <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select id="category" name="category" required class="w-full appearance-none p-3 border border-slate-200 rounded-md font-sans text-base bg-white transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10 cursor-pointer">
                            <option value="" disabled selected></option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat['id']) ?>">
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <!-- Šipečka dolů pro vlastní vzhled selectu -->
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col">
                    <label for="subcategory" class="font-semibold mb-1.5 text-[0.9rem]">Podkategorie</label>
                    <div class="relative">
                        <select id="subcategory" name="subcategory" class="w-full appearance-none p-3 border border-slate-200 rounded-md font-sans text-base bg-white transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10 cursor-pointer text-slate-700">
                            <option value="" selected></option>
                            
                            <?php if (!empty($subcategories)): ?>
                                <?php foreach ($subcategories as $subcat): ?>
                                    <!-- Zde předpokládám, že ukládáš název (nebo ID). Záleží, jak máš nastavenou tabulku books -->
                                    <option value="<?= htmlspecialchars($subcat['id']) ?>">
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
                    <input type="number" id="year" name="year" required class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                </div>

                <div class="flex flex-col">
                    <label for="price" class="font-semibold mb-1.5 text-[0.9rem]">Cena (Kč)</label>
                    <input type="number" id="price" name="price" step="0.5" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                </div>
            </div>

            <div class="mb-5 flex flex-col">
                <label for="link" class="font-semibold mb-1.5 text-[0.9rem]">Odkaz (URL)</label>
                <input type="text" id="link" name="link" class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
            </div>

            <div class="mb-5 flex flex-col">
                <label for="description" class="font-semibold mb-1.5 text-[0.9rem]">Popis knihy</label>
                <textarea id="description" name="description" rows="6" class="p-3 w-full border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10"></textarea>
            </div>

            <hr class="my-8 border-slate-200">

            <div class="mb-5 flex flex-col">
                <h3 class="font-bold text-[1.1rem] text-slate-800 mb-4">Obrázky knihy</h3>
                
                <label for="images" class="group flex flex-col items-center justify-center text-center border-2 border-dashed border-slate-300 rounded-xl p-8 bg-white cursor-pointer transition-all hover:border-blue-500 hover:bg-blue-50">
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="sr-only">
                    
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3 mb-3 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                    </div>
                    
                    <span id="file-title" class="font-bold text-[1.05rem] mb-1 text-slate-800 transition-colors group-hover:text-blue-600">Klikněte pro nahrání obrázků</span>
                    <span id="file-info" class="text-[0.85rem] text-slate-500">JPG / PNG / WebP – můžete vybrat více souborů</span>
                </label>
            </div>

            <button type="submit" class="w-full mt-4 bg-blue-600 text-white py-3.5 px-6 rounded-md font-bold text-[1.05rem] cursor-pointer shadow-sm transition-all hover:bg-blue-700 hover:shadow-md hover:-translate-y-0.5">Uložit knihu do DB</button>
        </form>

    <script>
        const fileInput = document.getElementById('images');
        const fileTitle = document.getElementById('file-title');
        const fileInfo = document.getElementById('file-info');

        fileInput.addEventListener('change', function(event) {
            const files = event.target.files;
            
            if (files.length === 0) {
                fileTitle.textContent = 'Klikněte pro nahrání obrázků';
                fileTitle.classList.remove('text-blue-600');
                fileInfo.textContent = 'JPG / PNG / WebP – můžete vybrat více souborů';
            } else if (files.length === 1) {
                fileTitle.textContent = 'Soubor vybrán';
                fileTitle.classList.add('text-blue-600');
                fileInfo.textContent = files[0].name;
            } else {
                fileTitle.textContent = 'Soubory vybrány';
                fileTitle.classList.add('text-blue-600');
                fileInfo.textContent = 'Celkem vybráno: ' + files.length + ' souborů';
            }
        });
    </script>    
    </main>
<?php require_once '../app/views/layout/footer.php'; ?>