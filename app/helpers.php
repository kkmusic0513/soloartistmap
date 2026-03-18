<?php

if (! function_exists('linkify')) {
    function linkify($value) {
        // 1. まず全体をエスケープ（XSS対策）
        $escaped = e($value);

        // 2. URLを正規表現でリンクに置換
        // [^\s"<>]+ にすることで、タグの開始・終了記号をURLに含めないようにします
        $pattern = '/(https?:\/\/[^\s"<>]+)/';
        $replacement = '<a href="$1" class="text-blue-600 underline hover:text-blue-800 transition-colors" target="_blank" rel="noopener noreferrer">$1</a>';
        
        $linkified = preg_replace($pattern, $replacement, $escaped);

        // 3. 最後に改行を <br> に変換（これが重要！）
        return nl2br($linkified);
    }
}