# Peta Implementasi User Story — Controller Code

**Tanggal:** 21 Mei 2026
**Scope:** Controller code per User Story (US-01, US-02, US-04, US-13, US-14, US-15)

---

## US-01 — Login & Logout

**File:** `app/Http/Controllers/Auth/MainController.php`

```php
// Baris 15–33 — Method login()
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['error' => 'Email tidak terdaftar!'], 404);
    }
    if (!$user->is_active) {
        return response()->json(['error' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.'], 403);
    }
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return response()->json(['message' => 'Login successful!', 200]);
    }
    return response()->json(['error' => 'Invalid credentials'], 401);
}

// Baris 34–43 — Method logout()
public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
}
```

---

## US-02 — Pesan Error Spesifik Saat Login Gagal

**File:** `app/Http/Controllers/Auth/MainController.php`

```php
// Baris 22–23 — Email tidak ditemukan → HTTP 404
if (!$user) {
    return response()->json(['error' => 'Email tidak terdaftar!'], 404);
}

// Baris 25–27 — Akun dinonaktifkan → HTTP 403
if (!$user->is_active) {
    return response()->json(['error' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.'], 403);
}

// Baris 32 — Password salah → HTTP 401
return response()->json(['error' => 'Invalid credentials'], 401);
```

---

## US-04 — Auto-Cabut Sesi Saat Akun Dinonaktifkan

**File:** `app/Http/Middleware/CheckUserActive.php`

```php
// Baris 14–20 — Dicek setiap request pada semua route protected
public function handle(Request $request, Closure $next): Response
{
    if (Auth::check() && !Auth::user()->is_active) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.']);
    }

    return $next($request);
}
```

**File:** `app/Http/Controllers/System/UserController.php`

```php
// Baris 185–186 — toggleStatus() menyimpan is_active = false
// → Middleware CheckUserActive akan menangkap di request berikutnya
$user->is_active = !$user->is_active;
$user->save();
```

---

## US-13 — Manajemen Pengguna (Lihat, Tambah, Edit, Hapus)

**File:** `app/Http/Controllers/System/UserController.php`

```php
// Baris 60–81 — index(): list semua pengguna
function index()
{
    $data = User::join('data_pengguna', 'data_pengguna.user_id', '=', 'users.id')
        ->select(
            'users.id',
            'users.is_active',
            'data_pengguna.nik',
            'data_pengguna.nama',
            'data_pengguna.contact',
            'users.email'
        )
        ->orderBy('data_pengguna.nama', 'asc')
        ->get();

    $role = Role::select('name')
        ->orderBy('name', 'asc')
        ->get();

    return view('pengaturan.user.create_index', compact('data', 'role'));
}

// Baris 17–59 — store(): tambah pengguna baru
public function store(Request $request)
{
    $request->validate([
        'name'         => 'required|string|max:255',
        'email'        => 'required|email|unique:users,email',
        'contact'      => 'required|numeric|digits_between:10,15',
        'nik'          => 'required|integer|digits:16|unique:data_pengguna,nik',
        'instansi'     => 'required|integer',
        'nama_instansi'=> 'required|string|max:255',
        'role'         => 'required|exists:roles,name',
    ]);

    try {
        DB::beginTransaction();

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make('6472Dukcapil')   // password default
        ]);

        DataPengguna::create([
            'nik'          => $request->nik,
            'nama'         => $request->name,
            'contact'      => $request->contact,
            'instansi'     => $request->instansi,
            'nama_instansi'=> $request->nama_instansi,
            'user_id'      => $user->id,
        ]);

        if ($request->role) {
            $user->syncRoles([$request->role]);
        }
        DB::commit();
        return response()->json(['message' => 'Berhasil membuat user'], 200);
    } catch (Exception $e) {
        DB::rollback();
        return response()->json(['data' => 'Terjadi kegagalan sistem: ' . $e->getMessage()], 500);
    }
}

// Baris 144–173 — edit(): ambil data user untuk form edit
function edit($id)
{
    try {
        $user        = User::findOrFail($id);
        $dataPengguna = DataPengguna::where('user_id', $id)->firstOrFail();
        $roleNames   = $user->getRoleNames();

        $data = [
            'id'           => $user->id,
            'nama'         => $dataPengguna->nama,
            'nik'          => $dataPengguna->nik,
            'contact'      => $dataPengguna->contact,
            'email'        => $user->email,
            'instansi'     => $dataPengguna->instansi,
            'nama_instansi'=> $dataPengguna->nama_instansi,
            'role_names'   => $roleNames->first(),
            'is_active'    => $user->is_active,
        ];

        return response()->json($data, 200);
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    } catch (Exception $e) {
        return response()->json(['message' => 'Proses gagal: ' . $e->getMessage()], 500);
    }
}

// Baris 98–143 — update(): edit data pengguna
function update(Request $request, $id)
{
    $request->validate([
        'name'         => 'required|string|max:255',
        'email'        => 'required|email|unique:users,email,' . $id,
        'contact'      => 'required|numeric|digits_between:10,15',
        'nik'          => 'required|integer|digits:16|unique:data_pengguna,nik,' . $id . ',user_id',
        'instansi'     => 'required|integer',
        'nama_instansi'=> 'required|string|max:255',
        'role'         => 'required|exists:roles,name',
    ]);

    try {
        $user         = User::findOrFail($id);
        $dataPengguna = DataPengguna::where('user_id', $id)->firstOrFail();

        DB::beginTransaction();

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $dataPengguna->update([
            'nik'          => $request->nik,
            'nama'         => $request->name,
            'contact'      => $request->contact,
            'instansi'     => $request->instansi,
            'nama_instansi'=> $request->nama_instansi,
        ]);

        if ($request->role) {
            $user->syncRoles([$request->role]);
        }
        DB::commit();
        return response()->json(['message' => 'Berhasil mengubah data'], 200);
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    } catch (Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Proses gagal'], 500);
    }
}

// Baris 82–96 — destroy(): hapus pengguna
function destroy($id)
{
    try {
        DB::beginTransaction();
        $user = User::findOrFail($id);
        $user->delete();
        DB::commit();
        return response()->json(['message' => 'Berhasil menghapus data'], 200);
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    } catch (Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Proses gagal'], 500);
    }
}
```

