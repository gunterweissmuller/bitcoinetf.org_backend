<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Public\Pages;

use App\Dto\Models\Pages\SectionDto;
use App\Enums\Pages\Languages\SlugEnum;
use App\Services\Api\V1\Pages\LanguageService;
use Illuminate\Http\JsonResponse;
use App\Enums\Pages\Pages\StatusEnum;
use Illuminate\Routing\Controller;
use App\Services\Api\V1\Pages\PageService;
use App\Services\Api\V1\Pages\SectionService;

final class PageController extends Controller
{
    public function __construct(
        private LanguageService $languageService,
        private PageService $pageService,
        private SectionService $sectionService
    ) {}

    public function get(string $slug, ?string $lang = null): JsonResponse
    {
        $languageId = SlugEnum::defaultId();

        if ($lang) {
            $languages = $this->languageService->list([]);

            foreach ($languages as $language) {
                if ($language->getSlug() === $lang) {
                    $languageId = $language->getId();
                }
            }
        }

        $page = $this->pageService->get([
            'slug' => $slug,
            'status' => StatusEnum::ACTIVE->value,
        ]);

        $sections = $page ? $this->sectionService->list([
            'page_id' => $page->getId(),
            'status' => StatusEnum::ACTIVE->value,
            'language_id' => $languageId,
        ])?->map(function (SectionDto $section) {
            return $section->toArray();
        }) : null;

        if (!$sections && SlugEnum::defaultId() !== $languageId) {
            $sections = $page ? $this->sectionService->list([
                'page_id' => $page->getId(),
                'status' => StatusEnum::ACTIVE->value,
                'language_id' => SlugEnum::defaultId(),
            ])?->map(function (SectionDto $section) {
                return $section->toArray();
            }) : null;
        }

        return response()->json([
            'page' => $page?->toArray(),
            'sections' => $sections,
        ]);
    }
}
