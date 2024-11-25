<?php

///////////////////////////////////////////////////
// 個人サイト向けイラスト作品管理プログラム　ずぼログ Ver1.2
// 製作者    ：ガタガタ
// サイト    ：https://do.gt-gt.org/
// ライセンス：MITライセンス
// 全文      ：https://ja.osdn.net/projects/opensource/wiki/licenses%2FMIT_license
// 公開日    ：2022.10.06
// 最終更新日：2023.05.31
// このプログラムはどなたでも無償で利用・複製・変更・
// 再配布および複製物を販売することができます。
// ただし、上記著作権表示ならびに同意意志を、
// このファイルから削除しないでください。
///////////////////////////////////////////////////

header('Content-Type: text/html; charset=UTF-8');
setlocale(LC_ALL, 'ja_JP.UTF-8');

$include = get_included_files();
if (array_shift($include) === __FILE__) {
    die('このファイルへの直接のアクセスは禁止されています。');
}

class zubolog {
    
    // コンストラクタ宣言
    public function __construct() {
        date_default_timezone_set('Asia/Tokyo');
        $this->today = date("Y/m/d");
        $this->time = date("H:i:s");
        
        include('_config.php');
        $this->thumbnail_name = $thumbnail_name;

        $options = ['options' => ['min_range' => 1]];
        if( isset($_GET["page"])) {
          $this->zubolog_page = $_GET["page"];
        } else {
          $this->zubolog_page = '1';
        }

        }

    // 指定されたディレクトリから画像ファイルを拾って適切な形にまとめる関数
    private function getZubologArray($dir, $perpage, $sort = true, $current) {
        // 単純なファイル名に変換
        $filenameArray = array();

        if(is_array($dir)) {
          foreach ($dir as $item) {
            $filenameArray = array_merge($filenameArray, $this->zubologCreateFileNameArray($item, $current));
          }

        } else {
          $filenameArray = $this->zubologCreateFileNameArray($dir, $current);
        }

        return $filenameArray;

    }

    // ログを出力する関数
    public function createZubolog($dir, $perpage, $sort = true, $current, $zubolog_temp, $zubolog_var = 'log_1') {

        $caption = '';
        $caption2 = '';
        $thumnailpass = '';

        $filenameArray = $this->getZubologArray($dir, $perpage, $sort, $current);
        foreach ($filenameArray as $key => $value) {
          $sortarr[$key] = $value[1];
        }
        
        if ($sort == true) {
          array_multisort($sortarr, SORT_DESC, $filenameArray);
        } else {
          array_multisort($sortarr, SORT_ASC, $filenameArray);
        }


          if (!array_key_exists(0, $filenameArray)) {
              return '指定したフォルダ内に画像データが見つかりません。<br>フォルダ指定が正しいかどうか確認してください。';
          } 
      
          if ($perpage < '-1') {
            echo '初期設定が間違っているようです。';
          } elseif (preg_match('/^0$|^-?[1-9][0-9]*$/', $perpage)){

            if ($perpage == '-1') {
              $perpage = count($filenameArray);
            }
      
            $zubolog_start = (($this->zubolog_page - 1 ) * $perpage);
            $zubolog_end = ($this->zubolog_page * $perpage);
      
            for ($i = $zubolog_start; $i < $zubolog_end; $i++) { 
              if(!key_exists($i, $filenameArray)) {
                continue;
              }
              
              $filepass = $filenameArray[$i][0] . $filenameArray[$i][1];

              // サムネイルがあるかどうかチェック

              // var_dump($filenameArray[$i]);

              $thumn_check = glob($filenameArray[$i][0] .  preg_replace('/filename/', pathinfo($filenameArray[$i][1], PATHINFO_FILENAME), $this->thumbnail_name) .'.*');

              if($thumn_check !== false && key_exists(0, $thumn_check)) {
                $thumnailpass = $thumn_check[0];
              } else {
                $thumnailpass = $filepass;
              }
              
              if(array_key_exists(2, $filenameArray[$i]) && $filenameArray[$i][2] !== null) {
                $caption = $filenameArray[$i][2];
              } else {
                $caption = '';
              }
              
              if(array_key_exists(3, $filenameArray[$i]) && $filenameArray[$i][3] !== null) {
                $caption2 = $filenameArray[$i][3];
              } else {
                $caption2 = '';
              }

              include('templates/'.$zubolog_temp);
              
            }

          } else {
            echo '初期設定が間違っているようです。';
          }

        }

