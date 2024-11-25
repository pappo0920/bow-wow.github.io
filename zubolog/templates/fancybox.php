<?php
// 画像１枚ごとに、ここに記述したHTMLに沿って出力されます。
// $filepass　は展示したい画像ファイルの相対パスです。
// $thumnailpass　はサムネイルとして見せる画像ファイルの相対パスです。
// $zubolog_var　は初期設定で入力した変数です
// $caption　は別途CSVファイルでキャプションを設定した場合に出力されるキャプションです
// 出力したいログ展示HTMLに併せてカスタマイズしてOKです。
?>

<li>
    <a href="<?php echo $filepass; ?>" data-fancybox="<?php echo $zubolog_var; ?>" data-caption="<?php echo $caption; ?>">
        <img src="<?php echo $thumnailpass; ?>">
    </a>

    <!-- 2つ目のキャプションを利用する場合　始まり -->
    <?php if($caption2 !== '') : ?>
    <div class="popup">
        <p>
            <?php echo $caption2; ?>
        </p>
    </div>
    <?php endif; ?>
    <!-- 2つ目のキャプションを利用する場合　終わり -->
</li>