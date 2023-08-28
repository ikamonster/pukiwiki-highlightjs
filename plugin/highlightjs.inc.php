<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
highlightjs.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

highlight.jsにより整形済みテキストをシンタックスハイライト（文法強調）表示するプラグイン。

対象とする整形済みテキストの直前に挿入すると、整形済みテキスト内のコードが強調表示されます。

【使い方】
#highlightjs([language])

【引数】
language … 言語名。省略すると自動判定。対応言語はhighlight.js公式サイトを参照

【使用例】
#highlightjs
 function hoge($v) {
     static $fuga = 'value:';
     echo $fuga . $v;
 }
*/

/////////////////////////////////////////////////
// シンタックスハイライトプラグイン（highlightjs.inc.php）
if (!defined('PLUGIN_HIGHLIGHTJS_SCRIPT_URL')) define('PLUGIN_HIGHLIGHTJS_SCRIPT_URL', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js');       // highlight.jsスクリプトのURL
if (!defined('PLUGIN_HIGHLIGHTJS_CSS_URL'))    define('PLUGIN_HIGHLIGHTJS_CSS_URL',    'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/default.min.css'); // highlight.js用CSSのURL。空なら内蔵スタイルを適用


function plugin_highlightjs_convert() {
	if (!PLUGIN_HIGHLIGHTJS_SCRIPT_URL || !PKWK_ALLOW_JAVASCRIPT) return '';

	list($lang) = func_get_args();
	$body = '';

	// 一度だけ実行
	static	$included = false;
	if (!$included) {
		// CSSロード
		if (PLUGIN_HIGHLIGHTJS_CSS_URL) {
			$body .= '<link rel="stylesheet" href="' . PLUGIN_HIGHLIGHTJS_CSS_URL . "\"/>\n";
		} else {
			// 指定がなければ内蔵スタイル
			$body .= <<<EOT
<style>
.hljs{}
.hljs,.hljs-subst{}
.hljs-comment{color:#7e8282}
.hljs-keyword,.hljs-attribute,.hljs-selector-tag,.hljs-meta-keyword,.hljs-doctag,.hljs-name{font-weight:bold}
.hljs-type,.hljs-string,.hljs-number,.hljs-selector-id,.hljs-selector-class,.hljs-quote,.hljs-template-tag,.hljs-deletion{color:#d86800}
.hljs-title,.hljs-section {color:#e70473;font-weight:bold}
.hljs-regexp,.hljs-symbol,.hljs-variable,.hljs-template-variable,.hljs-link,.hljs-selector-attr,.hljs-selector-pseudo{color:#dd3333}
.hljs-literal{color:#00c1c1}
.hljs-built_in,.hljs-bullet,.hljs-code,.hljs-addition{color:#33cc00}
.hljs-meta{color:#808080}
.hljs-meta-string{color:#808080}
.hljs-emphasis{font-style:italic}
.hljs-strong{font-weight:bold}
</style>
EOT;
		}

		// JavaScriptロード
		$body .= '<script src="' . PLUGIN_HIGHLIGHTJS_SCRIPT_URL . "\" defer></script>\n";

		// 初期化：本プラグイン出力要素（_p_highlightjsクラス）の隣のpre要素を強調表示の対象とする
		$body .= <<<EOT
<script>
'use strict';
document.addEventListener('DOMContentLoaded', (event) => {
	document.querySelectorAll('._p_highlightjs').forEach((block) => {
		var	ele = block.nextElementSibling;
		if (ele && ele.tagName == 'PRE') {
			var	lang = block.getAttribute('data-lang');
			if (lang) ele.classList.add(lang);
			ele.classList.add('_p_highlightjs_code');
			hljs.highlightBlock(ele);
		}
	});
});
</script>
EOT;

		$included = true;
	}

	$body .= '<span class="_p_highlightjs" style="display:none" data-lang="' . htmlsc(trim($lang)) . '"></span>';

	return $body;
}
