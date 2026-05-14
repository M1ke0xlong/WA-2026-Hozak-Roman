<?php require_once '../app/views/layout/header.php'; ?>

<body class="font-sans bg-slate-50 text-slate-800 leading-relaxed py-8">
    <div class="max-w-[700px] mx-auto px-4 sm:px-6">
        
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
            <?php unset($_SESSION['flash_messages']); // Po vypsání zprávy smažeme ze session ?>
        <?php endif; ?>

        <div class="mb-8">
            <h2 class="text-[1.8rem] font-bold mb-2 text-slate-800">Nová registrace</h2>
            <p class="text-slate-500 text-[0.95rem]">Vytvořte si účet pro přístup do správy katalogu.</p>
        </div>
        
        <div class="bg-white p-6 sm:p-8 rounded-xl shadow-sm border border-slate-200">
            <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <div class="sm:col-span-2">
                        <h3 class="text-blue-600 text-sm font-bold uppercase tracking-wider border-b border-slate-100 pb-2 mb-2">Přihlašovací údaje</h3>
                    </div>

                    <div class="flex flex-col">
                        <label for="username" class="font-semibold mb-1.5 text-[0.9rem]">Uživatelské jméno <span class="text-red-500">*</span></label>
                        <input type="text" id="username" name="username" required 
                               class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                    </div>

                    <div class="flex flex-col">
                        <label for="email" class="font-semibold mb-1.5 text-[0.9rem]">E-mail <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" required 
                               class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                    </div>

                    <div class="flex flex-col">
                        <label for="password" class="font-semibold mb-1.5 text-[0.9rem]">Heslo <span class="text-red-500">*</span></label>
                        <input type="password" id="password" name="password" required 
                               class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                    </div>

                    <div class="flex flex-col">
                        <label for="password_confirm" class="font-semibold mb-1.5 text-[0.9rem]">Potvrzení hesla <span class="text-red-500">*</span></label>
                        <input type="password" id="password_confirm" name="password_confirm" required 
                               class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                    </div>

                    <div class="sm:col-span-2 mt-4">
                        <h3 class="text-slate-400 text-sm font-bold uppercase tracking-wider border-b border-slate-100 pb-2 mb-2">Osobní údaje <span class="text-[0.7rem] font-normal lowercase">(volitelné)</span></h3>
                    </div>

                    <div class="flex flex-col">
                        <label for="first_name" class="font-semibold mb-1.5 text-[0.9rem]">Křestní jméno</label>
                        <input type="text" id="first_name" name="first_name" 
                               class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                    </div>

                    <div class="flex flex-col">
                        <label for="last_name" class="font-semibold mb-1.5 text-[0.9rem]">Příjmení</label>
                        <input type="text" id="last_name" name="last_name" 
                               class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                    </div>

                    <div class="sm:col-span-2 flex flex-col">
                        <label for="nickname" class="font-semibold mb-1.5 text-[0.9rem]">Zobrazovaná přezdívka</label>
                        <input type="text" id="nickname" name="nickname" placeholder="Jak vám máme v aplikaci říkat?"
                               class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10 placeholder-slate-300">
                    </div>

                    <div class="sm:col-span-2 mt-6">
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-3.5 px-6 rounded-md font-bold text-[1.05rem] cursor-pointer shadow-sm transition-all hover:bg-blue-700 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0">
                            Vytvořit účet
                        </button>
                        
                        <p class="text-center text-slate-500 text-[0.9rem] mt-6">
                            Už máte účet? 
                            <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-blue-600 font-semibold hover:underline">Přihlaste se zde</a>.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php require_once '../app/views/layout/footer.php'; ?>
</body>