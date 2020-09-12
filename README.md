# Separate Excel

画像が貼り付けられたエクセルファイルを[cli-kintone](https://github.com/kintone/cli-kintone)がインポートできるCSVファイルと画像ファイルに分離します。

## 必須環境
- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/) >= 7.2
  - [PhpSpreadSheet extension](https://github.com/PHPOffice/PhpSpreadsheet/blob/master/composer.json)
    -  ext-ctype
    -  ext-dom
    -  ext-gd
    -  ext-iconv
    -  ext-fileinfo
    -  ext-libxml
    -  ext-mbstring
    -  ext-SimpleXML
    -  ext-xml
    -  ext-xmlreader
    -  ext-xmlwriter
    -  ext-zip
    -  ext-zlib

- Composer

## インストール
```sh
$ git clone git@github.com:ochi51/separator-excel.git
$ cd separator-excel
$ composer install
$ php ./bin/separator-excel
```

## 素早く始める

```sh
$ php ./bin/separator-excel filename.xlsx
```

## コマンド

### 実行ファイル
./bin/separator-excel

### 必須
- input  
   読み込むエクセルファイルのパス

### 任意
-  -o, --output=OUTPUT  
   出力するCSVファイルのパス[初期値: "./export.csv"]
- -b, --binary=BINARY  
   画像ファイルを出力するディレクトリのパス [default: "./_output"]
