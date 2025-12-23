<!doctype html>
<html>

<head>
    <title>Search User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-[#006DAE] flex items-center justify-center h-screen">

    <!-- Modal Wrapper -->
    <div id="image-modal" class="hidden fixed inset-0 flex items-center justify-center z-50 bg-black/30">
        <div id="modal-box" class="bg-white px-3 pt-3 rounded-lg shadow-lg cursor-move relative mx-auto text-center pb-6">
            <!-- Tombol Close -->
            <button id="close-modal" class="absolute top-2 right-2 text-red-500 font-bold">X</button>
            <!-- Image -->
            <img id="profile-full-image" src="" class="max-w-[90vw] max-h-[80vh] rounded-lg">

            <!-- Tombol Download -->
            <div class="my-4">
                <a style="margin: 20px" id="download-link" download  href="#"
                    class="text-white bg-[#006DAE] hover:bg-[#006DAE] font-medium rounded-lg text-sm px-4 py-2">
                    Download Image
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        <img src="{{ asset('/images/logo.png') }}"class="h-20 text-center mx-auto mb-20" />
        <form class="mx-auto max-w-md" id="searchForm">
            @csrf
            <label for="default-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search User" required />
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-[#006DAE] hover:bg-[#006DAE] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Search</button>
            </div>
        </form>

        <div id="default-modal"
            class="hidden z-[99] fixed inset-0 items-center justify-center w-full h-full bg-black/20">

            <div id="chat-modal" class="relative w-full max-w-2xl md:h-auto p-4 cursor-move">
                <div class="relative bg-white text-black rounded-lg shadow-lg h-[400px] flex flex-col">
                    <div
                        class="drag-handle flex items-center justify-between p-4 border-b border-gray-200 sticky top-0 bg-white z-10">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Chat Results: <span id="value-search"></span>
                        </h3>
                        <button id="close-btn">❌</button>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="wrapper-chating"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const searchForm = document.getElementById('searchForm');
        const wrapperChat = document.getElementById('wrapper-chating');
        const defaultModal = document.getElementById('default-modal');
        const valueSearch = document.getElementById('value-search');
        const closeBtn = document.getElementById('close-btn');

        const imageModal = document.getElementById('image-modal');
        const modalBox = document.getElementById('modal-box');
        const closeModal = document.getElementById('close-modal');
        const profileImg = document.getElementById('profile-full-image');

        closeBtn.addEventListener('click', () => {
            defaultModal.classList.add('hidden');
        });

        closeModal.addEventListener('click', () => {
            imageModal.classList.add('hidden');
            profileImg.src = '';
        });

        closeBtn.addEventListener('click', () => {
            defaultModal.classList.add('hidden');
            defaultModal.classList.remove('flex');
        });

        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const searchInput = document.getElementById('default-search').value.trim();

            if (!searchInput) {
                defaultModal.classList.add('hidden');
                return;
            }

            fetch(`/search`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        search: searchInput
                    })
                })
                .then(response => response.json())
                .then(result => {
                    wrapperChat.innerHTML = '';

                    if (!result || result.length === 0) {
                        defaultModal.classList.add('hidden');
                        return;
                    }

                    defaultModal.classList.remove('hidden');
                    defaultModal.classList.add('flex');

                    const data = result.map(item => ({
                        id: item.id,
                        name: item.name,
                        email: item.email ?? '-',
                        message: item.message ?? ''
                    }));

                    data.forEach((msg, i) => {
                        setTimeout(() => {
                            const row = document.createElement('button');
                            row.setAttribute('onclick', `showProfileImage(${msg.id})`);
                            row.className = "cursor-pointer w-full";

                            row.innerHTML = `
                                <div class="block">
                                    <div class="flex items-start gap-2.5 bg-gray-100 hover:bg-blue-200 rounded-lg p-3 shadow-sm">
                                        <img class="w-8 h-8 rounded-full" 
                                            src="https://ui-avatars.com/api/?name=${encodeURIComponent(msg.name)}&background=random" 
                                            alt="${msg.name}">
                                        <div class="flex flex-col gap-1 w-full">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-semibold text-gray-900 capitalize">${msg.name}</span>
                                                <span class="text-xs text-gray-500 capitalize">${msg.email}</span>
                                            </div>
                                            <div class="text-sm text-gray-700 mt-3 capitalize whitespace-normal break-words max-w-[450px]">${msg.message}</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            wrapperChat.appendChild(row);
                        }, i * 200);
                    });

                    valueSearch.textContent = searchInput;
                })
                .catch(error => {
                    console.error('Error:', error);
                    defaultModal.classList.add('hidden');
                });
        });

        window.showProfileImage = (id) => {
            const defaultModal = document.getElementById('default-modal');

            defaultModal.classList.add('hidden');
            fetch(`/user/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const baseUrl = window.location.origin;
                    const modal = document.getElementById('image-modal');
                    const img = document.getElementById('profile-full-image');
                    const downloadLink = document.getElementById('download-link');
                    downloadLink.href = `${baseUrl}/storage/${data.merged_image}`;

                    img.src = `${baseUrl}/storage/${data.merged_image}`;
                    modal.classList.remove('hidden');
                    document.getElementById('image-modal').classList.remove('hidden');
                    document.getElementById('modal-box').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };
    </script>
</body>

</html>
