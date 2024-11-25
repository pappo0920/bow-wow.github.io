<html>
<head>
<title>BOW-WOW</title>

<link rel="stylesheet" href="zubolog/zubolog.css">
<?php
//  include：ずぼログ本体を読み込む関数です。
//  現在ファイルからの相対パスを記述してください。
include('zubolog/_core.php');
$zubologApp = new zubolog();
?>



<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv="content-type" content="text/html; charset=shift_jis">
</head>

<body background="img/back.gif"
width="560px" height="493px" alt="背景">

<!-- ずぼログ　一覧出力　ここから -->
<ul class="zubolog zubolog_2 zubolog_md-3">
<?php

// 初期設定はじめ※※-----------------------------------------------

// 一覧表示したい画像が入っているフォルダの、現在ファイルからの相対パスを指定してください
// スラッシュなどの抜けにご注意ください
// 例　$zubolog_dir = ['images/logs/'];
// 例　$zubolog_dir = ['../images/logs/'];　←一つ階層が下にあるフォルダの場合
// 例　$zubolog_dir = ['logs/', 'old_logs/'];　←複数フォルダの画像を拾いたい場合は、半角コンマで区切ります
$zubolog_dir = ['img/'];

// １ページあたりに表示したいログ数を半角英数字で指定して下さい
// １ページ10件表示の場合は'10'、全件表示は'-1'です
$zubolog_perpage = '6';

// デフォルト（true）ではファイル名の降順（9→0、Z→A）でログが出力されます。
// 昇順（0→9、A→Z）でログを出力したい場合は$zubolog_sortの値をfalseに書き換えてください。
// マンガなど、ページを連番でファイル名につけている場合で、連番の通りに表示したい場合は「false」を指定します。
$zubolog_sort = true;

// 使用テンプレートファイルを変更する場合は、ファイル名を指定してください
$zubolog_temp = 'default.php';

// テンプレートで変数を利用する場合は設定してください。
// fuwaimgの展示グループ分けなどに利用できます
$zubolog_var = 'logs1';

// 初期設定おわり---------------------------------------------------

// ログを出力する関数です。
echo $zubologApp->createZubolog($zubolog_dir, $zubolog_perpage, $zubolog_sort, dirname(__FILE__), $zubolog_temp, $zubolog_var);

?>

</ul>

<!-- ずぼログ　一覧出力　ここまで -->

<!-- ずぼログ　ページネーション　ここから -->

<?php

// ずぼログ　ページネーションを出力する関数です。
// ページネーションが不要の場合は削除してください。
echo $zubologApp->createZubologPagenation($zubolog_dir, $zubolog_perpage, $zubolog_sort, dirname(__FILE__));

?>

<!-- ずぼログ　ページネーション　ここまで -->

</body>
</html>
