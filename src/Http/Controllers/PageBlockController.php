<?php

namespace Nank\Halaman\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nank\Halaman\Models\Halaman;
use Nank\Halaman\Models\PageSection;
use Nank\Halaman\Services\BlockRenderer;

class PageBlockController extends Controller
{
    protected BlockRenderer $renderer;

    public function __construct(BlockRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function listBlockTypes()
    {
        return response()->json($this->renderer->getBlockTypes());
    }

    public function addBlock(Request $request, Halaman $halaman)
    {
        $validated = $request->validate([
            'block_type' => ['required', 'string'],
            'payload' => ['nullable', 'json'],
        ]);

        $maxSort = PageSection::where('page_id', $halaman->id)->max('sort_order') ?? -1;

        $section = PageSection::create([
            'page_id' => $halaman->id,
            'block_type' => $validated['block_type'],
            'sort_order' => $maxSort + 1,
            'payload' => $validated['payload'] ? json_decode($validated['payload'], true) : [],
        ]);

        return response()->json($section, 201);
    }

    public function updateBlock(Request $request, Halaman $halaman, PageSection $section)
    {
        abort_if($section->page_id !== $halaman->id, 404);

        $validated = $request->validate([
            'payload' => ['nullable', 'json'],
        ]);

        $section->update([
            'payload' => $validated['payload'] ? json_decode($validated['payload'], true) : $section->payload,
        ]);

        return response()->json($section);
    }

    public function deleteBlock(Halaman $halaman, PageSection $section)
    {
        abort_if($section->page_id !== $halaman->id, 404);

        $section->delete();

        return response()->json(null, 204);
    }

    public function reorderBlocks(Request $request, Halaman $halaman)
    {
        $validated = $request->validate([
            'block_ids' => ['required', 'array'],
            'block_ids.*' => ['integer'],
        ]);

        foreach ($validated['block_ids'] as $index => $blockId) {
            PageSection::where('id', $blockId)
                ->where('page_id', $halaman->id)
                ->update(['sort_order' => $index]);
        }

        return response()->json(['message' => 'Blocks reordered']);
    }
}
