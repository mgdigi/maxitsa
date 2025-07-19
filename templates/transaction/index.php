
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900">liste des transaction</h1>
                <div class="flex gap-4">
                    <div class="relative">
                        <input type="text" placeholder="rechercher par date" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div class="relative">
                        <input type="text" placeholder="rechercher par numero" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Numero Compte
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <span class="border-2 border-purple-500 px-2 py-1 rounded">type</span>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Solde
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date Creation
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">CN398545587</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-medium text-orange-600 bg-orange-100 rounded-full border border-orange-200">
                                principal
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">12300</td>
                        <td class="px-6 py-4 text-sm text-gray-900">12/12/2025</td>
                        <td class="px-6 py-4">
                            <div class="relative dropdown-toggle">
                                <button class="text-orange-500 hover:text-orange-700 text-xl font-bold">
                                    ⋯
                                </button>
                                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden z-10">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Modifier</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Supprimer</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Détails</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">CN398284984</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-medium text-orange-600 bg-orange-100 rounded-full border border-orange-200">
                                secondair
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">12300</td>
                        <td class="px-6 py-4 text-sm text-gray-900">12/12/2025</td>
                        <td class="px-6 py-4">
                            <div class="relative dropdown-toggle">
                                <button class="text-orange-500 hover:text-orange-700 text-xl font-bold">
                                    ⋯
                                </button>
                                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden z-10">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Modifier</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Supprimer</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Détails</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">CN98479849</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-medium text-orange-600 bg-orange-100 rounded-full border border-orange-200">
                                secondair
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">12300</td>
                        <td class="px-6 py-4 text-sm text-gray-900">12/12/2025</td>
                        <td class="px-6 py-4">
                            <div class="relative dropdown-toggle">
                                <button class="text-orange-500 hover:text-orange-700 text-xl font-bold">
                                    ⋯
                                </button>
                                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden z-10">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Modifier</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Supprimer</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Détails</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Row 4 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">Cn48954898</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-medium text-orange-600 bg-orange-100 rounded-full border border-orange-200">
                                secondair
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">12300</td>
                        <td class="px-6 py-4 text-sm text-gray-900">12/12/2025</td>
                        <td class="px-6 py-4">
                            <div class="relative dropdown-toggle">
                                <button class="text-orange-500 hover:text-orange-700 text-xl font-bold">
                                    ⋯
                                </button>
                                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden z-10">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Modifier</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Supprimer</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Détails</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Row 5 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">CN985849588</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-medium text-orange-600 bg-orange-100 rounded-full border border-orange-200">
                                secondair
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">12300</td>
                        <td class="px-6 py-4 text-sm text-gray-900">12/12/2025</td>
                        <td class="px-6 py-4">
                            <div class="relative dropdown-toggle">
                                <button class="text-orange-500 hover:text-orange-700 text-xl font-bold">
                                    ⋯
                                </button>
                                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden z-10">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Modifier</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Supprimer</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Détails</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 border border-gray-300 rounded text-gray-500 hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">1</button>
                    <span class="px-2 text-gray-500">/</span>
                    <span class="px-2 text-gray-500">4</span>
                    <button class="px-3 py-1 border border-gray-300 rounded text-gray-500 hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-700">ligne par page</span>
                    <select class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>5</option>
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
