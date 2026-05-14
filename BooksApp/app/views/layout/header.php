<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Knihovna - Seznam knih</title>
    <style>
        /* Animace pro notifikace */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="font-sans bg-slate-50 text-slate-800 leading-relaxed pb-8">
    
    <header class="bg-white border-b border-slate-200 py-4 px-6 sm:px-[5%] flex flex-col sm:flex-row justify-between items-center shadow-sm mb-8 gap-4 sm:gap-0 relative z-10">
        
        <h1 class="text-2xl text-blue-600 font-extrabold tracking-tight">
            <a href="<?= BASE_URL ?>/index.php" class="transition-colors duration-300 hover:text-blue-800">
                Aplikace Knihovna
            </a>
        </h1>

        <nav>
            <ul class="list-none flex flex-col sm:flex-row items-center gap-4 sm:gap-6 text-center">
                
                <li>
                    <a href="<?= BASE_URL ?>/index.php" class="text-slate-600 font-medium transition-colors duration-200 hover:text-blue-600">
                        Seznam knih
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=book/create" class="inline-flex items-center gap-1.5 bg-blue-600 text-white px-4 py-2 rounded-lg font-bold shadow-sm transition-all hover:bg-blue-700 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                            Přidat knihu
                        </a>
                    </li>
                    
                    <li class="flex items-center gap-2 border-l border-slate-200 pl-4 sm:pl-6">
                        <span class="text-slate-400 text-sm italic">Ahoj,</span>
                        <div class="flex items-center gap-2">
                            <span class="text-slate-800 font-bold text-sm tracking-wide"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                            
                            <?php if (($_SESSION['is_admin'] ?? '') == 1): ?>
                                <span class="bg-red-600 text-white text-[10px] uppercase tracking-widest font-black px-2 py-0.5 rounded shadow-sm">
                                    Admin
                                </span>
                            <?php endif; ?>
                        </div>
                    </li>
                    
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=auth/logout" class="text-rose-500 hover:text-rose-700 transition-colors text-xs uppercase tracking-widest font-bold">
                            Odhlásit
                        </a>
                    </li>

                <?php else: ?>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-slate-600 font-medium transition-colors hover:text-blue-600">
                            Přihlásit
                        </a>
                    </li>
                    <li class="mt-2 sm:mt-0">
                        <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="inline-flex justify-center items-center px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-sm transition-all duration-200 hover:bg-blue-700 hover:shadow hover:-translate-y-0.5 active:translate-y-0">
                            Registrace
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
    </header>
