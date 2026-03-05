# Dokumentasi Controllers & API Endpoints - LMS Citra Husada

## Daftar Isi

1. [AuthController](#authcontroller)
2. [JenisTenagaController](#jenistenatgacontroller)
3. [Request/Response Format](#requestresponse-format)
4. [Error Handling](#error-handling)
5. [Authentication Flow](#authentication-flow)

---

## AuthController

**File:** `app/Http/Controllers/AuthController.php`

### Tujuan
Controller untuk menangani autentikasi user (login/logout) baik untuk web maupun API.

### Methods

#### 1. showLogin()

Menampilkan halaman login.

**Route:**
```
GET /
```

**Return:** View `login.blade.php`

**Authorization:** None (public)

**Code:**
```php
public function showLogin() {
    return view('login');
}
```

---

#### 2. login()

Proses login untuk web route.

**Route:**
```
POST /
```

**Input:**
```php
[
    'nik'      => 'required|string',
    'password' => 'required|string',
]
```

**Validation:**
- `nik` - Wajib diisi, string
- `password` - Wajib diisi, string

**Return:**
- **Success:** Redirect ke `/pembelajaran`
- **Failed:** Redirect back dengan error message

**Code:**
```php
public function login(Request $request) {
    $credentials = $request->validate([
        'nik'      => 'required|string',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/pembelajaran');
    }

    return back()->withErrors(["nik" => "Nomor induk atau kata sandi tidak cocok."]);
}
```

---

#### 3. loginApi()

Proses login untuk API (JSON response).

**Route:**
```
POST /api/login
```

**Input:**
```json
{
    "nik": "0112.01072",
    "password": "123",
    "remember": true
}
```

**Validation:**
- `nik` - Wajib diisi, string
- `password` - Wajib diisi, string
- `remember` - Optional, boolean

**Return Type:** JSON

**Success Response (200):**
```json
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "user": {
            "user_id": 1,
            "nama": "dr. Susilo Wardhani S, MM",
            "nik": "0112.01072",
            "role_id": 4,
            "jenis_tenaga_id": 1,
            "unit_kerja_id": 1,
            "status": true,
            "created_at": "2026-03-02T09:00:00Z",
            "updated_at": "2026-03-04T08:19:31Z"
        },
        "redirect": "/pembelajaran"
    }
}
```

**Error Response (401):**
```json
{
    "success": false,
    "message": "User dengan NIK tersebut tidak ditemukan",
    "data": null
}
```

```json
{
    "success": false,
    "message": "Password salah untuk user dengan NIK ini",
    "data": null
}
```

**Validation Error Response (422):**
```json
{
    "success": false,
    "message": "Validasi gagal",
    "data": {
        "nik": ["NIK harus diisi"],
        "password": ["Password harus diisi"]
    }
}
```

**Code:**
```php
public function loginApi(Request $request) {
    try {
        $credentials = $request->validate([
            'nik'      => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('nik', $credentials['nik'])->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User dengan NIK tersebut tidak ditemukan',
                'data' => null
            ], 401);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'user' => $user,
                    'redirect' => '/pembelajaran'
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Password salah untuk user dengan NIK ini',
            'data' => null
        ], 401);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'data' => $e->errors()
        ], 422);
    }
}
```

---

#### 4. logoutApi()

Proses logout untuk API.

**Route:**
```
POST /api/logout
```

**Authorization:** Require auth (middleware: `auth`)

**Header:**
```
Cookie: laravel-session=...
```

**Return Type:** JSON

**Success Response (200):**
```json
{
    "success": true,
    "message": "Logout berhasil",
    "data": null
}
```

**Error Response (500):**
```json
{
    "success": false,
    "message": "Gagal melakukan logout",
    "data": null
}
```

**Code:**
```php
public function logoutApi(Request $request) {
    try {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
            'data' => null
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal melakukan logout',
            'data' => null
        ], 500);
    }
}
```

---

#### 5. logout()

Proses logout untuk web route.

**Route:**
```
POST /logout
```

**Authorization:** Require auth (middleware: `auth`)

**Return:** Redirect ke `/` (login page)

**Code:**
```php
public function logout(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
}
```

---

## JenisTenagaController

**File:** `app/Http/Controllers/JenisTenagaController.php`

Controller untuk menangani CRUD operations untuk Jenis Tenaga.

### Methods

#### 1. index()

Ambil daftar semua jenis tenaga.

**Route:**
```
GET /api/jenis-tenaga
```

**Authorization:** None (public)

**Query Parameters:**
```
?page=1
?limit=10
?search=dokter
```

**Return Type:** JSON

**Response (200):**
```json
{
    "data": [
        {
            "jenis_tenaga_id": 1,
            "jenis_tenaga": "Dokter",
            "created_at": "2026-03-02T09:00:00Z",
            "updated_at": "2026-03-02T09:00:00Z"
        },
        {
            "jenis_tenaga_id": 2,
            "jenis_tenaga": "Perawat",
            "created_at": "2026-03-02T09:00:00Z",
            "updated_at": "2026-03-02T09:00:00Z"
        }
    ]
}
```

**Code:**
```php
public function index() {
    $jenisTenaga = JenisTenaga::all();
    return response()->json(['data' => $jenisTenaga]);
}
```

---

#### 2. show()

Ambil detail jenis tenaga berdasarkan ID.

**Route:**
```
GET /api/jenis-tenaga/:id
```

**Route Parameters:**
- `id` (BIGINT) - Jenis Tenaga ID

**Authorization:** None (public)

**Response (200):**
```json
{
    "data": {
        "jenis_tenaga_id": 1,
        "jenis_tenaga": "Dokter",
        "created_at": "2026-03-02T09:00:00Z",
        "updated_at": "2026-03-02T09:00:00Z"
    }
}
```

**Error Response (404):**
```json
{
    "message": "Resource not found"
}
```

**Code:**
```php
public function show(JenisTenaga $jenisTenaga) {
    return response()->json(['data' => $jenisTenaga]);
}
```

---

#### 3. store()

Buat jenis tenaga baru.

**Route:**
```
POST /api/jenis-tenaga
```

**Authorization:** Require auth (middleware: `auth`)

**Header:**
```
Cookie: laravel-session=...
X-CSRF-TOKEN: ...
Content-Type: application/json
```

**Input:**
```json
{
    "jenis_tenaga": "Radiologi"
}
```

**Validation:**
- `jenis_tenaga` - Wajib diisi, string, unique

**Response (201):**
```json
{
    "data": {
        "jenis_tenaga_id": 10,
        "jenis_tenaga": "Radiologi",
        "created_at": "2026-03-05T10:30:00Z",
        "updated_at": "2026-03-05T10:30:00Z"
    }
}
```

**Validation Error Response (422):**
```json
{
    "message": "Validation failed",
    "errors": {
        "jenis_tenaga": ["Jenis tenaga already exists"]
    }
}
```

**Code:**
```php
public function store(Request $request) {
    $request->validate([
        'jenis_tenaga' => 'required|string|unique:jenis_tenagas'
    ]);

    $jenisTenaga = JenisTenaga::create($request->only('jenis_tenaga'));

    return response()->json(['data' => $jenisTenaga], 201);
}
```

---

#### 4. update()

Update jenis tenaga yang sudah ada.

**Route:**
```
PUT /api/jenis-tenaga/:id
```

**Route Parameters:**
- `id` (BIGINT) - Jenis Tenaga ID

**Authorization:** Require auth (middleware: `auth`)

**Header:**
```
Cookie: laravel-session=...
X-CSRF-TOKEN: ...
Content-Type: application/json
```

**Input:**
```json
{
    "jenis_tenaga": "Dokter Spesialis"
}
```

**Validation:**
- `jenis_tenaga` - Wajib diisi, string, unique (except current id)

**Response (200):**
```json
{
    "data": {
        "jenis_tenaga_id": 1,
        "jenis_tenaga": "Dokter Spesialis",
        "created_at": "2026-03-02T09:00:00Z",
        "updated_at": "2026-03-05T10:35:00Z"
    }
}
```

**Code:**
```php
public function update(Request $request, JenisTenaga $jenisTenaga) {
    $request->validate([
        'jenis_tenaga' => 'required|string|unique:jenis_tenagas,jenis_tenaga,'.$jenisTenaga->jenis_tenaga_id.',jenis_tenaga_id'
    ]);

    $jenisTenaga->update($request->only('jenis_tenaga'));

    return response()->json(['data' => $jenisTenaga]);
}
```

---

#### 5. destroy()

Hapus jenis tenaga.

**Route:**
```
DELETE /api/jenis-tenaga/:id
```

**Route Parameters:**
- `id` (BIGINT) - Jenis Tenaga ID

**Authorization:** Require auth (middleware: `auth`)

**Header:**
```
Cookie: laravel-session=...
X-CSRF-TOKEN: ...
```

**Response (204):** No Content

**Error Response (404):**
```
Resource not found
```

**Code:**
```php
public function destroy(JenisTenaga $jenisTenaga) {
    $jenisTenaga->delete();
    return response()->noContent();
}
```

---

## Request/Response Format

### Standard JSON Response Format

#### Success Response
```json
{
    "success": true,
    "message": "Operation successful",
    "data": {
        // Response data here
    }
}
```

#### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "data": null
}
```

#### Validation Error Response
```json
{
    "success": false,
    "message": "Validation failed",
    "data": {
        "field_name": ["Error message 1", "Error message 2"]
    }
}
```

### Request Headers

**Required untuk authenticated requests:**
```
Content-Type: application/json
Cookie: laravel-session=<session_id>
X-Requested-With: XMLHttpRequest
X-CSRF-TOKEN: <csrf_token>
```

**Optional:**
```
Accept: application/json
Accept-Language: id-ID
User-Agent: <browser_user_agent>
```

### Common HTTP Status Codes

| Code | Meaning | Usage |
|------|---------|-------|
| 200 | OK | Successful GET, PUT |
| 201 | Created | Successful POST |
| 204 | No Content | Successful DELETE |
| 400 | Bad Request | Invalid request format |
| 401 | Unauthorized | Session expired/not authenticated |
| 403 | Forbidden | Insufficient permissions |
| 404 | Not Found | Resource doesn't exist |
| 422 | Unprocessable Entity | Validation error |
| 500 | Internal Server Error | Server error |

---

## Error Handling

### Exception Handling

#### ValidationException
```php
try {
    $request->validate([...]);
} catch (\Illuminate\Validation\ValidationException $e) {
    return response()->json([
        'success' => false,
        'message' => 'Validation failed',
        'data' => $e->errors()
    ], 422);
}
```

#### ModelNotFoundException
```php
Route::get('/jenis-tenaga/{jenisTenaga}', ...);

// Automatically handles 404 if not found
// JenisTenaga model is auto-injected via route model binding
```

#### General Exception
```php
try {
    // operation
} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'data' => null
    ], 500);
}
```

---

## Authentication Flow

### 1. User Login (Frontend)

```javascript
// login.blade.php
axios.post('/api/login', {
    nik: '0112.01072',
    password: '123',
    remember: true
});
```

### 2. Backend Verification

```php
// AuthController@loginApi
Auth::attempt(['nik' => $nik, 'password' => $password]);
```

Proses:
1. Hash password input dengan password hash di database
2. Jika match, set session dengan user data
3. Return session cookie

### 3. Session Cookie

Browser menerima cookie:
```
Set-Cookie: laravel-session=abc123...; Path=/; HttpOnly; SameSite=Lax
```

### 4. Subsequent Requests

Browser otomatis mengirim cookie:
```
Cookie: laravel-session=abc123...
```

### 5. Server Verification

```php
// Middleware: auth
if (Auth::check()) {
    // User authenticated
} else {
    // Redirect to login
}
```

---

## Testing Endpoints

### Using cURL

```bash
# Login
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"nik":"0112.01072","password":"123"}' \
  -c cookies.txt

# Check Auth
curl -X GET http://127.0.0.1:8000/api/check-auth \
  -b cookies.txt

# Get Jenis Tenaga
curl -X GET http://127.0.0.1:8000/api/jenis-tenaga \
  -H "Accept: application/json"

# Create Jenis Tenaga (authenticated)
curl -X POST http://127.0.0.1:8000/api/jenis-tenaga \
  -H "Content-Type: application/json" \
  -b cookies.txt \
  -d '{"jenis_tenaga":"Nutrisionis"}'
```

### Using Postman

1. Create new collection: "LMS Citra Husada"
2. Add POST request to `http://127.0.0.1:8000/api/login`
   - Body (JSON): `{"nik":"0112.01072","password":"123"}`
3. Enable "Automatically follow redirects"
4. Cookies akan tersimpan otomatis
5. Requests berikutnya akan menggunakan session cookie

---

**Terakhir diupdate:** 5 Maret 2026  
**Versi:** 1.0.0
