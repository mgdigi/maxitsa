
 <div class="grid grid-cols-5 gap-16 mb-8">
                    <div class="bg-orange-maxit rounded-3xl h-28 shadow-sm"></div>
                    <div class="bg-orange-maxit rounded-3xl h-28 shadow-sm"></div>
                    <div class="bg-orange-maxit rounded-3xl h-28 shadow-sm"></div>
                    <div class="bg-orange-maxit rounded-3xl h-28 shadow-sm"></div>
                </div>

                <?php foreach($comptes as $compte): ?>
                
                <div class="flex  justify-beetween gap-6 mb-8">
                    <div class="bg-[#F4F4F4] w-[50%] rounded-xl p-6 border-2 shadow-sm">
                        <div class="flex items-center justify-between gap-5">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center mr-4">
                                   <img src="./assets/icons/solde.svg" alt="solde icon"  class="h-15 w-15">                                
                                </div>
                                <div>
                                    <div class="text-3xl font-bold text-gray-800"><?=  $compte['solde']  ?> CFA</div>
                                    <div class="text-gray-600 font-medium">Solde de mon Compte principal</div>
                                </div>
                            </div>
                            <div class="w-32 h-32 bg-orange-maxit rounded-xl flex items-center justify-center border-2 border-orange-600">
                                <img src="./assets/images/qrcode.png" alt="">
                            </div>
                        </div>
                    </div>
                   <div class="self-center">
                    <input type="text" class="w-full rounded-xl p-4 border border-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-maxit" placeholder="Entrer le numéro de compte">
                   </div>
                   <div class="self-center"> 
                    <a href="/compteSecondaire">
                    <button  class="p-3 bg-[#F4F4F4] rounded-xl shadow-sm flex gap-2">
                        <img src="./assets/icons/addacount.svg" alt="add icon" class="w-7 h-7">
                    Creer un Compte  secondaire
                    </button>
                    </a>
                   </div>
                   <div class="self-center">
                    <button class="p-3 bg-[#F4F4F4] flex gap-2 rounded-xl shadow-sm">
                        <img src="./assets/icons/changer.svg" alt="add icon" class="w-7 h-7">
                        Changer de  compte
                    </button>
                   </div>
                    
                </div>

                <?php endforeach; ?>
                
                <div class="bg-white rounded-xl p-6 border border-orange-200 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-800">10 dernières transactions</h2>
                        <button class="text-gray-600 hover:text-orange-maxit transition-colors">Voir plus</button>
                    </div>
                    
                    <div class="grid grid-cols-5 gap-4">
                        <?php foreach($transactions as $transaction): ?>
                        <div class="bg-gray-100 rounded-xl p-4 text-center">
                            <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center mx-auto mb-3">
                                <img src="./images/design/transfert.png" alt="arrow-up" class="w-8 h-8">
                            </div>
                            <div class="font-medium text-sm text-gray-800 mb-1"><?= $transaction['typetransaction'] ?></div>
                            <div class="text-orange-maxit font-bold text-sm"><?= $transaction['montant'] ?> CFA</div>
                            <div class="text-xs text-gray-500 mt-1"><?= $transaction['datetransaction'] ?></div>
                        </div>
                        
                        
                        <?php endforeach; ?>
                    </div>
                    
                    
                </div>
            </main>
        </div>
    </div>

  