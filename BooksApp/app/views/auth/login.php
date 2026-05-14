<?php require_once '../app/views/layout/header.php'; ?>

<body class="font-sans bg-slate-50 text-slate-800 leading-relaxed py-8">
    <div class="max-w-[450px] mx-auto px-4">
        
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

        <div class="mb-8 text-center">
            <h2 class="text-[1.8rem] font-bold mb-2 text-slate-800">Přihlášení</h2>
            <p class="text-slate-500 text-[0.95rem]">Vítejte zpět v naší Knihovně.</p>
        </div>
        
        <div class="bg-white p-6 sm:p-10 rounded-xl shadow-sm border border-slate-200">
            <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post">
                
                <div class="space-y-5">
                    <div class="flex flex-col">
                        <label for="email" class="font-semibold mb-1.5 text-[0.9rem]">E-mail</label>
                        <input type="email" id="email" name="email" required autofocus
                               class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10 placeholder-slate-300">
                    </div>

                    <div class="flex flex-col">
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="password" class="font-semibold text-[0.9rem]">Heslo</label>
                            <a href="#" class="text-xs text-blue-600 hover:underline">Zapomenuté heslo?</a>
                        </div>
                        <input type="password" id="password" name="password" required 
                               class="p-3 border border-slate-200 rounded-md font-sans text-base transition-colors focus:outline-none focus:border-blue-600 focus:ring-[3px] focus:ring-blue-600/10">
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-3.5 px-6 rounded-md font-bold text-[1.05rem] cursor-pointer shadow-sm transition-all hover:bg-blue-700 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0">
                            Přihlásit se
                        </button>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100 text-center">
                        <p class="text-slate-500 text-[0.9rem]">
                            Nemáte ještě účet? 
                            <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-blue-600 font-semibold hover:underline">Zaregistrujte se</a>.
                        </p>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center">
             <a href="<?= BASE_URL ?>/index.php" class="text-slate-400 hover:text-slate-600 transition-colors text-sm font-medium">
                &larr; Zpět na domovskou stránku
             </a>
        </div>
    </div>

    <?php require_once '../app/views/layout/footer.php'; ?>
</body>