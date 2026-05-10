<?php

namespace Nank\Halaman\Blocks;

abstract class BlockType
{
    protected array $payload = [];

    abstract public function getName(): string;

    abstract public function getLabel(): string;

    abstract public function getDescription(): string;

    abstract public function render(): string;

    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): self
    {
        $this->payload = $payload;
        return $this;
    }

    public static function registry(): array
    {
        return [
            HeroBlock::class,
            TextBlock::class,
            ImageBlock::class,
            GalleryBlock::class,
            CtaBlock::class,
            FaqBlock::class,
            LatestPostsBlock::class,
            CustomHtmlBlock::class,
        ];
    }

    public static function find(string $type): ?BlockType
    {
        foreach (static::registry() as $blockClass) {
            $block = new $blockClass();
            if ($block->getName() === $type) {
                return $block;
            }
        }
        return null;
    }
}

class HeroBlock extends BlockType
{
    public function getName(): string { return 'hero'; }
    public function getLabel(): string { return 'Hero Section'; }
    public function getDescription(): string { return 'Large banner dengan judul, subtitle, dan CTA'; }

    public function render(): string
    {
        $title = $this->payload['title'] ?? 'Hero Title';
        $subtitle = $this->payload['subtitle'] ?? '';
        $image = $this->payload['image_url'] ?? '';
        $cta_text = $this->payload['cta_text'] ?? 'Pelajari Lebih Lanjut';
        $cta_url = $this->payload['cta_url'] ?? '#';

        return <<<HTML
        <section style="background-image: url({$image}); background-size: cover; background-position: center; min-height: 500px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
            <div style="background: rgba(0,0,0,0.5); padding: 3rem; border-radius: 8px;">
                <h2 style="font-size: 2.5rem; margin: 0 0 1rem 0;">{$title}</h2>
                <p style="font-size: 1.2rem; margin: 0 0 2rem 0;">{$subtitle}</p>
                <a href="{$cta_url}" style="display: inline-block; padding: 0.75rem 1.5rem; background-color: #3b82f6; color: white; text-decoration: none; border-radius: 4px;">{$cta_text}</a>
            </div>
        </section>
        HTML;
    }
}

class TextBlock extends BlockType
{
    public function getName(): string { return 'text'; }
    public function getLabel(): string { return 'Teks / Rich Text'; }
    public function getDescription(): string { return 'Blok teks dengan formatting'; }

    public function render(): string
    {
        $content = $this->payload['content'] ?? '';
        return "<div>{$content}</div>";
    }
}

class ImageBlock extends BlockType
{
    public function getName(): string { return 'image'; }
    public function getLabel(): string { return 'Gambar'; }
    public function getDescription(): string { return 'Single image dengan caption'; }

    public function render(): string
    {
        $image_url = $this->payload['image_url'] ?? '';
        $caption = $this->payload['caption'] ?? '';

        return <<<HTML
        <figure style="text-align: center; margin: 2rem 0;">
            <img src="{$image_url}" alt="{$caption}" style="max-width: 100%; height: auto; border-radius: 8px;">
            <figcaption style="margin-top: 1rem; color: #666; font-style: italic;">{$caption}</figcaption>
        </figure>
        HTML;
    }
}

class GalleryBlock extends BlockType
{
    public function getName(): string { return 'gallery'; }
    public function getLabel(): string { return 'Galeri'; }
    public function getDescription(): string { return 'Grid dari multiple gambar'; }

    public function render(): string
    {
        $images = $this->payload['images'] ?? [];
        $html = '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin: 2rem 0;">';

        foreach ($images as $img) {
            $url = $img['url'] ?? '';
            $alt = $img['alt'] ?? '';
            $html .= "<img src=\"{$url}\" alt=\"{$alt}\" style=\"width: 100%; height: 250px; object-fit: cover; border-radius: 8px;\">";
        }

        $html .= '</div>';
        return $html;
    }
}

class CtaBlock extends BlockType
{
    public function getName(): string { return 'cta'; }
    public function getLabel(): string { return 'Call-to-Action'; }
    public function getDescription(): string { return 'Highlighted CTA dengan background'; }

