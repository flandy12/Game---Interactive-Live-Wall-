<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Monash University</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/logo.png') }}">
    <script src="https://cdn.tiny.cloud/1/kzj5cg1ned34o821ht6p81wlszqmnvx6domizaiswl0xup70/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    @vite('resources/css/app-second.css')
</head>

<body class="w-full">
    <nav class="bg-[#006dae] w-full z-20 top-0 start-0 border-b border-default">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

            <!-- LOGO -->
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('/images/logo.png') }}" class="h-12" alt="Logo" />
            </a>

            <!-- MOBILE TOGGLE -->
            <button data-collapse-toggle="navbar-menu" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                aria-controls="navbar-menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                </svg>
            </button>

            <!-- MENU -->
            <div class="hidden w-full md:block md:w-auto" id="navbar-menu">
                <ul
                    class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-200 rounded-lg bg-[#005c96] md:space-x-8 
                    rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">

                    <li>
                        <a href="#" class="block py-2 px-3 text-white md:text-white md:p-0 hover:text-gray-200"
                            aria-current="page">Dashboard</a>
                    </li>

                    <li>
                        <a href="/"
                            class="block py-2 px-3 text-gray-200 md:text-white hover:text-white md:p-0">Home</a>
                    </li>

                </ul>
            </div>

        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4">
        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base p-4">
            <!-- TOP BAR -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">

                <!-- SEARCH -->
                <div id="searchForm" class="w-full md:w-[320px] lg:w-[380px] xl:w-[420px]">
                    <label for="tableSearch" class="sr-only">Search Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="tableSearch" name="search"
                            class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 
                            focus:ring-[#006DAE] focus:border-[#006DAE]"
                            placeholder="Search Name ..." />
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4 w-full md:w-auto">

                    <!-- DOWNLOAD -->
                    <a href="{{ route('download') }}"
                        class="inline-flex items-center justify-center h-12 gap-2 px-4 py-2 bg-[#006DAE] hover:bg-[#006eaec5] 
                        text-white font-medium rounded-lg shadow-sm transition w-full sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                        Download Excel
                    </a>

                    <!-- DELETE -->
                    <form action="{{ route('deleteAll') }}" method="POST" onsubmit="return confirmDeleteAll()"
                        class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 h-12 bg-red-600 hover:bg-red-700 
                            text-white font-medium rounded-lg shadow-sm transition cursor-pointer w-full sm:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m5-4v4" />
                            </svg>
                            Delete All
                        </button>
                    </form>

                </div>

            </div>


            <!-- TABLE WRAPPER -->
            <div class="overflow-x-auto border border-gray-400 rounded-base">
                <table class="w-full text-sm text-left rtl:text-right text-body">
                    <thead class="bg-neutral-secondary-soft border-b border-gray-400">
                        <tr>
                            <th class="px-6 py-3 font-medium">No</th>
                            <th class="px-6 py-3 font-medium">Name</th>
                            <th class="px-6 py-3 font-medium text-center">Message</th>
                            <th class="px-6 py-3 font-medium text-center">Image</th>
                            <th class="px-6 py-3 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataMaster as $key => $value)
                            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b">
                                <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $value->name }}</td>
                                <td class="px-6 py-4 text-center">{!! $value->message !!}</td>
                                <td class="px-6 py-4 h-36">
                                    <img src="{{ asset('storage/' . $value->merged_image) }}" class="w-full" />
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="button"
                                        onclick="openModal({{ $value->id }}, '{{ $value->name }}', `{{ $value->message }}`)"
                                        class="font-medium text-blue-600 hover:underline">Edit</button>

                                    <form action="{{ route('cms.message.delete', $value->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="font-medium text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="hidden fixed inset-0 bg-black/15 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Edit Message</h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" id="editName" name="name" class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Message</label>
                    <textarea id="editMessage" name="message" class="w-full p-2 border rounded"></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // INIT TINYMCE (DIPANGGIL SETIAP BUKA MODAL)
        function initTinyMCE(value = "") {

            // Hapus instance lama kalau ada
            if (tinymce.get("editMessage")) {
                tinymce.get("editMessage").remove();
            }

            tinymce.init({
                selector: '#editMessage',
                plugins: 'emoticons',
                toolbar: 'undo redo | bold italic | emoticons',
                menubar: false,
                height: 200,

                setup: function(editor) {

                    editor.on('init', function() {
                        editor.setContent(value); // Masukkan value lama
                    });

                    // Limit 170 karakter
                    editor.on('keydown', function(e) {
                        const text = editor.getContent({
                            format: 'text'
                        });
                        const allowed = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'ArrowUp',
                            'ArrowDown'
                        ];

                        if (allowed.includes(e.key)) return;

                        if (text.length >= 170 && e.key.length === 1) {
                            e.preventDefault();
                            alert('Maksimal 170 karakter!');
                        }
                    });

                    editor.on('input', function() {
                        const text = editor.getContent({
                            format: 'text'
                        });
                        if (text.length > 170) {
                            editor.setContent(text.substring(0, 170));
                            alert('Maksimal 170 karakter!');
                        }
                    });
                }
            });
        }

        // OPEN MODAL
        function openModal(id, name, message) {
            document.getElementById('editName').value = name;

            // Set action form
            document.getElementById('editForm').action = "/cms/message/" + id;

            // Tampilkan modal
            document.getElementById('editModal').classList.remove('hidden');

            // Init TinyMCE setelah modal muncul
            setTimeout(() => {
                initTinyMCE(message);
            }, 100);
        }

        // CLOSE MODAL
        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');

            // Hapus TinyMCE instance
            if (tinymce.get("editMessage")) {
                tinymce.get("editMessage").remove();
            }
        }


        document.getElementById('editForm').addEventListener('submit', function(e) {
            const content = tinymce.get('editMessage').getContent({
                format: 'text'
            }).trim();

            if (content.length === 0) {
                e.preventDefault();
                alert('Message wajib diisi!');
                tinymce.get('editMessage').focus();
            }
        });

        const searchInput = document.getElementById('tableSearch');

        searchInput.addEventListener('keyup', function() {
            const keyword = this.value.toLowerCase();
            const rows = document.querySelectorAll("tbody tr");

            rows.forEach(row => {
                const name = row.querySelector("td:nth-child(2)").innerText.toLowerCase();
                const message = row.querySelector("td:nth-child(3)").innerText.toLowerCase();

                if (name.includes(keyword) || message.includes(keyword)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        const toggleBtn = document.querySelector("[data-collapse-toggle='navbar-menu']");
        const menu = document.getElementById("navbar-menu");

        toggleBtn.addEventListener("click", function() {
            menu.classList.toggle("hidden");
        });
    </script>

</body>

</html>
