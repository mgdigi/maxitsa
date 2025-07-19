
<body class="bg-orange-400 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-custom overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                <div class="lg:w-1/2 bg-gradient-to-br from-gray-800 to-gray-900 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-40"></div>
                    <div class="relative z-10 p-8 h-full flex flex-col justify-center">
                        <div class="text-white mb-8">
                            <h1 class="text-4xl lg:text-5xl font-bold mb-4">
                                Max tes offres<br>
                                <span class="text-orange-500">et services</span>
                            </h1>
                            <div class="flex items-center mb-6">
                                <div class="bg-orange-500 p-2 rounded mr-3">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <span class="text-2xl font-bold">Max it</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-center items-center flex-1">
                            <div class="relative">
                                <div class="w-48 h-80 bg-gradient-orange rounded-3xl shadow-2xl transform rotate-12 relative overflow-hidden">
                                    <div class="absolute top-4 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-black rounded-full opacity-20"></div>
                                    <div class="p-6 pt-8 text-white text-center">
                                        <div class="text-sm font-semibold mb-2">Max it</div>
                                        <div class="text-xs opacity-90">Tes offres et services</div>
                                    </div>
                                </div>
                                <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-orange-500 rounded-full opacity-20"></div>
                            </div>
                        </div>
                        
                        <div class="text-white text-sm mt-8">
                            <p class="mb-2">Test Orange au même temps</p>
                            <p>avec la nouvelle application</p>
                            <div class="flex items-center mt-4 space-x-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-white rounded mr-2"></div>
                                    <span class="text-xs">Disponible sur</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-white rounded mr-2"></div>
                                    <span class="text-xs">App Store</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:w-1/2 p-8">
                    <div class="max-w-md mx-auto">
                        <!-- <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                                BIENVENUE SUR <span class="text-orange-500">MAXIT SA</span>
                            </h2>
                            <p class="text-gray-600 text-lg">
                                créer un compte pour bénéficier<br>
                                de nos services
                            </p>
                        </div> -->
                        
                        <form class="space-y-6" action="principalCreated" method="post" enctype="multipart/form-data">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">prénom</label>
                                    <input type="text" name="prenom" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                    <?php if(!empty($_SESSION['errors']['prenom'])): ?>
                                        <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white "><?= $_SESSION['errors']['prenom']; ?> <p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">nom</label>
                                    <input type="text" name="nom" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                    <?php if(!empty($_SESSION['errors']['nom'])): ?>
                                        <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white "><?= $_SESSION['errors']['nom']; ?> <p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">login</label>
                                <input type="text" name="login" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                <?php if(!empty($_SESSION['errors']['login'])): ?>
                                        <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white "><?= $_SESSION['errors']['login']; ?> <p>
                                        </div>
                                    <?php endif; ?>
                            </div>

                             <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">password</label>
                                <input type="text" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                <?php if(!empty($_SESSION['errors']['password'])): ?>
                                        <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white "><?= $_SESSION['errors']['password']; ?> <p>
                                        </div>
                                    <?php endif; ?>
                            </div>

                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Numéro CNI</label>
                                <input type="text" name="numeroCNI" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                <?php if(!empty($_SESSION['errors']['numeroCNI'])): ?>
                                        <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white "><?= $_SESSION['errors']['numeroCNI']; ?> <p>
                                        </div>
                                    <?php endif; ?>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">photo identité recto</label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-500 transition-colors cursor-pointer">
                                        <input type="file"  accept="image/*" name="photoRecto">
                                        <p class="text-gray-500 text-sm">télécharger l'image</p>
                                        <?php if(!empty($_SESSION['errors']['photoRecto'])): ?>
                                        <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white "><?= $_SESSION['errors']['photoRecto']; ?> <p>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">photo identité verso</label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-500 transition-colors cursor-pointer">
                                        <input type="file" accept="image/*" name="photoVerso">
                                        <p class="text-gray-500 text-sm">télécharger l'image</p>
                                        <?php if(!empty($_SESSION['errors']['photoVerso'])): ?>
                                        <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white "><?= $_SESSION['errors']['photoVerso']; ?> <p>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                <input type="text" name="adresse" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                <?php if(!empty($_SESSION['errors']['adresse'])): ?>
                                        <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white "><?= $this->session->get('errors', 'adresse') ?> <p>
                                        </div>
                                    <?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Telephone</label>
                                <input type="text" name="telephone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                <?php if(!empty($_SESSION['errors']['telephone'])): ?>
                                        <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white "><?= $_SESSION['errors']['telephone']; ?> <p>
                                        </div>
                                    <?php endif; ?>
                            </div>


                            
                            <!-- <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-700">solde initial :</label>
                                <div class="flex-1 max-w-32">
                                    <input type="text" name="solde" value="0 FCFA" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-center font-medium">
                                </div>
                            </div> -->
                            
                            <button type="submit" class="w-full bg-gradient-orange text-white font-bold py-4 px-6 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                Enregistrer
                            </button>
                        </form>
                        <a href="/" class="mt-3 text-orange-500 hover:text-orange-600 transition-colors">
                            <p class="">j'ai deja un compte</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