    public function render(): string
    {
        $title = $this->payload['title'] ?? 'Siap Memulai?';
        $description = $this->payload['description'] ?? '';
        $button_text = $this->payload['button_text'] ?? 'Hubungi Kami';
        $button_url = $this->payload['button_url'] ?? '#';
        $background_color = $this->payload['background_color'] ?? '#f0f9ff';

        return <<<HTML
        <section style="background-color: {$background_color}; padding: 3rem; border-radius: 8px; text-align: center; margin: 2rem 0;">
            <h3 style="font-size: 1.8rem; margin: 0 0 1rem 0;">{$title}</h3>
            <p style="margin: 0 0 2rem 0; color: #666;">{$description}</p>
            <a href="{$button_url}" style="display: inline-block; padding: 0.75rem 1.5rem; background-color: #3b82f6; color: white; text-decoration: none; border-radius: 4px;">{$button_text}</a>
        </section>
        HTML;
    }
}

class FaqBlock extends BlockType
{
    public function getName(): string { return 'faq'; }
    public function getLabel(): string { return 'FAQ Accordion'; }
    public function getDescription(): string { return 'Pertanyaan & jawaban accordion'; }

    public function render(): string
    {
        $items = $this->payload['items'] ?? [];
        $html = '<div style="margin: 2rem 0;">';

        foreach ($items as $i => $item) {
            $q = $item['question'] ?? '';
            $a = $item['answer'] ?? '';
            $id = "faq-{$i}";
            $html .= <<<HTML
            <details style="margin-bottom: 1rem; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 4px;">
                <summary style="cursor: pointer; font-weight: 600;">{$q}</summary>
                <p style="margin-top: 1rem; color: #666;">{$a}</p>
            </details>
            HTML;
        }

        $html .= '</div>';
        return $html;
    }
}

class LatestPostsBlock extends BlockType
{
    public function getName(): string { return 'latest_posts'; }
    public function getLabel(): string { return 'Latest Posts'; }
    public function getDescription(): string { return 'Latest posts dari modul-pustaka (jika tersedia)'; }

    public function render(): string
    {
        $limit = $this->payload['limit'] ?? 3;

        if (! class_exists('ModulPustaka\Pustaka\Models\Article')) {
            return '<p style="padding: 1rem; background: #fef3c7; border-radius: 4px; color: #92400e;">modul-pustaka tidak terinstall</p>';
        }

        try {
            $articles = \ModulPustaka\Pustaka\Models\Article::query()
                ->where('status', 'published')
                ->orderByDesc('published_at')
                ->limit($limit)
                ->get();

            $html = '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin: 2rem 0;">';

            foreach ($articles as $article) {
                $url = route('pustaka.article.show', $article->slug);
                $html .= <<<HTML
                <article style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                    <div style="padding: 1.5rem;">
                        <h4 style="margin: 0 0 0.5rem 0;"><a href="{$url}" style="color: #3b82f6; text-decoration: none;">{$article->title}</a></h4>
                        <p style="color: #999; font-size: 0.9rem; margin: 0.5rem 0;">{$article->published_at?->format('d M Y')}</p>
                        <p style="color: #666; margin: 1rem 0;">{$article->excerpt}</p>
                        <a href="{$url}" style="color: #3b82f6; text-decoration: none; font-weight: 600;">Baca selengkapnya →</a>
                    </div>
                </article>
                HTML;
            }

            $html .= '</div>';
            return $html;
        } catch (\Exception $e) {
            return '<p style="padding: 1rem; background: #fee2e2; border-radius: 4px; color: #991b1b;">Error loading posts</p>';
        }
    }
}

class CustomHtmlBlock extends BlockType
{
    public function getName(): string { return 'custom_html'; }
    public function getLabel(): string { return 'Custom HTML'; }
    public function getDescription(): string { return 'Custom HTML block (sanitized)'; }

    public function render(): string
    {
        $html = $this->payload['html'] ?? '';
        return $html; // dalam produksi, tambahkan sanitasi
    }
}
