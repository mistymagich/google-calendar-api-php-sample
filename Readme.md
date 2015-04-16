# Google APIs Client Library for PHPとサービスアカウントを使ったカレンダーの追加・削除と共有ユーザーの追加・削除のサンプル

[Google APIs Client Library for PHP](https://github.com/google/google-api-php-client)と[サービスアカウント](https://developers.google.com/adwords/api/docs/guides/service-accounts)を使ったカレンダーの追加・削除とそのカレンダーに対する共有ユーザーの追加・削除のサンプルです。

## 事前準備

### GoogleAPIのためのサービスアカウントの作成

1. [Google Developers Console](https://console.developers.google.com/project)でプロジェクトを作成する
2. 作成したプロジェクトを選択して詳細ページへ遷移する
3. 「APIと認証」→「API」を選択し、「Calendar API」を選択もしくは検索フォームに入力して選択
4. 「APIを有効にする」を押下
5. 「APIと認証」→「認証情報」を選択し、「新しいクライアントIDを作成」を押下
6. 「サービスアカウント」を選択し、「クライアントIDを作成」を押下
7. 「クライアントID」・「メールアドレス」を控えておく
8. 「新しいP12キーを生成」を押下して、拡張子がp12のファイルを保存する
9. 7.の「クライアントID」・「メールアドレス」をsrc/fuel/app/config/google.phpの'client_id', 'mail_addr'に記述する
10. 8.のP12キーファイルをsrc/fuel/appにgoogle-client.p12という名前で保存する


## 動かし方

### 必要なもの

* [VirtualBox](https://www.virtualbox.org)
* [Vagrant](https://www.vagrantup.com)
* Vagrantプラグイン
	* [Vagrant Host Manager](https://github.com/smdahlen/vagrant-hostmanager)
	```
	  vagrant plugin install vagrant-hostmanager
	```

Composerを使って、Google APIs Client Library for PHPをダウンロードするためにcomposerが動く環境が必要です。

* [PHP](http://php.net/)
* [Composer](https://getcomposer.org/)


### 起動手順

1. vagrant up
2. cd src
3. composer update
4. ブラウザで、http://example.local/にアクセス
