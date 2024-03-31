<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class=" mx-auto  space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">
                    <section>
                        <header>
                            <label class="inline-flex items-center cursor-pointer">
                                <input id="toggleView" type="checkbox" value="" class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Table View</span>
                            </label>
                            <button id="exportButton" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 float-right">Export CSV</button>
                        </header>
                        
                    </section>
                </div>
            </div>
        </div>
      
        <div class="container my-12 mx-auto px-4 md:px-12" id="contacts-container">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="contacts-cards">
               
            </div>
            <div id="cards-pagination" class="mt-4 text-center">
              
            </div>
        </div>

        <div class="container my-12 mx-auto px-4 md:px-12 hidden" id="table-container">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Contact Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Image
                            </th>
                            <th scope="col" class="px-6 py-3">
                                DOB
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        
                    </tbody>
                </table>
            </div>
            <div id="table-pagination" class="mt-4 text-center">
                
            </div>
        </div>
    </div>
</x-app-layout>

<script>
      window.addEventListener('DOMContentLoaded', function () {
        loadCardData(1);
    });
    window.addEventListener('DOMContentLoaded', function () {
        const toggleView = document.getElementById('toggleView');
        const contactsContainer = document.getElementById('contacts-container');
        const tableContainer = document.getElementById('table-container');
        const cardsContainer = document.getElementById('contacts-cards');

        toggleView.addEventListener('change', function () {
            if (toggleView.checked) {
                contactsContainer.classList.add('hidden');
                tableContainer.classList.remove('hidden');
                loadTableData(1);
            } else {
                contactsContainer.classList.remove('hidden');
                tableContainer.classList.add('hidden');
                loadCardData(1);
            }
        });
    });

    function loadTableData(page) {
        fetch(`/api/getContacts?page=${page}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('table-body');
                const tablePagination = document.getElementById('table-pagination');
                tableBody.innerHTML = ''; 

                
                data.data.forEach(contact => {
                    tableBody.innerHTML += `
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                ${contact.firstname} ${contact.lastname}
                            </th>
                            <td class="px-6 py-4">
                                <img alt="Placeholder" class="block rounded-full" src="${contact.profile_pic}" height="32" width="32">
                            </td>
                            <td class="px-6 py-4">
                                ${contact.DOB}
                            </td>
                        </tr>
                    `;
                });

                
                tablePagination.innerHTML = ''; 
                for (let i = 1; i <= data.last_page; i++) {
                    tablePagination.innerHTML += `
                        <a href="#" onclick="loadTableData(${i})" class="px-3 py-1 mx-1 bg-white rounded hover:bg-gray-300">${i}</a>
                    `;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function loadCardData(page) {
        fetch(`/api/getContacts?page=${page}`)
            .then(response => response.json())
            .then(data => {
                const cardsContainer = document.getElementById('contacts-cards');
                const cardsPagination = document.getElementById('cards-pagination');
                cardsContainer.innerHTML = ''; 

          
                data.data.forEach(contact => {
                    cardsContainer.innerHTML += `
                        <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white">
                            <img class="w-full" src="${contact.profile_pic}" alt="Avatar">
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2">${contact.firstname} ${contact.lastname}</div>
                                <p class="text-gray-700 text-base">
                                    ${contact.DOB}
                                </p>
                            </div>
                        </div>
                    `;
                });

              
                cardsPagination.innerHTML = ''; 
                for (let i = 1; i <= data.last_page; i++) {
                    cardsPagination.innerHTML += `
                        <a href="#" onclick="loadCardData(${i})" class="px-3 py-1 mx-1 bg-white rounded hover:bg-gray-300">${i}</a>
                    `;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Function to call the API and download CSV
function exportData() {
    fetch('/api/exportData')
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(new Blob([blob]));
            const a = document.createElement('a');
            a.href = url;
            a.download = 'export-contact.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => console.error('Error:', error));
}


const exportButton = document.getElementById('exportButton');
exportButton.addEventListener('click', exportData);

</script>
