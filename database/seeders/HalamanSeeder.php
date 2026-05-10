<?php

namespace Org\Halaman\Database\Seeders;

use Illuminate\Database\Seeder;
use Org\Halaman\Models\Halaman;
use Org\Halaman\Models\PageSection;

class HalamanSeeder extends Seeder
{
    public function run(): void
    {
        // Home page with hero + CTA
        $homePage = Halaman::firstOrCreate([
            'slug' => 'beranda',
        ], [
            'title' => 'Beranda',
            'status' => 'published',
            'excerpt' => 'Halaman beranda website Anda',
            'content' => '<p>Selamat datang di website kami. Halaman ini adalah contoh dari page builder modul-halaman.</p>',
            'seo_title' => 'Beranda - Website Kami',
            'seo_description' => 'Halaman beranda website dengan fitur page builder yang fleksibel.',
            'published_at' => now(),
        ]);

        // Hero block for home
        PageSection::firstOrCreate([
            'page_id' => $homePage->id,
            'block_type' => 'hero',
            'sort_order' => 0,
        ], [
            'payload' => [
                'title' => 'Selamat Datang',
                'subtitle' => 'Website dengan page builder yang powerful',
                'image_url' => 'https://via.placeholder.com/1200x500',
                'cta_text' => 'Pelajari Lebih Lanjut',
                'cta_url' => '#tentang',
            ],
        ]);

        // Text block
        PageSection::firstOrCreate([
            'page_id' => $homePage->id,
            'block_type' => 'text',
            'sort_order' => 1,
        ], [
            'payload' => [
                'content' => '<h2>Tentang Kami</h2><p>Ini adalah contoh section teks yang dapat disesuaikan dengan konten dinamis atau statis sesuai kebutuhan.</p>',
            ],
        ]);

        // CTA block
        PageSection::firstOrCreate([
            'page_id' => $homePage->id,
            'block_type' => 'cta',
            'sort_order' => 2,
        ], [
            'payload' => [
                'title' => 'Siap Memulai?',
                'description' => 'Hubungi kami untuk informasi lebih lanjut',
                'button_text' => 'Hubungi Sekarang',
                'button_url' => 'mailto:info@example.com',
                'background_color' => '#dbeafe',
            ],
        ]);

        // About page
        $aboutPage = Halaman::firstOrCreate([
            'slug' => 'tentang-kami',
        ], [
            'title' => 'Tentang Kami',
            'status' => 'published',
            'excerpt' => 'Informasi tentang perusahaan kami',
            'seo_title' => 'Tentang Kami - Website Kami',
            'seo_description' => 'Pelajari lebih lanjut tentang perusahaan dan misi kami.',
            'published_at' => now(),
        ]);

        // About hero
        PageSection::firstOrCreate([
            'page_id' => $aboutPage->id,
            'block_type' => 'hero',
            'sort_order' => 0,
        ], [
            'payload' => [
                'title' => 'Tentang Kami',
                'subtitle' => 'Membangun solusi terbaik untuk bisnis Anda',
                'image_url' => 'https://via.placeholder.com/1200x500',
                'cta_text' => 'Lihat Portofolio',
                'cta_url' => '#portofolio',
            ],
        ]);

        // FAQ block
        PageSection::firstOrCreate([
            'page_id' => $aboutPage->id,
            'block_type' => 'faq',
            'sort_order' => 1,
        ], [
            'payload' => [
                'items' => [
                    [
                        'question' => 'Siapa kami?',
                        'answer' => 'Kami adalah tim profesional yang berdedikasi untuk memberikan solusi terbaik.',
                    ],
                    [
                        'question' => 'Berapa lama kami berdiri?',
                        'answer' => 'Kami telah melayani klien selama lebih dari 5 tahun dengan kepuasan tinggi.',
                    ],
                    [
                        'question' => 'Bagaimana cara menghubungi kami?',
                        'answer' => 'Anda dapat menghubungi kami melalui email info@example.com atau form contact.',
                    ],
                ],
            ],
        ]);

        // Contact page
        Halaman::firstOrCreate([
            'slug' => 'kontak',
        ], [
            'title' => 'Hubungi Kami',
            'status' => 'published',
            'excerpt' => 'Halaman kontak',
            'content' => '<p>Silakan gunakan form di bawah untuk menghubungi kami. Kami akan merespons dalam 24 jam.</p>',
            'seo_title' => 'Hubungi Kami - Website Kami',
            'published_at' => now(),
        ]);

        // Draft page sample
        Halaman::firstOrCreate([
            'slug' => 'halaman-draft-example',
        ], [
            'title' => 'Halaman Draft (Contoh)',
            'status' => 'draft',
            'excerpt' => 'Ini adalah contoh halaman dalam status draft',
            'content' => '<p>Halaman ini tidak akan muncul di publik sampai status diubah menjadi published.</p>',
        ]);
    }
}
