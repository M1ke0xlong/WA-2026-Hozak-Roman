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