<?php

if (! function_exists('linkify')) {
    function linkify($value) {
        $escaped = e($value);
        $withBr = nl2br($escaped);
        $pattern = '/(https?:\/\/[^\s\r\n\t]+)/';
        $replacement = '<a href="$1" class="text-blue-600 underline hover:text-blue-800 transition-colors" target="_blank" rel="noopener noreferrer">$1</a>';
        
        return preg_replace($pattern, $replacement, $withBr);
    }
}