        // ページネーションを出力する関数
        public function createZubologPagenation($dir, $perpage, $sort, $current) {
          // 全てを出力する設定であればここで処理を終わる
          if($perpage == '-1') {
            return;
          }
        $filenameArray = $this->getZubologArray($dir, $perpage,  $sort, $current);

        if (count($filenameArray) > $perpage) {
         $zubolog_lastpage = ceil(count($filenameArray) / $perpage);
    
        ?>
  
        <ul class="zubolog_pagination">
      
        <?php
  
        if ($this->zubolog_page > '1') {
          ?>
          <li class="zubolog_prev"><a href="?page=<?php echo $this->zubolog_page - 1; ?>">＜</a></li>
          <li><a href="?page=1">1</a></li>
          <?php
        } elseif ($this->zubolog_page = '1') {
          ?>
          <li class="current">1</li>
          <?php
        }
  
        if ($this->zubolog_page >= '1' && $this->zubolog_page <= $zubolog_lastpage) {
          for ($i=-2; $i < 3; $i++) { 
            $check = $this->zubolog_page + $i;
            if ($i === -2 && $check > '2') {
              ?>
              <li>…</li>
              <?php
            }
            if ($check >= 2 && $check <= $zubolog_lastpage - 1) {
              if ($i === 0) {
                ?>
                <li class="current"><?php echo $check; ?></li>
                <?php
              } else {
              ?>
              <li><a href="?page=<?php echo $check; ?>"><?php echo $check; ?></a></li>
              <?php
  
              }
            } 
            if ($i === 2 && $check < $zubolog_lastpage - 1) {
              ?>
              <li>…</li>
              <?php
            }
            if ($i === 0 && $this->zubolog_page === $zubolog_lastpage) {
              ?>
              <li class="current"><?php echo $zubolog_lastpage; ?></li>
              <?php
            }
          }
        }
  
        if ($this->zubolog_page < $zubolog_lastpage) {
          ?>
          <li><a href="?page=<?php echo $zubolog_lastpage; ?>"><?php echo $zubolog_lastpage; ?></a></li>
          <li class="zubolog_next"><a href="?page=<?php echo $this->zubolog_page + 1; ?>">＞</a></li>
          <?php
        } elseif ($this->zubolog_page == $zubolog_lastpage) {
          ?>
          <li class="current"><?php echo $zubolog_lastpage; ?></li>
          <?php
        }
  
        ?>
          
        </ul>
          <?php
      }
      
      }

      // caption.csvを拾う関数
      private function zubologGetCaption($dir, $current) {
        $csv = $current . '/'. $dir .'caption.csv';
        
        if(file_exists($csv)) {
          $fp = fopen($csv, "r");
          $csvArray = array();
    
          // CSVからデータを取得し二次元配列に変換する
          $row = 0;
          while( $ret_csv = fgetcsv( $fp, 0 ) ){
            for($col = 0; $col < count( $ret_csv ); $col++ ){
              $csvArray[$row][$col] = $ret_csv[$col];
            }
            $row++;
          }
          fclose($fp);

          return $csvArray;
        } else {
          return null;
        }
        
      }

      private function zubologCreateFileNameArray($dir, $current) {
        $ret = array();

        if($this->zubologGetCaption($dir, $current) !== null) {
          $captionArr = $this->zubologGetCaption($dir, $current);
        } else {
          $captionArr = null;
        }

        foreach(glob($current . '/'. $dir . '*') as $filepath) {
          $caption = '';
          $caption2 = '';
          $pregmatch = preg_replace('/filename/', '$1', $this->thumbnail_name);
            // 画像ファイルでなければ除外する
            if(!@exif_imagetype($filepath) || preg_match('{'.$pregmatch.'}', pathinfo($filepath, PATHINFO_FILENAME) )) {
                continue;
            }
            if($captionArr !== null) {
              foreach($captionArr as $captionItem) {
                if(pathinfo($filepath, PATHINFO_BASENAME) !== $captionItem[0]) {
                  continue;
                }
                if(key_exists(1, $captionItem)) {
                  $caption = $captionItem[1];
                }
                if(key_exists(2, $captionItem)) {
                  $caption2 = $captionItem[2];
                }
              }
            }
            $ret[] = array($dir, pathinfo($filepath)['basename'], $caption, $caption2);
        }
        return $ret;
      }
}

?>