---

## US-14 — Toggle Aktif / Nonaktif Akun

**File:** `app/Http/Controllers/System/UserController.php`

```php
// Baris 175–198 — toggleStatus()
function toggleStatus($id)
{
    try {
        $user = User::findOrFail($id);

        // Admin tidak dapat menonaktifkan dirinya sendiri
        if (auth()->id() === $user->id) {
            return response()->json(['message' => 'Tidak dapat mengubah status akun sendiri.'], 403);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return response()->json([
            'message'   => "User berhasil {$status}.",
            'is_active' => $user->is_active,
        ], 200);
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    } catch (Exception $e) {
        return response()->json(['message' => 'Proses gagal: ' . $e->getMessage()], 500);
    }
}
```

---

## US-15 — Manajemen Role & Permission

**File:** `app/Http/Controllers/System/RoleController.php`

```php
// Baris 14–18 — index(): list semua role dan permission
function index()
{
    $data           = Role::orderBy('name', 'asc')->get();
    $dataPermission = Permission::select('name', 'guard_name')->orderBy('name', 'asc')->get();
    return view('pengaturan.role.create_index', compact('data', 'dataPermission'));
}

// Baris 19–38 — store(): buat role baru
function store(Request $request)
{
    $this->validate($request, [
        'name'       => 'required|unique:roles,name',
        'permission' => 'required|array',
    ]);
    try {
        DB::beginTransaction();
        $role = Role::create([
            'name'       => $request->input('name'),
            'guard_name' => 'web'
        ]);
        $permissions = array_values($request->input('permission'));
        $role->syncPermissions($permissions);
        DB::commit();
        return response()->json(['message' => 'berhasil menambahkan'], 200);
    } catch (Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'proses gagal: ' . $e->getMessage()], 500);
    }
}

// Baris 51–55 — edit(): ambil data role untuk form edit
function edit($id)
{
    $role            = Role::where('uuid', $id)->firstOrFail();
    $permissionNames = $role->getPermissionNames();
    return response()->json(['role' => $role, 'permission' => $permissionNames], 200);
}

// Baris 56–76 — update(): ubah nama role + sync permission
function update(Request $request, $id)
{
    $this->validate($request, [
        'name'           => 'required|unique:roles,name,' . $id . ',uuid',
        'permissionEdit' => 'required|array',
    ]);
    try {
        DB::beginTransaction();
        $role = Role::where('uuid', $id)->firstOrFail();
        $role->update([
            'name'       => $request->name,
            'guard_name' => 'web'
        ]);
        $permissions = array_values($request->input('permissionEdit'));
        $role->syncPermissions($permissions);
        DB::commit();
        return response()->json(['message' => 'berhasil mengubah'], 200);
    } catch (Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'proses gagal: ' . $e->getMessage()], 500);
    }
}

// Baris 39–50 — destroy(): hapus role
function destroy(Request $request, $id)
{
    try {
        $role = Role::where('uuid', $id)->firstOrFail();
        DB::beginTransaction();
        $role->delete();
        DB::commit();
        return response()->json(['message' => 'berhasil menghapus'], 200);
    } catch (Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'proses gagal'], 500);
    }
}
```

---

## Ringkasan Controller per US

| US | Controller File | Method |
|---|---|---|
| US-01 | `Auth/MainController.php` | `login()` · `logout()` |
| US-02 | `Auth/MainController.php` | `login()` (baris 22–32) |
| US-04 | `Middleware/CheckUserActive.php` | `handle()` |
| US-13 | `System/UserController.php` | `index()` · `store()` · `edit()` · `update()` · `destroy()` |
| US-14 | `System/UserController.php` | `toggleStatus()` |
| US-15 | `System/RoleController.php` | `index()` · `store()` · `edit()` · `update()` · `destroy()` |
