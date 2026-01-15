<?php
declare(strict_types=1);

/**
 * Godyar CMS - Hotfix Prepend (safe, no output)
 *
 * Loaded via .user.ini (auto_prepend_file).
 * MUST NOT echo/print or send headers.
 *
 * Provides backward-compatible helpers required by legacy files.
 */

if (!defined('GDY_HOTFIX_PREPEND_LOADED')) {
    define('GDY_HOTFIX_PREPEND_LOADED', true);
}

if (function_exists('mb_internal_encoding')) {
    @mb_internal_encoding('UTF-8');
}

/**
 * Detect deprecated /e modifier patterns defensively.
 */
if (!function_exists('gdy__regex_has_eval_modifier')) {
    function gdy__regex_has_eval_modifier(string $pattern): bool
    {
        if (preg_match('/^(.)(?:\\.|(?!\1).)*\1([a-zA-Z]*)$/s', $pattern, $m)) {
            $mods = $m[2] ?? '';
            return strpos($mods, 'e') !== false;
        }
        return false;
    }
}

if (!function_exists('gdy_regex_replace')) {
    /**
     * Backward-compatible wrapper for preg_replace.
     *
     * @param string $pattern
     * @param string $replacement
     * @param mixed  $subject  string|array
     * @param int    $limit
     * @param int|null $count
     * @return mixed
     */
    function gdy_regex_replace(string $pattern, string $replacement, $subject, int $limit = -1, ?int &$count = null)
    {
        if (gdy__regex_has_eval_modifier($pattern)) {
            $count = 0;
            return $subject;
        }

        if ($count === null) {
            return preg_replace($pattern, $replacement, $subject, $limit);
        }

        return preg_replace($pattern, $replacement, $subject, $limit, $count);
    }
}

if (!function_exists('gdy_regex_replace_callback')) {
    /**
     * Backward-compatible wrapper for preg_replace_callback.
     *
     * @param string   $pattern
     * @param callable $callback
     * @param mixed    $subject string|array
     * @param int      $limit
     * @param int|null $count
     * @return mixed
     */
    function gdy_regex_replace_callback(string $pattern, callable $callback, $subject, int $limit = -1, ?int &$count = null)
    {
        if (gdy__regex_has_eval_modifier($pattern)) {
            $count = 0;
            return $subject;
        }

        if ($count === null) {
            return preg_replace_callback($pattern, $callback, $subject, $limit);
        }

        return preg_replace_callback($pattern, $callback, $subject, $limit, $count);
    }
}
