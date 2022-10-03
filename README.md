# PukiWiki用プラグイン<br>シンタックスハイライト highlightjs.inc.php

[highlight.js](https://highlightjs.org/)により整形済みテキストをシンタックスハイライト（文法強調）表示する[PukiWiki](https://pukiwiki.osdn.jp/)用プラグイン。  
対象とする整形済みテキストの直前に挿入するだけの簡単仕様です。

|対象PukiWikiバージョン|対象PHPバージョン|
|:---:|:---:|
|PukiWiki 1.5.3 ~ 1.5.4 (UTF-8)|PHP 7.4 ~ 8.1|

## インストール

下記GitHubページからダウンロードした highlightjs.inc.php を PukiWiki の plugin ディレクトリに配置してください。

[https://github.com/ikamonster/pukiwiki-highlightjs](https://github.com/ikamonster/pukiwiki-highlightjs)

## 使い方

整形済みテキストの直前に次のように記述する。

```
#highlightjs([language])
```

language … 言語名。省略すると自動判定。対応言語は highlight.js 公式サイトを参照

## 使用例

```
#highlightjs
 function hoge($v) {
     static $fuga = 'value:';
     echo $fuga . $v;
 }
```

## 設定

ソース内の下記の定数で動作を制御することができます。

|定数名|値|既定値|意味|
|:---|:---:|:---|:---|
|PLUGIN_HIGHLIGHTJS_SCRIPT_URL| URL文字列|'//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/highlight.min.js'|highlight.js スクリプトのURL|
|PLUGIN_HIGHLIGHTJS_CSS_URL| URL文字列|'//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/styles/default.min.css'|highlight.js 用CSSのURL。空なら内蔵スタイルを適用|
