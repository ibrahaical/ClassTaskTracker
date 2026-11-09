<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Task Tracker | SchoolTech Indonesia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-zinc-50/80 text-zinc-900 antialiased">

    <nav class="sticky top-0 z-30 border-b border-zinc-200 bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6">
            <a href="/" class="flex min-w-0 items-center gap-3" aria-label="Class Task Tracker">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-zinc-900 text-white">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M8 6h13M8 12h13M8 18h13"></path>
                        <path d="M3 6h.01M3 12h.01M3 18h.01"></path>
                    </svg>
                </span>
                <span class="min-w-0">
                    <span class="block truncate text-sm font-semibold tracking-tight text-zinc-900">Class Task Tracker</span>
                    <span class="block text-xs text-zinc-500">SchoolTech Indonesia</span>
                </span>
            </a>
            <div id="nav-user" class="hidden items-center gap-2 sm:gap-3">
                <span id="role-pill" class="rounded-md border border-zinc-200 bg-zinc-50 px-2 py-1 text-[11px] font-semibold uppercase tracking-wide text-zinc-600"></span>
                <span id="user-badge" class="max-w-32 truncate text-sm font-medium text-zinc-700 sm:max-w-52"></span>
                <span class="hidden h-5 w-px bg-zinc-200 sm:block" aria-hidden="true"></span>
                <button onclick="handleLogout()" class="inline-flex min-h-9 items-center gap-2 rounded-md border border-zinc-200 bg-white px-2.5 text-xs font-medium text-zinc-700 transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-400 sm:px-3">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M10 17l5-5-5-5M15 12H3"></path>
                        <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"></path>
                    </svg>
                    <span class="hidden sm:inline">Keluar</span>
                </button>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-6 sm:px-6 sm:py-8">
        <div id="alert-box" role="status" aria-live="polite" class="mb-5 hidden rounded-lg border px-4 py-3 text-sm font-medium"></div>

        <section id="auth-section" class="mx-auto mt-8 max-w-md rounded-lg border border-zinc-200/90 bg-white p-5 shadow-sm sm:mt-12 sm:p-7">
            <div class="mb-6">
                <p class="mb-2 text-xs font-medium uppercase tracking-[0.16em] text-zinc-500">SchoolTech Indonesia</p>
                <h1 class="text-xl font-semibold tracking-tight text-zinc-900">Kelola tugas kelas dengan rapi</h1>
                <p class="mt-1 text-sm text-zinc-500">Masuk untuk melihat dan mengelola tugas kelas.</p>
            </div>
            <div class="mb-6 flex border-b border-zinc-200">
                <button id="tab-login" onclick="switchAuthTab('login')" class="w-1/2 border-b-2 border-zinc-900 pb-2.5 text-sm font-medium text-zinc-900">Masuk</button>
                <button id="tab-register" onclick="switchAuthTab('register')" class="w-1/2 border-b-2 border-transparent pb-2.5 text-sm font-medium text-zinc-500 transition hover:text-zinc-800">Daftar</button>
            </div>

            <form id="login-form" onsubmit="handleLogin(event)" class="space-y-4">
                <div class="space-y-1.5">
                    <label for="login-email" class="block text-sm font-medium text-zinc-700">Email</label>
                    <input type="email" id="login-email" required placeholder="guru@schooltech.id" class="w-full rounded-md border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                </div>
                <div class="space-y-1.5">
                    <label for="login-password" class="block text-sm font-medium text-zinc-700">Kata sandi</label>
                    <input type="password" id="login-password" required placeholder="Masukkan kata sandi" class="w-full rounded-md border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                </div>
                <button type="submit" id="btn-login" class="inline-flex min-h-10 w-full items-center justify-center rounded-md bg-zinc-900 px-4 text-sm font-medium text-white transition hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-zinc-400 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60">
                    Masuk ke aplikasi
                </button>
                <div class="rounded-md border border-zinc-200 bg-zinc-50 px-3.5 py-3 text-xs leading-5 text-zinc-600">
                    <p class="mb-1 font-medium text-zinc-800">Akun demo</p>
                    <p><span class="font-medium">Guru:</span> guru@schooltech.id / password123</p>
                    <p><span class="font-medium">Siswa:</span> siswa@schooltech.id / password123</p>
                </div>
            </form>

            <form id="register-form" onsubmit="handleRegister(event)" class="hidden space-y-4">
                <div class="space-y-1.5">
                    <label for="reg-name" class="block text-sm font-medium text-zinc-700">Nama lengkap</label>
                    <input type="text" id="reg-name" required class="w-full rounded-md border border-zinc-200 px-3 py-2.5 text-sm outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                </div>
                <div class="space-y-1.5">
                    <label for="reg-email" class="block text-sm font-medium text-zinc-700">Email</label>
                    <input type="email" id="reg-email" required class="w-full rounded-md border border-zinc-200 px-3 py-2.5 text-sm outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                </div>
                <div class="space-y-1.5">
                    <label for="reg-password" class="block text-sm font-medium text-zinc-700">Kata sandi <span class="font-normal text-zinc-500">(minimal 6 karakter)</span></label>
                    <input type="password" id="reg-password" required class="w-full rounded-md border border-zinc-200 px-3 py-2.5 text-sm outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                </div>
                <div class="space-y-1.5">
                    <label for="reg-role" class="block text-sm font-medium text-zinc-700">Daftar sebagai</label>
                    <select id="reg-role" required class="w-full rounded-md border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-700 outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                        <option value="student">Siswa</option>
                        <option value="teacher">Guru</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label for="reg-class" class="block text-sm font-medium text-zinc-700">Kelas</label>
                    <input type="text" id="reg-class" value="XII RPL 1" class="w-full rounded-md border border-zinc-200 px-3 py-2.5 text-sm outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                </div>
                <button type="submit" id="btn-register" class="inline-flex min-h-10 w-full items-center justify-center rounded-md bg-zinc-900 px-4 text-sm font-medium text-white transition hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-zinc-400 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60">
                    Daftar akun
                </button>
            </form>
        </section>

        <section id="dashboard-section" class="hidden space-y-6">
            <header class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-[0.16em] text-zinc-500">Ruang kelas</p>
                <h1 class="text-2xl font-semibold tracking-tight text-zinc-900">Daftar tugas</h1>
                <p class="text-sm text-zinc-500">Pantau tugas, tenggat waktu, dan progres penyelesaian kelas.</p>
            </header>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                <div class="rounded-lg border border-zinc-200/90 bg-white p-4 shadow-sm">
                    <p class="text-xs font-medium text-zinc-500">Tugas di halaman ini</p>
                    <p id="summary-total" class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900">0</p>
                </div>
                <div class="rounded-lg border border-zinc-200/90 bg-white p-4 shadow-sm">
                    <p class="flex items-center gap-2 text-xs font-medium text-zinc-500"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Sudah selesai</p>
                    <p id="summary-completed" class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900">0</p>
                </div>
                <div class="rounded-lg border border-zinc-200/90 bg-white p-4 shadow-sm">
                    <p class="flex items-center gap-2 text-xs font-medium text-zinc-500"><span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>Belum selesai</p>
                    <p id="summary-pending" class="mt-2 text-2xl font-semibold tracking-tight text-zinc-900">0</p>
                </div>
            </div>

            <div class="flex flex-col gap-3 rounded-lg border border-zinc-200/90 bg-white p-3 shadow-sm sm:flex-row sm:items-center">
                <label class="relative min-w-0 flex-1">
                    <span class="sr-only">Cari judul tugas</span>
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <input type="search" id="search-input" placeholder="Cari judul tugas..." class="min-h-10 w-full rounded-md border border-zinc-200 bg-white py-2 pl-9 pr-3 text-sm outline-none transition placeholder:text-zinc-400 focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                </label>
                <select id="status-filter" aria-label="Filter status tugas" class="min-h-10 rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 outline-none focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                    <option value="">Semua Status</option>
                    <option value="pending">Belum Selesai</option>
                    <option value="completed">Sudah Selesai</option>
                </select>
                <button onclick="fetchTasks(1)" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md border border-zinc-200 bg-white px-3.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-300">
                    Terapkan
                </button>
                <button id="btn-open-create" onclick="openTaskModal()" class="hidden inline-flex min-h-10 shrink-0 items-center justify-center gap-2 rounded-md bg-zinc-900 px-3.5 text-sm font-medium text-white transition hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-zinc-400 focus:ring-offset-2">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 5v14M5 12h14"></path>
                    </svg>
                    Buat tugas
                </button>
            </div>

            <div id="loading-indicator" class="hidden grid grid-cols-1 gap-4 sm:grid-cols-2" aria-label="Memuat tugas" aria-live="polite">
                <div class="animate-pulse rounded-lg border border-zinc-200/90 bg-white p-4 shadow-sm">
                    <div class="flex justify-between">
                        <div class="h-5 w-20 rounded bg-zinc-100"></div>
                        <div class="h-5 w-24 rounded-full bg-zinc-100"></div>
                    </div>
                    <div class="mt-5 h-5 w-3/4 rounded bg-zinc-100"></div>
                    <div class="mt-3 h-3 w-full rounded bg-zinc-100"></div>
                    <div class="mt-2 h-3 w-2/3 rounded bg-zinc-100"></div>
                    <div class="mt-6 border-t border-zinc-100 pt-4">
                        <div class="h-4 w-1/2 rounded bg-zinc-100"></div>
                    </div>
                </div>
                <div class="animate-pulse rounded-lg border border-zinc-200/90 bg-white p-4 shadow-sm">
                    <div class="flex justify-between">
                        <div class="h-5 w-20 rounded bg-zinc-100"></div>
                        <div class="h-5 w-24 rounded-full bg-zinc-100"></div>
                    </div>
                    <div class="mt-5 h-5 w-2/3 rounded bg-zinc-100"></div>
                    <div class="mt-3 h-3 w-full rounded bg-zinc-100"></div>
                    <div class="mt-2 h-3 w-3/4 rounded bg-zinc-100"></div>
                    <div class="mt-6 border-t border-zinc-100 pt-4">
                        <div class="h-4 w-1/2 rounded bg-zinc-100"></div>
                    </div>
                </div>
            </div>

            <div id="task-list" class="grid grid-cols-1 gap-4 sm:grid-cols-2"></div>

            <div id="pagination-bar" class="flex flex-col items-center justify-between gap-3 rounded-lg border border-zinc-200/90 bg-white px-4 py-3 text-sm text-zinc-600 shadow-sm sm:flex-row"></div>
        </section>
    </main>

    <div id="task-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-zinc-950/40 p-4 backdrop-blur-[2px]">
        <div class="w-full max-w-lg space-y-5 rounded-lg border border-zinc-200/90 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 id="modal-title" class="text-lg font-semibold tracking-tight text-zinc-900">Buat tugas baru</h2>
                    <p class="mt-1 text-sm text-zinc-500">Lengkapi detail dan tenggat tugas kelas.</p>
                </div>
                <button type="button" onclick="closeTaskModal()" aria-label="Tutup formulir" class="rounded-md p-1.5 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-800">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" aria-hidden="true">
                        <path d="m18 6-12 12M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="task-form" onsubmit="handleSaveTask(event)" class="space-y-4">
                <input type="hidden" id="task-id">
                <div class="space-y-1.5">
                    <label for="task-title" class="block text-sm font-medium text-zinc-700">Judul tugas</label>
                    <input type="text" id="task-title" required class="w-full rounded-md border border-zinc-200 px-3 py-2.5 text-sm outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-1.5">
                        <label for="task-class" class="block text-sm font-medium text-zinc-700">Kelas</label>
                        <input type="text" id="task-class" required placeholder="XII RPL 1" class="w-full rounded-md border border-zinc-200 px-3 py-2.5 text-sm outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                    </div>
                    <div class="space-y-1.5">
                        <label for="task-due" class="block text-sm font-medium text-zinc-700">Tenggat</label>
                        <input type="date" id="task-due" required class="w-full rounded-md border border-zinc-200 px-3 py-2.5 text-sm outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label for="task-desc" class="block text-sm font-medium text-zinc-700">Deskripsi <span class="font-normal text-zinc-500">(opsional)</span></label>
                    <textarea id="task-desc" rows="4" class="w-full resize-y rounded-md border border-zinc-200 px-3 py-2.5 text-sm outline-none transition focus:border-zinc-400 focus:ring-2 focus:ring-zinc-100"></textarea>
                </div>
                <div class="flex flex-col-reverse gap-2 border-t border-zinc-100 pt-4 sm:flex-row sm:justify-end">
                    <button type="button" onclick="closeTaskModal()" class="min-h-9 rounded-md border border-zinc-200 px-3.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">Batal</button>
                    <button type="submit" id="btn-save-task" class="min-h-9 rounded-md bg-zinc-900 px-3.5 text-sm font-medium text-white transition hover:bg-zinc-800 disabled:cursor-not-allowed disabled:opacity-60">Simpan tugas</button>
                </div>
            </form>
        </div>
    </div>

    <div id="delete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-zinc-950/40 p-4 backdrop-blur-[2px]" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title" aria-describedby="delete-modal-description" onclick="if (event.target === this) closeDeleteModal()">
        <div class="w-full max-w-md rounded-lg border border-zinc-200/90 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex gap-4">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 9v4m0 4h.01"></path>
                        <path d="M10.3 3.9 1.8 18.2A2 2 0 0 0 3.5 21h17a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z"></path>
                    </svg>
                </span>
                <div class="min-w-0">
                    <h2 id="delete-modal-title" class="text-base font-semibold tracking-tight text-zinc-900">Hapus tugas ini?</h2>
                    <p id="delete-modal-description" class="mt-1 text-sm leading-5 text-zinc-500">Tugas ini akan dihapus secara permanen dan tidak dapat dipulihkan.</p>
                    <p id="delete-task-title" class="mt-3 break-words rounded-md border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm font-medium text-zinc-700"></p>
                </div>
            </div>
            <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <button type="button" onclick="closeDeleteModal()" class="min-h-9 rounded-md border border-zinc-200 bg-white px-3.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-300">Batal</button>
                <button type="button" id="btn-confirm-delete" onclick="confirmDeleteTask()" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-md border border-red-200/60 bg-red-50 px-3.5 text-sm font-medium text-red-600 transition hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-200 disabled:cursor-not-allowed disabled:opacity-60">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 6h18M8 6V4h8v2m3 0-1 14H6L5 6m4 4v6m6-6v6"></path>
                    </svg>
                    <span>Hapus tugas</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentUser = null;
        let authToken = localStorage.getItem('token') || null;
        let currentPage = 1;
        let loadedTasks = [];
        let pendingDeleteTaskId = null;

        function escapeHtml(value) {
            const entities = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;',
            };

            return String(value ?? '').replace(/[&<>"']/g, character => entities[character]);
        }

        function showAlert(message, type = 'error') {
            const box = document.getElementById('alert-box');
            box.className = `mb-5 rounded-lg border px-4 py-3 text-sm font-medium ${
                type === 'error'
                    ? 'border-red-200 bg-red-50 text-red-700'
                    : 'border-emerald-200 bg-emerald-50 text-emerald-700'
            }`;
            box.textContent = message;
            box.classList.remove('hidden');
            setTimeout(() => box.classList.add('hidden'), 4500);
        }

        function switchAuthTab(tab) {
            const isLogin = tab === 'login';
            document.getElementById('login-form').classList.toggle('hidden', !isLogin);
            document.getElementById('register-form').classList.toggle('hidden', isLogin);
            document.getElementById('tab-login').className = isLogin ?
                'w-1/2 border-b-2 border-zinc-900 pb-2.5 text-sm font-medium text-zinc-900' :
                'w-1/2 border-b-2 border-transparent pb-2.5 text-sm font-medium text-zinc-500 transition hover:text-zinc-800';
            document.getElementById('tab-register').className = !isLogin ?
                'w-1/2 border-b-2 border-zinc-900 pb-2.5 text-sm font-medium text-zinc-900' :
                'w-1/2 border-b-2 border-transparent pb-2.5 text-sm font-medium text-zinc-500 transition hover:text-zinc-800';
        }

        async function apiFetch(url, options = {}) {
            const headers = {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                ...(authToken ? {
                    'Authorization': `Bearer ${authToken}`
                } : {})
            };
            const response = await fetch(url, {
                ...options,
                headers
            });
            const data = await response.json();
            const requestPath = new URL(url, window.location.origin).pathname;
            if (response.status === 401 && requestPath !== '/api/login') {
                localStorage.removeItem('token');
                authToken = null;
                currentUser = null;
                loadedTasks = [];
                document.getElementById('auth-section').classList.remove('hidden');
                document.getElementById('dashboard-section').classList.add('hidden');
                document.getElementById('nav-user').classList.add('hidden');
                document.getElementById('nav-user').classList.remove('flex');
                throw new Error('Sesi telah berakhir. Silakan login kembali.');
            }

            if (!response.ok) {
                const errMsg = data.errors ?
                    Object.values(data.errors).flat().join(' ') :
                    (data.message || 'Terjadi kesalahan pada server.');
                throw new Error(errMsg);
            }
            return data;
        }

        async function handleLogin(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-login');
            btn.disabled = true;
            btn.textContent = 'Memproses...';
            try {
                const res = await apiFetch('/api/login', {
                    method: 'POST',
                    body: JSON.stringify({
                        email: document.getElementById('login-email').value,
                        password: document.getElementById('login-password').value,
                    })
                });
                authToken = res.data.token;
                localStorage.setItem('token', authToken);
                currentUser = res.data.user;
                showAlert('Login berhasil! Selamat datang, ' + currentUser.name, 'success');
                renderDashboardState();
            } catch (err) {
                showAlert(err.message, 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Masuk ke Aplikasi';
            }
        }

        async function handleRegister(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-register');
            btn.disabled = true;
            btn.textContent = 'Mendaftarkan...';
            try {
                const res = await apiFetch('/api/register', {
                    method: 'POST',
                    body: JSON.stringify({
                        name: document.getElementById('reg-name').value,
                        email: document.getElementById('reg-email').value,
                        password: document.getElementById('reg-password').value,
                        role: document.getElementById('reg-role').value,
                        class_name: document.getElementById('reg-class').value,
                    })
                });
                authToken = res.data.token;
                localStorage.setItem('token', authToken);
                currentUser = res.data.user;
                showAlert('Registrasi berhasil!', 'success');
                renderDashboardState();
            } catch (err) {
                showAlert(err.message, 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Daftar akun';
            }
        }

        async function handleLogout() {
            try {
                await apiFetch('/api/logout', {
                    method: 'POST'
                });
            } catch (err) {
                showAlert(err.message, 'error');
            }
            localStorage.removeItem('token');
            authToken = null;
            currentUser = null;
            document.getElementById('auth-section').classList.remove('hidden');
            document.getElementById('dashboard-section').classList.add('hidden');
            document.getElementById('nav-user').classList.add('hidden');
        }

        function renderDashboardState() {
            document.getElementById('auth-section').classList.add('hidden');
            document.getElementById('dashboard-section').classList.remove('hidden');
            const navUser = document.getElementById('nav-user');
            navUser.classList.remove('hidden');
            navUser.classList.add('flex');
            const roleLabel = currentUser.role === 'teacher' ? 'GURU' : 'SISWA';
            document.getElementById('user-badge').textContent = currentUser.name;
            document.getElementById('role-pill').textContent = roleLabel;
            document.getElementById('btn-open-create').classList.toggle('hidden', currentUser.role !== 'teacher');
            fetchTasks(1);
        }

        async function fetchTasks(page = 1) {
            currentPage = page;
            const search = document.getElementById('search-input').value;
            const status = document.getElementById('status-filter').value;
            const loader = document.getElementById('loading-indicator');
            const listEl = document.getElementById('task-list');

            loader.classList.remove('hidden');
            listEl.innerHTML = '';

            try {
                const params = new URLSearchParams({
                    page,
                    search,
                    status
                });
                const res = await apiFetch(`/api/tasks?${params.toString()}`);
                const paginated = res.data;
                renderTaskCards(paginated.data);
                renderPagination(paginated);
            } catch (err) {
                showAlert(err.message, 'error');
            } finally {
                loader.classList.add('hidden');
            }
        }

        function renderTaskCards(tasks) {
            const listEl = document.getElementById('task-list');
            document.getElementById('summary-total').textContent = tasks.length;
            document.getElementById('summary-completed').textContent = tasks.filter(task => task.is_completed).length;
            document.getElementById('summary-pending').textContent = tasks.filter(task => !task.is_completed).length;

            if (!tasks.length) {
                loadedTasks = [];
                listEl.innerHTML = `
                    <div class="col-span-full flex min-h-64 flex-col items-center justify-center rounded-lg border border-dashed border-zinc-300 bg-white px-6 py-10 text-center">
                        <span class="mb-4 flex h-11 w-11 items-center justify-center rounded-full bg-zinc-100 text-zinc-500">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <path d="M3 10h18"></path>
                            </svg>
                        </span>
                        <h2 class="text-sm font-semibold text-zinc-900">Tidak ada tugas ditemukan</h2>
                        <p class="mt-1 max-w-sm text-sm text-zinc-500">Coba ubah kata kunci atau filter status untuk melihat tugas lainnya.</p>
                    </div>
                `;
                return;
            }

            loadedTasks = tasks;
            listEl.innerHTML = tasks.map(t => {
                const taskId = Number(t.id);
                const badgeClass = t.is_completed ?
                    'border-emerald-200 bg-emerald-50 text-emerald-700' :
                    'border-amber-200 bg-amber-50 text-amber-700';
                const badgeText = t.is_completed ? 'Selesai' : 'Belum Selesai';
                const badgeDotClass = t.is_completed ? 'bg-emerald-500' : 'bg-amber-500';

                const actionsHtml = currentUser.role === 'teacher' ?
                    `<div class="flex flex-wrap gap-2">
                        <button onclick="openEditModalById(${taskId})" class="inline-flex min-h-8 items-center gap-1.5 rounded-md border border-zinc-200 bg-white px-3 py-1.5 text-xs font-medium text-zinc-700 transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-300">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"></path>
                            </svg>
                            Edit
                        </button>
                        <button onclick="handleDeleteTask(${taskId})" class="inline-flex min-h-8 items-center gap-1.5 rounded-md border border-red-200/60 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-200">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M3 6h18M8 6V4h8v2m3 0-1 14H6L5 6m4 4v6m6-6v6"></path>
                            </svg>
                            Hapus
                        </button>
                    </div>` :
                    `<button onclick="handleToggleComplete(${taskId})" class="inline-flex min-h-8 items-center gap-1.5 rounded-md px-3 py-1.5 text-xs font-medium transition focus:outline-none focus:ring-2 focus:ring-zinc-300 ${
                        t.is_completed
                            ? 'border border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50'
                            : 'bg-zinc-900 text-white hover:bg-zinc-800'
                       }">
                        ${t.is_completed
                            ? '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 12 2 2 4-4"></path><circle cx="12" cy="12" r="9"></circle></svg> Batalkan'
                            : '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 12 2 2 4-4"></path><circle cx="12" cy="12" r="9"></circle></svg> Tandai selesai'}
                       </button>`;

                return `
                    <article class="flex min-w-0 flex-col justify-between rounded-lg border border-zinc-200/90 bg-white p-4 shadow-sm transition hover:border-zinc-300">
                        <div>
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span class="rounded-md border border-zinc-200 bg-zinc-50 px-2 py-1 font-mono text-[11px] font-medium text-zinc-600" style="font-family: 'JetBrains Mono', monospace;">${escapeHtml(t.class_name)}</span>
                                <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-[11px] font-medium ${badgeClass}">
                                    <span class="h-1.5 w-1.5 rounded-full ${badgeDotClass}"></span>${badgeText}
                                </span>
                            </div>
                            <h2 class="mt-4 break-words text-sm font-semibold leading-5 text-zinc-900">${escapeHtml(t.title)}</h2>
                            <p class="mt-2 line-clamp-2 min-h-10 break-words text-sm leading-5 text-zinc-600">${escapeHtml(t.description || 'Tidak ada deskripsi tambahan.')}</p>
                        </div>
                        <div class="mt-4 flex flex-col gap-3 border-t border-zinc-100 pt-3">
                            <div class="flex flex-wrap items-center justify-between gap-x-3 gap-y-2 text-xs text-zinc-500">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="h-4 w-4 shrink-0 text-zinc-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect x="3" y="5" width="18" height="16" rx="2"></rect><path d="M16 3v4M8 3v4M3 11h18"></path>
                                    </svg>
                                    Tenggat <time class="font-mono font-medium text-zinc-700" style="font-family: 'JetBrains Mono', monospace;">${escapeHtml(t.due_date)}</time>
                                </span>
                                <span>${escapeHtml(t.completions_count)} siswa menyelesaikan</span>
                            </div>
                            <div class="flex justify-end">${actionsHtml}</div>
                        </div>
                    </article>
                `;
            }).join('');
        }

        function renderPagination(meta) {
            const bar = document.getElementById('pagination-bar');
            bar.innerHTML = `
                <span>Halaman <b class="font-medium text-zinc-900">${escapeHtml(meta.current_page)}</b> dari <b class="font-medium text-zinc-900">${escapeHtml(meta.last_page)}</b> <span class="text-zinc-400">·</span> ${escapeHtml(meta.total)} tugas</span>
                <div class="flex gap-2">
                    <button ${!meta.prev_page_url ? 'disabled' : ''} onclick="fetchTasks(${Number(meta.current_page) - 1})" class="min-h-8 rounded-md border border-zinc-200 px-3 text-xs font-medium text-zinc-700 transition hover:bg-zinc-50 disabled:cursor-not-allowed disabled:opacity-40">Sebelumnya</button>
                    <button ${!meta.next_page_url ? 'disabled' : ''} onclick="fetchTasks(${Number(meta.current_page) + 1})" class="min-h-8 rounded-md border border-zinc-200 px-3 text-xs font-medium text-zinc-700 transition hover:bg-zinc-50 disabled:cursor-not-allowed disabled:opacity-40">Berikutnya</button>
                </div>
            `;
        }

        function openEditModalById(id) {
            const task = loadedTasks.find(item => Number(item.id) === Number(id));
            if (!task) {
                showAlert('Data tugas tidak ditemukan. Muat ulang daftar tugas.', 'error');
                return;
            }

            openTaskModal(task);
        }

        function openTaskModal(task = null) {
            document.getElementById('task-modal').classList.remove('hidden');
            document.getElementById('modal-title').textContent = task ? 'Ubah Data Tugas' : 'Buat Tugas Baru';
            document.getElementById('task-id').value = task ? task.id : '';
            document.getElementById('task-title').value = task ? task.title : '';
            document.getElementById('task-class').value = task ? task.class_name : 'XII RPL 1';
            document.getElementById('task-due').value = task ? task.due_date : '';
            document.getElementById('task-desc').value = task ? (task.description || '') : '';
        }

        function closeTaskModal() {
            document.getElementById('task-modal').classList.add('hidden');
        }

        async function handleSaveTask(e) {
            e.preventDefault();
            const id = document.getElementById('task-id').value;
            const btn = document.getElementById('btn-save-task');
            btn.disabled = true;
            btn.textContent = 'Menyimpan...';

            const payload = {
                title: document.getElementById('task-title').value,
                class_name: document.getElementById('task-class').value,
                due_date: document.getElementById('task-due').value,
                description: document.getElementById('task-desc').value,
            };

            try {
                if (id) {
                    await apiFetch(`/api/tasks/${id}`, {
                        method: 'PUT',
                        body: JSON.stringify(payload)
                    });
                    showAlert('Tugas berhasil diperbarui.', 'success');
                } else {
                    await apiFetch('/api/tasks', {
                        method: 'POST',
                        body: JSON.stringify(payload)
                    });
                    showAlert('Tugas baru berhasil ditambahkan.', 'success');
                }
                closeTaskModal();
                fetchTasks(currentPage);
            } catch (err) {
                showAlert(err.message, 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Simpan Tugas';
            }
        }

        async function handleDeleteTask(id) {
            pendingDeleteTaskId = Number(id);
            const task = loadedTasks.find(item => Number(item.id) === pendingDeleteTaskId);
            document.getElementById('delete-task-title').textContent = task?.title || `Tugas #${pendingDeleteTaskId}`;
            document.getElementById('delete-modal').classList.remove('hidden');
            document.getElementById('btn-confirm-delete').focus();
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            pendingDeleteTaskId = null;
        }

        async function confirmDeleteTask() {
            if (pendingDeleteTaskId === null) return;

            const taskId = pendingDeleteTaskId;
            const btn = document.getElementById('btn-confirm-delete');
            const label = btn.querySelector('span');
            btn.disabled = true;
            label.textContent = 'Menghapus...';

            try {
                await apiFetch(`/api/tasks/${taskId}`, {
                    method: 'DELETE'
                });
                closeDeleteModal();
                showAlert('Tugas berhasil dihapus.', 'success');
                fetchTasks(currentPage);
            } catch (err) {
                closeDeleteModal();
                showAlert(err.message, 'error');
            } finally {
                btn.disabled = false;
                label.textContent = 'Hapus tugas';
            }
        }

        async function handleToggleComplete(id) {
            try {
                const res = await apiFetch(`/api/tasks/${id}/toggle-complete`, {
                    method: 'PATCH'
                });
                showAlert(res.message, 'success');
                fetchTasks(currentPage);
            } catch (err) {
                showAlert(err.message, 'error');
            }
        }

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && !document.getElementById('delete-modal').classList.contains('hidden')) {
                closeDeleteModal();
            }
        });

        // Cek sesi login otomatis saat halaman dimuat
        (async function init() {
            if (!authToken) return;
            try {
                const res = await apiFetch('/api/me');
                currentUser = res.data;
                renderDashboardState();
            } catch (err) {
                showAlert(err.message, 'error');
            }
        })();
    </script>
</body>

</html>