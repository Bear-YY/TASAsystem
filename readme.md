# README

Detail : 九州産業大学 理工学部 情報科学科所属 18RS042

## 開発環境
- OS:Windows10 pro
- RAM:12GB

- XAMPP:Version 7.3.24
- PHP:Version 7.3.24
- Apache:2.4.46
- MariaDB(MySQL):10.4.16

## UIフレームワーク
- Boostrap:4.5
- Vue.js:2.6.14

## 推奨ブラウザ
- FifeFox
- chrome

## このシステムの使い方
環境は上記のものか、互換性があるものを使用してください。

使用したデータベースは以下にある。
- tasa-matching-2021.localhost/tasa2021backup.sql
  - ダミー用の教員、科目、学生、学生の成績は入ってる。
- tasa-matching-2021.localhost/tasa2021backup used.sql
  - ダミー用に加えて、募集、応募、推薦についても一部データが入ってる。

新しいデータベースを作成して、phpMyadminやコマンドなどからインポート(読み込ませて)してから使用してください。
データベースの詳細やシステムの概要は論文にて説明している。

1. zipでgithubからDownload
2. xamppを使っている場合はhtdocsに解凍したファイルをおく
3. 任意のブラウザで開く。
4. phpのソースコードが```tasa-matching-2021.localhost/src```にある。

ソースコードが複雑かつ、汚いのが多いと思います・・・。
