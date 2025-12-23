@extends('layouts.app')

@section('content')
    <div id="stage" class="relative w-screen h-screen bg-master overflow-hidden"></div>
@endsection

@push('styles')
    <style>
        @keyframes bubbleIn {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .bg-master {
            background: url('/images/bg.png') center / cover no-repeat;
        }
    </style>
@endpush

@push('scripts')
    <script>
        /* =====================================================
                                           ELEMENT ROOT
                                        ===================================================== */
        const stage = document.getElementById('stage');

        /* =====================================================
           STATE GLOBAL (ANTI DUPLIKASI ARAH)
        ===================================================== */
        const lastCharacterByDirection = {
            1: null,
            "-1": null
        };

        /* =====================================================
           CONFIG KARAKTER
        ===================================================== */
        const CHARACTERS = [{
                name: 'charA',
                frames: [
                    '/images/CHAR-01/image-01.png',
                    '/images/CHAR-01/image-02.png',
                    '/images/CHAR-01/image-03.png',
                    '/images/CHAR-01/image-04.png'
                ],
                width: 200,
                speed: 0.8
            },
            {
                name: 'charB',
                frames: [
                    '/images/CHAR-02/image-01.png',
                    '/images/CHAR-02/image-02.png',
                    '/images/CHAR-02/image-03.png',
                    '/images/CHAR-02/image-04.png'
                ],
                width: 200,
                speed: 1.1
            },
            {
                name: 'charC',
                frames: [
                    '/images/CHAR-03/image-01.png',
                    '/images/CHAR-03/image-02.png',
                    '/images/CHAR-03/image-03.png',
                    '/images/CHAR-03/image-04.png'
                ],
                width: 200,
                speed: 1.0
            },
            {
                name: 'charD',
                frames: [
                    '/images/CHAR-04/image-01.png',
                    '/images/CHAR-04/image-02.png',
                    '/images/CHAR-04/image-03.png',
                    '/images/CHAR-04/image-04.png'
                ],
                width: 200,
                speed: 1.1
            }
        ];

        /* =====================================================
           CONFIG UMUM
        ===================================================== */
        let messages = [];
        let msgIndex = 0;
        let isLoadingMessages = false;

        const FRAME_SPEED = 400;
        const SPAWN_INTERVAL = 2800;
        const CHARACTER_GAP = 60;

        /* =====================================================
           STATE RUNTIME
        ===================================================== */
        const activeCharacters = [];

        /* =====================================================
           RANDOM CHARACTER (ANTI DUPLIKASI ARAH)
        ===================================================== */
        function getRandomCharacterByDirection(direction) {
            let candidate;
            let safety = 0;

            do {
                candidate = CHARACTERS[Math.floor(Math.random() * CHARACTERS.length)];
                safety++;
            } while (
                CHARACTERS.length > 1 &&
                candidate.name === lastCharacterByDirection[direction] &&
                safety < 10
            );

            lastCharacterByDirection[direction] = candidate.name;
            return candidate;
        }

        /* =====================================================
           LOAD MESSAGE DARI SERVER
        ===================================================== */
        async function loadMessages() {
            if (isLoadingMessages) return;
            isLoadingMessages = true;

            try {
                const res = await fetch('/messages', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!res.ok) throw new Error('Fetch message gagal');

                const data = await res.json();
                messages = data.map(item => item);
                console.log(messages);
                msgIndex = 0;
            } catch (err) {
                console.error(err);
            } finally {
                isLoadingMessages = false;
            }
        }

        /* =====================================================
           AMBIL PESAN BERIKUTNYA
        ===================================================== */
        function getNextMessage() {
            if (messages.length === 0) return null;

            const msg = messages[msgIndex].message;
            const name = messages[msgIndex].name; // Accessing the message property
             // Accessing the message property
            console.log(messages);
            msgIndex++;

            if (msgIndex >= messages.length) {
                loadMessages(); // refresh batch
            }

            return `${name} - ${msg}`;
        }

        /* =====================================================
           SPAWN CHARACTERself
        ===================================================== */
        function spawnCharacter(message) {
            if (!message) return;

            const direction = Math.random() > 0.5 ? 1 : -1;
            const character = getRandomCharacterByDirection(direction);
            const startX = direction === 1 ? -300 : window.innerWidth + 300;

            const wrapper = document.createElement('div');
            wrapper.className = 'absolute bottom-0 pointer-events-none';
            // ✅ PERBAIKAN DI SINI
            wrapper.style.bottom = direction === -1 ? '200px' : '0px';
            wrapper.style.zIndex = direction === -1 ? '5' : '10';

            let x = startX;
            wrapper.style.transform = `translateX(${x}px)`;

            /* Bubble */
            const bubble = document.createElement('div');
            bubble.className = `
        relative mb-4 px-6 py-3 w-[240px]
        bg-white/95 backdrop-blur
        text-slate-900 text-md font-semibold text-center
        rounded-2xl shadow-2xl border border-slate-200
    `;
            bubble.textContent = message;

            const tail = document.createElement('div');
            tail.className = `
        absolute left-1/2 -bottom-3 w-6 h-6 bg-white rotate-45
        -translate-x-1/2 border-r border-b border-slate-200
    `;
            bubble.appendChild(tail);

            /* Character Image */
            const img = document.createElement('img');
            img.src = character.frames[0];
            img.style.width = character.width + 'px';
            img.className = 'drop-shadow-2xl select-none';
            img.draggable = false;
            if (direction === -1) img.style.transform = 'scaleX(-1)';

            wrapper.appendChild(bubble);
            wrapper.appendChild(img);
            stage.appendChild(wrapper);

            let frameIndex = 0;
            const sprite = setInterval(() => {
                img.src = character.frames[frameIndex];
                frameIndex = (frameIndex + 1) % character.frames.length;
            }, FRAME_SPEED);

            const self = {
                x,
                direction,
                width: character.width,
            };
            activeCharacters.push(self);

            wrapper.style.bottom = '0px';


            function move() {

                // cari karakter terdekat di depan
                const ahead = activeCharacters
                    .filter(c =>
                        c !== self &&
                        c.direction === direction &&
                        (direction === 1 ? c.x > x : c.x < x)
                    )
                    .sort((a, b) =>
                        direction === 1 ? a.x - b.x : b.x - a.x
                    )[0];

                let nextX = x + character.speed * direction;

                if (ahead) {
                    const gap = Math.abs(ahead.x - x) - self.width;

                    // jika terlalu dekat, sejajarkan posisi
                    if (gap < CHARACTER_GAP) {
                        nextX = ahead.x - direction * (self.width + CHARACTER_GAP);
                    }
                }

                x = nextX;
                self.x = x;
                wrapper.style.transform = `translateX(${x}px)`;

                if (
                    (direction === 1 && x > window.innerWidth + 400) ||
                    (direction === -1 && x < -400)
                ) {
                    clearInterval(sprite);
                    wrapper.remove();
                    activeCharacters.splice(activeCharacters.indexOf(self), 1);
                    return;
                }

                requestAnimationFrame(move);
            }


            move();
        }

        /* =====================================================
           LOOP SPAWN
        ===================================================== */
        setInterval(() => {
            const msg = getNextMessage();
            console.log(msg);
            if (msg) spawnCharacter(msg);
        }, SPAWN_INTERVAL);

        /* =====================================================
           INIT
        ===================================================== */
        document.addEventListener('DOMContentLoaded', () => {
            loadMessages();
            setInterval(loadMessages, 30000);
        });
    </script>

    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

    <script>
        /* =====================================================
                   PUSHER CONFIG
                ===================================================== */
        Pusher.logToConsole = false;

        const pusher = new Pusher('PUSHER_APP_KEY', {
            cluster: 'ap1',
            forceTLS: true
        });

        /* =====================================================
           SUBSCRIBE CHANNEL
        ===================================================== */
        const channel = pusher.subscribe('chat');

        /* =====================================================
           LISTEN EVENT
        ===================================================== */
        channel.bind('message.sent', function(data) {

            /**
             * data akan berbentuk:
             * {
             *   name: "...",
             *   email: "...",
             *   message: "..."
             * }
             */

            if (!data || !data.message) return;

            // OPTIONAL: prefix nama pengirim
            const displayMessage = data.name ?
                `${data.name}: ${data.message}` :
                data.message;

            spawnCharacter(displayMessage);
        });
    </script>
@endpush
