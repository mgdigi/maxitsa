<div class="container mx-auto mt-9 px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-green-600">✅ Paiement Réussi</h1>
            <p class="text-gray-600">Woyofal - Recharge SENELEC</p>
        </div>
        
        <?php if (isset($_SESSION['receipt'])): ?>
            <?php $receipt = $_SESSION['receipt']; ?>
            
            <div class="border-2 border-dashed border-gray-300 p-4 mb-6">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="font-medium">Client:</span>
                        <span><?= htmlspecialchars($receipt['client_nom']) ?></span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium">N° Compteur:</span>
                        <span class="font-mono"><?= htmlspecialchars($receipt['numero_compteur']) ?></span>
                    </div>
                    
                    <div class="flex justify-between border-t pt-2">
                        <span class="font-medium text-lg">Code de recharge:</span>
                    </div>
                    <div class="text-center">
                        <span class="font-mono text-xl font-bold bg-yellow-100 px-3 py-1 rounded">
                            <?= htmlspecialchars($receipt['code_recharge']) ?>
                        </span>
                    </div>
                    
                    <div class="flex justify-between border-t pt-2">
                        <span class="font-medium">Nombre KWH:</span>
                        <span class="font-bold"><?= number_format($receipt['nombre_kwh'], 2) ?> KWH</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium">Tranche:</span>
                        <span><?= htmlspecialchars($receipt['tranche']) ?></span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="font-medium">Prix unitaire:</span>
                        <span><?= number_format($receipt['prix_unitaire'], 0) ?> FCFA/KWH</span>
                    </div>
                    
                    <div class="flex justify-between border-t pt-2 font-bold">
                        <span>Montant payé:</span>
                        <span><?= number_format($receipt['montant_paye'], 0) ?> FCFA</span>
                    </div>
                    
                    <div class="flex justify-between text-xs text-gray-500 border-t pt-2">
                        <span>Date/Heure:</span>
                        <span><?= htmlspecialchars($receipt['date_heure']) ?></span>
                    </div>
                    
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Référence:</span>
                        <span class="font-mono"><?= htmlspecialchars($receipt['reference']) ?></span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-3">
                <button onclick="window.print()" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                    🖨️ Imprimer le reçu
                </button>
                
                <a href="<?= APP_URL ?>/woyofal" class="block w-full bg-orange-500 text-white py-2 px-4 rounded-md text-center hover:bg-orange-600">
                    Nouvel achat
                </a>
                
                <a href="<?= APP_URL ?>/compte" class="block w-full bg-gray-300 text-gray-700 py-2 px-4 rounded-md text-center hover:bg-gray-400">
                    Retour au compte
                </a>
            </div>
            
            <?php unset($_SESSION['receipt']); ?>
        <?php else: ?>
            <p class="text-center text-gray-500">Aucun reçu disponible.</p>
            <a href="<?= APP_URL ?>/woyofal" class="block w-full bg-orange-500 text-white py-2 px-4 rounded-md text-center hover:bg-orange-600 mt-4">
                Faire un achat
            </a>
        <?php endif; ?>
    </div>
</div>