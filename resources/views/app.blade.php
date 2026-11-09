<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Task Tracker — SchoolTech Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-slate-900 text-white shadow">
        <div class="max-w-5xl mx-auto px-4 py-3 flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <span class="font-bold text-lg tracking-tight">ClassTaskTracker</span>
                <span class="text-xs bg-blue-600 px-2 py-0.5 rounded font-medium">SchoolTech</span>
            </div>
            <div id="nav-user" class="hidden items-center gap-3 text-sm">
                <span id="user-badge" class="bg-slate-800 px-3 py-1 rounded border border-slate-700"></span>
                <button onclick="handleLogout()" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-xs font-semibold transition">
                    Logout
                </button>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4 py-6">
        <!-- Global Alert Box -->
        <div id="alert-box" class="hidden mb-4 p-3 rounded-lg border text-sm font-medium"></div>

        <!-- SECTION 1: AUTH (LOGIN / REGISTER) -->
        <section id="auth-section" class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200 mt-6">
            <div class="flex border-b border-slate-200 mb-5">
                <button id="tab-login" onclick="switchAuthTab('login')" class="w-1/2 pb-2 font-semibold text-blue-600 border-b-2 border-blue-600">Login</button>
                <button id="tab-register" onclick="switchAuthTab('register')" class="w-1/2 pb-2 font-semibold text-slate-400">Registrasi</button>
            </div>

            <!-- Form Login -->
            <form id="login-form" onsubmit="handleLogin(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Email</label>
                    <input type="email" id="login-email" required placeholder="guru@schooltech.id" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Password</label>
                    <input type="password" id="login-password" required placeholder="••••••••" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-600">
                </div>
                <button type="submit" id="btn-login" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg text-sm transition">
                    Masuk ke Aplikasi
                </button>
                <div class="text-xs text-slate-500 bg-slate-100 p-3 rounded-lg space-y-1">
                    <p class="font-semibold text-slate-700">Akun Demo Cepat:</p>
                    <p>• <b>Guru:</b> guru@schooltech.id / password123</p>
                    <p>• <b>Siswa:</b> siswa@schooltech.id / password123</p>
                </div>
            </form>

            <!-- Form Register -->
            <form id="register-form" onsubmit="handleRegister(event)" class="hidden space-y-3">
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Nama Lengkap</label>
                    <input type="text" id="reg-name" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Email</label>
                    <input type="email" id="reg-email" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Password (Min. 6 karakter)</label>
                    <input type="password" id="reg-password" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Kelas</label>
                    <input type="text" id="reg-class" value="XII RPL 1" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <button type="submit" id="btn-register" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-lg text-sm transition">
                    Daftar Akun Baru
                </button>
            </form>
        </section>

        <!-- SECTION 2: DASHBOARD TUGAS -->
        <section id="dashboard-section" class="hidden space-y-5">
            <!-- Header & Tombol Tambah (Khusus Guru) -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <div>
                    <h1 class="text-lg font-bold text-slate-800">Daftar Tugas Kelas</h1>
                    <p class="text-xs text-slate-500">Pantau tenggat waktu dan status penyelesaian tugas secara real-time.</p>
                </div>
                <button id="btn-open-create" onclick="openTaskModal()" class="hidden bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                    + Buat Tugas Baru
                </button>
            </div>

            <!-- Filter & Search Bar -->
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row gap-3">
                <input type="text" id="search-input" placeholder="Cari judul tugas..." class="flex-1 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-600">
                <select id="status-filter" class="border border-slate-300 rounded-lg px-3 py-2 text-sm bg-white">
                    <option value="">Semua Status</option>
                    <option value="pending">Belum Selesai</option>
                    <option value="completed">Sudah Selesai</option>
                </select>
                <button onclick="fetchTasks(1)" class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Terapkan Filter
                </button>
            </div>

            <!-- Indikator Loading -->
            <div id="loading-indicator" class="hidden text-center py-8 text-sm text-slate-500 font-medium">
                Memuat data tugas dari server...
            </div>

            <!-- List Tugas -->
            <div id="task-list" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>

            <!-- Navigasi Paginasi -->
            <div id="pagination-bar" class="flex items-center justify-between bg-white px-4 py-3 rounded-xl border border-slate-200 text-sm"></div>
        </section>
    </main>

    <!-- MODAL FORM TUGAS (GURU) -->
    <div id="task-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl max-w-md w-full p-5 shadow-lg space-y-4">
            <h2 id="modal-title" class="font-bold text-base text-slate-800">Buat Tugas Baru</h2>
            <form id="task-form" onsubmit="handleSaveTask(event)" class="space-y-3">
                <input type="hidden" id="task-id">
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Judul Tugas</label>
                    <input type="text" id="task-title" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Kelas</label>
                        <input type="text" id="task-class" required placeholder="XII RPL 1" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Tenggat (Deadline)</label>
                        <input type="date" id="task-due" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Deskripsi Tugas</label>
                    <textarea id="task-desc" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeTaskModal()" class="px-4 py-2 rounded-lg border border-slate-300 text-xs font-semibold text-slate-600">Batal</button>
                    <button type="submit" id="btn-save-task" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold">Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentUser = null;
        let authToken = localStorage.getItem('token') || null;
        let currentPage = 1;
        let loadedTasks = [];

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
            box.className = `mb-4 p-3 rounded-lg border text-sm font-medium ${
                type === 'error'
                    ? 'bg-red-50 border-red-300 text-red-700'
                    : 'bg-emerald-50 border-emerald-300 text-emerald-700'
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
                'w-1/2 pb-2 font-semibold text-blue-600 border-b-2 border-blue-600' :
                'w-1/2 pb-2 font-semibold text-slate-400';
            document.getElementById('tab-register').className = !isLogin ?
                'w-1/2 pb-2 font-semibold text-blue-600 border-b-2 border-blue-600' :
                'w-1/2 pb-2 font-semibold text-slate-400';
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
                btn.textContent = 'Daftar Akun Baru';
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
            document.getElementById('user-badge').textContent = `${currentUser.name} (${roleLabel})`;
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
            if (!tasks.length) {
                loadedTasks = [];
                listEl.innerHTML = `<div class="col-span-full bg-white p-8 rounded-xl border border-slate-200 text-center text-sm text-slate-500">Tidak ada tugas yang sesuai filter pencarian.</div>`;
                return;
            }

            loadedTasks = tasks;
            listEl.innerHTML = tasks.map(t => {
                const taskId = Number(t.id);
                const badgeClass = t.is_completed ?
                    'bg-emerald-100 text-emerald-700 border-emerald-300' :
                    'bg-amber-100 text-amber-700 border-amber-300';
                const badgeText = t.is_completed ? 'Selesai' : 'Belum Selesai';

                const actionsHtml = currentUser.role === 'teacher' ?
                    `<div class="flex gap-2">
                        <button onclick="openEditModalById(${taskId})" class="text-xs px-3 py-1.5 rounded bg-slate-100 hover:bg-slate-200 font-semibold text-slate-700">Edit</button>
                        <button onclick="handleDeleteTask(${taskId})" class="text-xs px-3 py-1.5 rounded bg-red-50 hover:bg-red-100 font-semibold text-red-600">Hapus</button>
                       </div>` :
                    `<button onclick="handleToggleComplete(${taskId})" class="text-xs px-3 py-1.5 rounded font-semibold transition ${
                        t.is_completed
                            ? 'bg-slate-200 hover:bg-slate-300 text-slate-700'
                            : 'bg-emerald-600 hover:bg-emerald-700 text-white'
                       }">
                        ${t.is_completed ? 'Batalkan Selesai' : '✓ Tandai Selesai'}
                       </button>`;

                return `
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between gap-3">
                        <div class="space-y-2">
                            <div class="flex items-start justify-between gap-2">
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded bg-blue-50 text-blue-700 border border-blue-200">${escapeHtml(t.class_name)}</span>
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded border ${badgeClass}">${badgeText}</span>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base">${escapeHtml(t.title)}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">${escapeHtml(t.description || 'Tidak ada deskripsi tambahan.')}</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <div>
                                <p>Tenggat: <b class="text-slate-700">${escapeHtml(t.due_date)}</b></p>
                                <p>Diselesaikan: <b>${escapeHtml(t.completions_count)} siswa</b></p>
                            </div>
                            ${actionsHtml}
                        </div>
                    </div>
                `;
            }).join('');
        }

        function renderPagination(meta) {
            const bar = document.getElementById('pagination-bar');
            bar.innerHTML = `
                <span>Halaman <b>${escapeHtml(meta.current_page)}</b> dari <b>${escapeHtml(meta.last_page)}</b> (Total ${escapeHtml(meta.total)} tugas)</span>
                <div class="flex gap-2">
                    <button ${!meta.prev_page_url ? 'disabled' : ''} onclick="fetchTasks(${Number(meta.current_page) - 1})" class="px-3 py-1 rounded border border-slate-300 disabled:opacity-40 font-semibold">Sebelumnya</button>
                    <button ${!meta.next_page_url ? 'disabled' : ''} onclick="fetchTasks(${Number(meta.current_page) + 1})" class="px-3 py-1 rounded border border-slate-300 disabled:opacity-40 font-semibold">Berikutnya</button>
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
            if (!confirm('Yakin ingin menghapus tugas ini?')) return;
            try {
                await apiFetch(`/api/tasks/${id}`, {
                    method: 'DELETE'
                });
                showAlert('Tugas berhasil dihapus.', 'success');
                fetchTasks(currentPage);
            } catch (err) {
                showAlert(err.message, 'error');
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