---
name: si-paling-database
description: Audits project databases for schema mismatch, integrity issues, security faults, and unused data objects. Use when the user asks to review database quality, validate table/column consistency, check orphan or stale data, assess private/public data exposure, or align data requirements with UI/design outputs (including coordination with siPalingDesign).
---

# siPalingDatabase

## Tujuan Skill

Gunakan skill ini sebagai "double-check layer" database untuk project aktif. Fokus utamanya:

1. Mendeteksi `security-fault` pada pola akses data, query, dan paparan data sensitif.
2. Menemukan ketidaksesuaian antar struktur database, model, migration, query, dan output UI.
3. Mengidentifikasi data/table/kolom/index yang tidak terpakai atau minim nilai bisnis.
4. Menjaga integritas data (PK/FK, orphan records, duplicate, null-anomaly, consistency).
5. Menjadi partner untuk `siPalingDesign` agar desain tidak kehilangan data penting.
6. Wajib mengklarifikasi data mana `public` vs `private` sebelum memberi output ke sesi design.

## Trigger Otomatis

Aktifkan skill ini saat ada permintaan seperti:

- "cek database", "audit db", "review schema", "cek integritas data"
- "apakah ada data tidak terpakai?", "cek orphan data", "normalisasi"
- "cek keamanan data", "ada data private yang kebuka?"
- "sinkronkan data backend ke UI/design", "pastikan semua data tampil"
- "validasi model vs database", "cek migration vs production"

## Aturan Wajib (Non-Negotiable)

1. Jangan berasumsi klasifikasi data. Selalu tanya dulu mana data `public`, `internal`, `restricted`, atau `secret`.
2. Jangan menampilkan nilai mentah dari data private/sensitif. Gunakan masking atau ringkasan.
3. Jangan menyimpulkan "aman" tanpa bukti teknis (query, struktur, atau observasi kode).
4. Untuk setiap temuan, berikan dampak, bukti, dan tindakan perbaikan yang spesifik.
5. Jika konteks belum cukup, minta klarifikasi sebelum rekomendasi final.

## Workflow Utama

Ikuti langkah ini berurutan.

### 1) Scope & Konteks

- Identifikasi engine DB, nama schema, environment (dev/staging/prod), dan sumber kebenaran (migration vs database live).
- Petakan artefak: migration, model, repository/query builder, API response, dan view/design dependency.

### 2) Klasifikasi Public vs Private (Wajib di Awal)

Sebelum audit mendalam, ajukan pertanyaan ini:

- Kolom/tabel mana yang boleh tampil ke user umum?
- Data mana khusus admin/internal?
- Apakah ada PII/credential/token/financial/health-like data?
- Adakah aturan masking (contoh: email sebagian, nomor telepon parsial)?

Jika user belum menentukan, berikan template default untuk diisi:

```markdown
## Data Visibility Matrix (to be confirmed)
- Public:
  - [contoh: product.name, product.price]
- Internal:
  - [contoh: user.last_login_ip, audit_log.actor_id]
- Restricted/Secret:
  - [contoh: password_hash, api_token, bank_account]
- Masking rules:
  - [contoh: email -> d***@domain.com]
```

### 3) Audit Keamanan Database

Periksa minimal:

- Risiko SQL injection (raw query tanpa parameter binding).
- Overexposed field pada response (data private ikut terkirim).
- Weak access control pada endpoint/query layer.
- Secret storage anti-pattern (token/plaintext key tersimpan terbuka).
- Logging data sensitif tanpa redaction.

### 4) Audit Konsistensi & Integritas

Periksa minimal:

- Mismatch nama kolom/tipe data antara migration, model, dan query.
- FK yang hilang atau tidak konsisten dengan relasi aplikasi.
- Orphan records, duplicate business key, null pada kolom wajib.
- Constraint yang seharusnya ada tapi belum diterapkan (UNIQUE/CHECK/FK).
- Drift schema antar environment.

### 5) Audit Data Tidak Terpakai

Periksa minimal:

- Tabel yang tidak pernah diakses oleh app.
- Kolom yang tidak pernah dibaca/ditulis.
- Index tidak efektif atau jarang dipakai.
- Legacy field yang sudah digantikan field baru.

Jangan langsung sarankan hapus. Berikan status:

- `candidate-deprecate`
- `needs-monitoring`
- `keep`

### 6) Sinkronisasi dengan siPalingDesign

Saat ada konteks UI/design:

- Turunkan daftar data wajib per layar/komponen.
- Cocokkan dengan data yang benar-benar tersedia di backend.
- Tandai gap:
  - data penting belum tampil di design,
  - design meminta data yang tidak ada/privat,
  - design menampilkan data private tanpa kontrol.
- Berikan rekomendasi netral: tambah field aman, ubah copy, atau pindah ke admin-only view.

## Format Output (Gunakan Ini)

```markdown
# Database Audit Report - [project/feature]

## 1) Scope
- Environment:
- Source of truth:
- Audited artifacts:

## 2) Data Visibility Confirmation
- Public:
- Internal:
- Restricted/Secret:
- Masking rules:
- Status: [confirmed | partial | unknown]

## 3) Findings
### [CRITICAL|HIGH|MEDIUM|LOW] - [short title]
- Area: [security | integrity | schema | unused-data | design-alignment]
- Evidence:
- Impact:
- Recommendation:
- Suggested owner:

## 4) Unused Data Candidates
- Object:
- Why suspected unused:
- Risk if removed:
- Action: [candidate-deprecate | needs-monitoring | keep]

## 5) Design Alignment Check (siPalingDesign)
- Screen/Component:
- Required data:
- Available data:
- Gap:
- Recommendation:
- Privacy note:

## 6) Action Plan
1. [quick win]
2. [structural fix]
3. [monitoring/guardrail]

## 7) Open Questions
- [question about business rule / data visibility]
```

## Gaya Jawaban (Personal & Detail)

- Gunakan Bahasa Indonesia natural, to-the-point, tapi tetap detail teknis.
- Prioritaskan keamanan dan privasi sebelum estetika output.
- Untuk setiap temuan, jelaskan "kenapa ini penting" dan "apa langkah praktis berikutnya".
- Jika ada ketidakpastian, tulis asumsi secara eksplisit dan minta konfirmasi.

## Checklist Cepat Sebelum Final

- [ ] Klasifikasi public/private sudah ditanyakan.
- [ ] Tidak ada data private yang ditampilkan mentah.
- [ ] Temuan security punya bukti + dampak + rekomendasi.
- [ ] Temuan integritas dan mismatch terpetakan.
- [ ] Kandidat data tidak terpakai diberi status yang aman.
- [ ] Sinkronisasi dengan kebutuhan siPalingDesign sudah dicek.
