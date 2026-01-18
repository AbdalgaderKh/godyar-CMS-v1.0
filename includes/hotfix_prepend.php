<?php
declare(strict_types=1);

/**
 * Godyar CMS - Hotfix Prepend (MUST be silent)
 * Loaded via auto_prepend_file from .user.ini
 * - Do not echo/print
 * - Do not send headers
 */

if (!defined('GDY_HOTFIX_PREPEND_LOADED')) {
    define('GDY_HOTFIX_PREPEND_LOADED', true);
}

if (function_exists('mb_internal_encoding')) {
    @mb_internal_encoding('UTF-8');
}

/**
 * Minimal safe wrappers needed by legacy code.
 * Implemented as direct calls. We explicitly guard against the deprecated /e
 * modifier to avoid any string-eval behavior.
 */
if (!function_exists('gdy_regex_replace')) {
    function gdy_regex_replace(string $pattern, string $replacement, $subject, int $limit = -1, ?int &$count = null)
    {
        // Defensive: ignore deprecated eval modifier if ever present
        if (is_string($pattern) && preg_match('/^(.)(?:\\\\.|(?!\1).)*\1([a-zA-Z]*)$/s', $pattern, $m)) {
            $mods = $m[2] ?? '';
            if (strpos($mods, 'e') !== false) {
                $count = 0;
                return $subject;
            }
        }

        if ($count === null) {
            return preg_replace($pattern, $replacement, $subject, $limit);
        }
        return preg_replace($pattern, $replacement, $subject, $limit, $count);
    }
}

if (!function_exists('gdy_regex_replace_callback')) {
    function gdy_regex_replace_callback(string $pattern, callable $callback, $subject, int $limit = -1, ?int &$count = null)
    {
        if (is_string($pattern) && preg_match('/^(.)(?:\\\\.|(?!\1).)*\1([a-zA-Z]*)$/s', $pattern, $m)) {
            $mods = $m[2] ?? '';
            if (strpos($mods, 'e') !== false) {
                $count = 0;
                return $subject;
            }
        }

        if ($count === null) {
            return preg_replace_callback($pattern, $callback, $subject, $limit);
        }
        return preg_replace_callback($pattern, $callback, $subject, $limit, $count);
    }
}
