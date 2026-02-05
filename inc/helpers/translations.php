<?php

/**
 * Get current language code (2 letters)
 */
function pt_get_current_lang(): string
{
    // 1) WPML
    if (function_exists('apply_filters') && has_filter('wpml_current_language')) {
        $lang = apply_filters('wpml_current_language', null);
        if (is_string($lang) && $lang !== '') {
            return strtolower($lang);
        }
    }

    // 2) WordPress locale (site/user)
    $locale = function_exists('determine_locale') ? determine_locale() : get_locale();

    if (is_string($locale) && $locale !== '') {
        // Examples: ru_RU, en_US, uk, uk_UA
        $short = strtolower(substr($locale, 0, 2));
        if (preg_match('~^[a-z]{2}$~', $short)) {
            return $short;
        }
    }

    // 3) Fallback
    return 'ru';
}

/**
 * Translate hair color
 *
 * @param string $color Hair color key (e.g. 'blonde', 'brunette', etc.)
 * @param string|null $lang Language code (auto-detect if null)
 * @return string Translated hair color
 */
function pt_translate_hair_color(string $color, ?string $lang = null): string
{
    if ($lang === null) {
        $lang = pt_get_current_lang();
    }

    // Normalize input (mb_strtolower for cyrillic support)
    $color_key = mb_strtolower(trim($color));

    // Translations: en, ru, uk, de, pt, es
    $translations = [
        'блондинка' => [
            'en' => 'Blonde',
            'ru' => 'Блондинка',
            'uk' => 'Блондинка',
            'de' => 'Blond',
            'pt' => 'Loira',
            'es' => 'Rubia',
        ],
        'брюнетка' => [
            'en' => 'Brunette',
            'ru' => 'Брюнетка',
            'uk' => 'Брюнетка',
            'de' => 'Brünett',
            'pt' => 'Morena',
            'es' => 'Morena',
        ],
        'рыжая' => [
            'en' => 'Redhead',
            'ru' => 'Рыжая',
            'uk' => 'Руда',
            'de' => 'Rothaarig',
            'pt' => 'Ruiva',
            'es' => 'Pelirroja',
        ],
        'русая' => [
            'en' => 'Light brown',
            'ru' => 'Русая',
            'uk' => 'Русява',
            'de' => 'Dunkelblond',
            'pt' => 'Castanho claro',
            'es' => 'Castaño claro',
        ],
        'шатенка' => [
            'en' => 'Brown-haired',
            'ru' => 'Шатенка',
            'uk' => 'Шатенка',
            'de' => 'Braunhaarig',
            'pt' => 'Castanha',
            'es' => 'Castaña',
        ],
    ];

    // Check if we have a translation
    if (isset($translations[$color_key][$lang])) {
        return $translations[$color_key][$lang];
    }

    // Fallback to English if available
    if (isset($translations[$color_key]['en'])) {
        return $translations[$color_key]['en'];
    }

    // Return original if no translation found
    return $color;
}
