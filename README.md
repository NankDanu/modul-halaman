# modul-halaman

**CMS Page Builder Module untuk Ecosystem Awalan**

Module ini menyediakan sistem manajemen halaman statis dan dinamis dengan page builder sederhana berbasis block section.

## Fitur

- ✅ CRUD halaman admin dengan status (draft, published, scheduled, archived)
- ✅ Slug-based URL routing untuk halaman publik
- ✅ SEO fields per halaman (meta title, description, canonical URL)
- ✅ Page builder berbasis block section dengan 8 tipe block:
  - Hero section
  - Rich text / paragraf
  - Image single
  - Gallery
  - Call-to-Action (CTA)
  - FAQ accordion
  - Latest posts (integrasi opsional `modul-pustaka`)
  - Custom HTML
- ✅ Block reordering (drag-sort backend)
- ✅ Render publik pages by slug dengan fallback 404
- ✅ Seeder dengan contoh halaman dan blocks

## Instalasi

### 1. Copy package ke workspace

```bash
# Sudah tersedia di modul-halaman/
```

### 2. Register di project konsumen (awalan)

Edit `composer.json` project utama:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../modul-halaman"
        }
    ],
    "require": {
        "modul-halaman": "*"
    }
}
```

Lalu `composer install` atau `composer update`.

### 3. Publish & migrate

```bash
php artisan migrate
php artisan db:seed --class="Org\Halaman\Database\Seeders\HalamanSeeder"
```

### 4. Publish config & views (opsional)

```bash
php artisan vendor:publish --tag=halaman-config
php artisan vendor:publish --tag=halaman-views
```

## Penggunaan

### Admin

Akses menu **Halaman** di sidebar admin untuk:

1. **List halaman** — index, lihat status, publish date
2. **Buat halaman** — form judul, slug, status, excerpt, konten, SEO
3. **Edit halaman** — ubah konten, tambah/edit/hapus blocks, reorder blocks
4. **Preview** — lihat rendered halaman admin
5. **Publish** — ubah status ke "published" + set publish date

### Public Routes

Halaman publik otomatis accessible via slug:

```
GET /{slug}   → Render halaman jika published
```

Contoh:
- `GET /beranda` → Halaman "Beranda"
- `GET /tentang-kami` → Halaman "Tentang Kami"
- `GET /kontak` → Halaman "Kontak"

### Block Types

#### Hero Section

```json
{
  "title": "Welcome",
  "subtitle": "Subtitle text",
  "image_url": "https://...",
  "cta_text": "Learn More",
  "cta_url": "/about"
}
```

#### Rich Text

```json
{
  "content": "<h2>Heading</h2><p>Paragraph...</p>"
}
```

#### Image

```json
{
  "image_url": "https://...",
  "caption": "Image description"
}
```

#### Gallery

```json
{
  "images": [
    { "url": "https://...", "alt": "Image 1" },
    { "url": "https://...", "alt": "Image 2" }
  ]
}
```

#### CTA

```json
{
  "title": "Call to action",
  "description": "Description text",
  "button_text": "Click me",
  "button_url": "#",
  "background_color": "#f0f9ff"
}
```

#### FAQ

```json
{
  "items": [
    {
      "question": "Q1?",
      "answer": "A1"
    }
  ]
}
```

#### Latest Posts (requires modul-pustaka)

```json
{
  "limit": 3
}
```

#### Custom HTML

```json
{
  "html": "<div>Your custom HTML</div>"
}
```

## Route References

**Admin:**
- `GET /halaman` → halaman.index
- `GET /halaman/create` → halaman.create
- `POST /halaman` → halaman.store
- `GET /halaman/{id}` → halaman.show
- `GET /halaman/{id}/edit` → halaman.edit
- `PUT /halaman/{id}` → halaman.update
- `DELETE /halaman/{id}` → halaman.destroy

**Block Management:**
- `GET /halaman/blocks/types` → halaman.blocks.types
- `POST /halaman/{halaman}/blocks` → halaman.blocks.store
- `PUT /halaman/{halaman}/blocks/{section}` → halaman.blocks.update
- `DELETE /halaman/{halaman}/blocks/{section}` → halaman.blocks.destroy
- `POST /halaman/{halaman}/blocks/reorder` → halaman.blocks.reorder

**Public:**
- `GET /{slug}` → halaman.public.show

## Model & Tabel

### Halaman (mt_cms_pages)

| Field | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| title | string | Judul halaman |
| slug | string | URL-friendly, unique |
| status | string | draft, published, scheduled, archived |
| excerpt | text | Short description |
| content | longtext | Main content (WYSIWYG) |
| seo_title | string | Meta title |
| seo_description | string | Meta description (≤160 char) |
| seo_canonical_url | string | Canonical URL |
| published_at | timestamp | Publication date |
| created_at | timestamp | |
| updated_at | timestamp | |
| deleted_at | timestamp | Soft delete |

### PageSection (mt_cms_page_sections)

| Field | Type | Notes |
|---|---|---|
| id | bigint | Primary key |
| page_id | bigint | FK → mt_cms_pages |
| block_type | string | hero, text, image, gallery, cta, faq, latest_posts, custom_html |
| sort_order | int | 0, 1, 2, ... for ordering |
| payload | json | Block-specific data |
| created_at | timestamp | |
| updated_at | timestamp | |

## Config

File: `config/halaman.php`

```php
return [
    'routes' => [
        'admin_prefix' => 'halaman',  // Admin route prefix
    ],
    'public' => [
        'enabled' => true,  // Enable public slug routes
    ],
    'seo' => [
        'default_meta_title' => 'Halaman',
        'default_meta_description' => null,
    ],
    'blocks' => [
        'allowed' => [
            'hero',
            'text',
            'image',
            'gallery',
            'cta',
            'faq',
            'latest_posts',
            'custom_html',
        ],
    ],
];
```

## Integrasi Opsional: modul-pustaka

Jika `modul-pustaka` ter-install, block **Latest Posts** akan otomatis:

1. Query artikel published terbaru dari `ModulPustaka\Pustaka\Models\Article`
2. Render card artikel dengan title, excerpt, published date
3. Link ke halaman detail artikel via `route('pustaka.article.show', ...)`

Jika tidak ter-install, block akan menampilkan pesan "modul-pustaka tidak terinstall".

## Development

### Namespace

Package menggunakan PSR-4 namespace: `Org\Halaman\...`

### Struktur Folder

```
src/
├── Http/Controllers/
│   ├── HalamanController.php
│   └── PageBlockController.php
├── Models/
│   ├── Halaman.php
│   └── PageSection.php
├── Blocks/
│   └── BlockType.php
├── Services/
│   ├── PageRenderer.php
│   └── BlockRenderer.php
└── Providers/
    └── HalamanServiceProvider.php
```

### Add Custom Block

Buat class baru dalam `src/Blocks/BlockType.php` atau file terpisah:

```php
class MyCustomBlock extends BlockType
{
    public function getName(): string { return 'my_custom'; }
    public function getLabel(): string { return 'My Custom Block'; }
    public function getDescription(): string { return 'Custom block description'; }

    public function render(): string
    {
        $data = $this->payload;
        return "<div>Custom render: {$data['field']}</div>";
    }
}
```

Kemudian register di `BlockType::registry()`.

## License

Proprietary — untuk internal use only.
