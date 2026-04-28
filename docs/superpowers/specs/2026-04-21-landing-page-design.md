# Design Spec: Challora V2 Landing Page Enrichment

**Date:** 2026-04-21
**Topic:** Landing Page Enrichment (Split Personality Approach)
**Status:** Draft (Awaiting Approval)

## 1. Goal
Memperkaya konten landing page Challora V2 dengan detail fitur yang lebih mendalam serta estetika "Premium Brutalist" yang menggabungkan elemen 3D dan Retro Terminal.

## 2. Visual Language
- **Hero & General UI:** Neo-Brutalist 3D. Menggunakan `box-shadow` hitam solid (8-12px), border 4px, dan tipografi tebal (Poppins Black).
- **Technical/AI Sections:** Retro Terminal. Menggunakan font monospaced (Courier/Mono), efek scanline, dan aksen warna neon di atas latar belakang gelap.
- **Transisition:** Menggunakan gradasi atau elemen pembatas grid yang tegas untuk memisahkan antara bagian "Marketing" dan "Technical".

## 3. Section Roadmap
### Section 1: Hero (Neo-Brutalist 3D)
- **Content:** "RECRUITING WITHOUT THE GUESSWORK."
- **Visual:** Kartu 3D melayang dengan interaksi mouse (parallax/tilt).
- **CTA:** Tombol "Get Started" dengan efek klik 3D yang dalam.

### Section 2: Chally AI Scan Simulator (Retro Terminal)
- **Content:** Simulasi parsing CV secara real-time.
- **Visual:** Terminal hitam dengan teks hijau/orange yang bergerak cepat. Mengambil poin-poin dari resume fiktif (Skills, Experience, Matching Score).
- **Goal:** Menunjukkan kecanggihan teknologi parsing Chally AI.

### Section 3: Intelligence Radar (Mixed Style)
- **Content:** Radar Chart perbandingan kandidat.
- **Visual:** Grafik radar yang dianimasikan saat scroll, menunjukkan metrik kecocokan semantik.

### Section 4: Statistics Bento Grid (Neo-Brutalist 3D)
- **Content:** Angka-angka keberhasilan (Success Metrics).
- **Visual:** Bento box layout dengan angka yang menghitung naik (Counter).

### Section 5: Final CTA
- **Content:** Ajakan registrasi besar di bagian bawah.

## 4. Animation Plan (GSAP)
- **ScrollTrigger:** Section akan muncul dengan efek slide-in atau pop-up bertahap.
- **Hover Effects:** Semua elemen interaktif harus memberikan feedback visual (scale up, shadow shifting).
- **AI Terminal:** Loop animasi teks mengetik dan garis scanner.

## 5. Technical Requirements
- Framework: Laravel (Blade), TailwindCSS, GSAP.
- Assets: Asset grafis (ikon/ilustrasi) akan dibuat menggunakan CSS atau SVG brutalist untuk menjaga performa.
- Responsive: Desain harus beradaptasi menjadi single column yang rapi pada mobile.
