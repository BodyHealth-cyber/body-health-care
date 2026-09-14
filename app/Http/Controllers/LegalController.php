<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Lang;

class LegalController extends Controller
{
    private const SUPPORTED_LOCALES = ['uk', 'ru', 'en'];

    private const PAGE_MAP = [
        'terms-and-conditions' => 'terms',
        'refund-policy' => 'refund',
        'contact-information' => 'contact_information',
    ];

    private const LOCALE_LABEL_MAP = [
        'uk' => 'ukrainian_language',
        'ru' => 'russian_language',
        'en' => 'english_language',
    ];

    public function termsIndex()
    {
        return view('legal.terms-index', [
            'languageLinks' => $this->termsLanguageLinks(),
        ]);
    }

    public function termsVersion(string $locale)
    {
        if (!in_array($locale, self::SUPPORTED_LOCALES, true)) {
            abort(404);
        }

        return $this->renderDocument('terms', $locale);
    }

    public function show(string $slug)
    {
        $pageKey = self::PAGE_MAP[$slug] ?? null;

        if ($pageKey === null) {
            abort(404);
        }

        return $this->renderDocument($pageKey, app()->getLocale());
    }

    private function renderDocument(string $pageKey, string $documentLocale)
    {
        if (!in_array($documentLocale, self::SUPPORTED_LOCALES, true)) {
            $documentLocale = 'ru';
        }

        app()->setLocale($documentLocale);

        $document = Lang::get("legal.documents.{$pageKey}", [], $documentLocale);

        if (!is_array($document)) {
            abort(404);
        }

        $isDocumentAvailable = !empty($document['content_view'])
            || !empty($document['sections'])
            || !empty($document['details']);

        $documentLanguageKey = self::LOCALE_LABEL_MAP[$documentLocale] ?? self::LOCALE_LABEL_MAP['uk'];

        return view('legal.document', [
            'document' => $document,
            'documentLanguageLabel' => __("legal.common.{$documentLanguageKey}"),
            'isDocumentAvailable' => $isDocumentAvailable,
            'languageLinks' => $pageKey === 'terms' ? $this->termsLanguageLinks() : [],
            'ukrainianSwitchUrl' => route('locale.switch', ['locale' => 'uk']),
        ]);
    }

    private function termsLanguageLinks(): array
    {
        return [
            [
                'locale' => 'en',
                'label' => __('legal.common.english_language'),
                'url' => route('legal.terms.version', ['locale' => 'en']),
            ],
            [
                'locale' => 'uk',
                'label' => __('legal.common.ukrainian_language'),
                'url' => route('legal.terms.version', ['locale' => 'uk']),
            ],
            [
                'locale' => 'ru',
                'label' => __('legal.common.russian_language'),
                'url' => route('legal.terms.version', ['locale' => 'ru']),
            ],
        ];
    }
}
