<?php

namespace Nank\Halaman\Services;

use Nank\Halaman\Models\PageSection;
use Nank\Halaman\Blocks\BlockType;

class BlockRenderer
{
    public function renderSection(PageSection $section): string
    {
        $blockClass = BlockType::find($section->block_type);

        if ($blockClass === null) {
            return '';
        }

        $blockClass->setPayload($section->payload ?? []);
        return $blockClass->render();
    }

    public function renderPageSections($halamanId): string
    {
        $sections = PageSection::query()
            ->where('page_id', $halamanId)
            ->orderBy('sort_order')
            ->get();

        $html = '';
        foreach ($sections as $section) {
            $html .= $this->renderSection($section) . "\n";
        }

        return $html;
    }

    public function getBlockTypes(): array
    {
        $types = [];
        foreach (BlockType::registry() as $blockClass) {
            $instance = new $blockClass();
            $types[] = [
                'name' => $instance->getName(),
                'label' => $instance->getLabel(),
                'description' => $instance->getDescription(),
            ];
        }
        return $types;
    }
}
