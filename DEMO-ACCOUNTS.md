# 🔐 Akun Demo — ONE TOUCH Balai PPMHKP Lampung

> **URL Login:** `http://localhost/OneTouch/public/login`
>
> Semua akun menggunakan password yang sama: **`password123`**

---

## 👑 Admin

| Field        | Value                      |
|--------------|----------------------------|
| **Username** | `admin`                    |
| **Password** | `admin123`              |
| **Email**    | admin@onetouch.test        |
| **Nama**     | Super Admin                |
| **Redirect** | `/admin/dashboard`         |

**Akses Admin:**
- ✅ Dashboard statistik (total sertifikat, inspeksi, user, officer)
- ✅ Manajemen Sertifikat (CRUD semua data)
- ✅ Manajemen Inspeksi (CRUD semua data)
- ✅ Manajemen User (CRUD + assign officer)
- ✅ Laporan (export PDF & Excel)

---

## 🧑‍💼 Officer A

| Field        | Value                       |
|--------------|-----------------------------|
| **Username** | `petugas`                   |
| **Password** | `petugas123`               |
| **Email**    | officer@onetouch.test       |
| **Nama**     | Officer Inspeksi A          |
| **Redirect** | `/officer/dashboard`        |

**Akses Officer:**
- ✅ Dashboard data yang di-handle
- ✅ Input & kelola Sertifikat (milik user yang di-assign ke officer ini)
- ✅ Input & kelola Inspeksi
- ✅ Laporan (export PDF & Excel — data milik sendiri)

---

## 🧑‍💼 Officer B

| Field        | Value                       |
|--------------|-----------------------------|
| **Username** | `officer2`                  |
| **Password** | `password123`               |
| **Email**    | officer2@onetouch.test      |
| **Nama**     | Officer Inspeksi B          |
| **Redirect** | `/officer/dashboard`        |

---

## 👤 User 1 — PT. Bahari Makmur

| Field           | Value                       |
|-----------------|-----------------------------|
| **Username**    | `user`                      |
| **Password**    | `user123`               |
| **Email**       | user@onetouch.test          |
| **Perusahaan**  | PT. Bahari Makmur           |
| **Officer**     | Officer Inspeksi A (id: 2)  |
| **Redirect**    | `/user/dashboard`           |

**Akses User:**
- ✅ Lihat sertifikat milik sendiri
- ✅ Lihat inspeksi milik sendiri
- ✅ Download laporan milik sendiri (PDF & Excel)
- ❌ Tidak bisa input/edit data

---

## 👤 User 2 — KM. Samudra Jaya

| Field           | Value                       |
|-----------------|-----------------------------|
| **Username**    | `user2`                     |
| **Password**    | `password123`               |
| **Email**       | user2@onetouch.test         |
| **Perusahaan**  | KM. Samudra Jaya            |
| **Officer**     | Officer Inspeksi A (id: 2)  |
| **Redirect**    | `/user/dashboard`           |

---

## 🌐 Portal Publik (Tanpa Login)

Halaman berikut dapat diakses **tanpa login**:

| URL                         | Halaman        |
|-----------------------------|----------------|
| `/`                         | Beranda        |
| `/layanan`                  | Layanan        |
| `/skm`                      | SKM            |
| `/ekspor`                   | Data Ekspor    |
| `/media`                    | Media          |
| `/aplikasi`                 | Aplikasi       |
| `/regulasi`                 | Regulasi       |
| `/tentang-kami`             | Tentang Kami   |

---

## ⚠️ Catatan Keamanan

> **PENTING:** Ganti semua password sebelum deployment ke production!
>
> Password hash di database menggunakan **bcrypt** (Laravel `Hash::make()`).
> Untuk ganti password via Artisan Tinker:
> ```bash
> php artisan tinker
> \App\Models\User::where('username','admin')->update(['password' => bcrypt('PASSWORD_BARU')]);
> ```
