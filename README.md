# AutoPost-for-PDF-Image-Generator-
WordPressプラグイン「PDF Image Generato」に自動投稿機能を追加しました。

## 機能

* WordPressプラグイン「PDF Image Generato」はPDFをメディアにアップロードすると自動でサムネイル画像を生成するプラグインです。（リンクはこちら: https://ja.wordpress.org/plugins/pdf-image-generator/ ）
* この機能に加えて、ファイル名を判定し、合致した場合に自動的にPDFを掲載した記事を投稿できるようにしました。
* PDFファイルで規則的なファイル名で、継続的にニュース等を発行する場合、WordPressに投稿する際の作業が大きく削減できます。

## 使い方

プラグイン「PDF Image Generato」内に以下の内容を追加します。（振り分けるカテゴリーは別途作成してください）

1. 「function pigen_attachment」内にPDF自動投稿用関数呼び出し部分を追記
2. PDF自動投稿用関数「function pdf_auto_post」を追記
3. 判定すべきファイル名、振り分けるカテゴリーIDを変更
