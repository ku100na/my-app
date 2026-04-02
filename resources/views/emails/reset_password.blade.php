<x-mail::message>
# パスワードリセットのお知らせ

こんにちは、{{ $notifiable->name }} さん！

以下のボタンをクリックして、パスワードをリセットしてください。

<x-mail::button :url="$url" color="primary">
パスワードをリセット
</x-mail::button>

このリンクは60分間有効です。  
もしこのサービスへのアカウント登録に心当たりがない場合は、本メールは破棄してください。

{{ config('app.name') }}
</x-mail::message>
