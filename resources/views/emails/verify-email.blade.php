<x-mail::message>
# メールアドレスの確認

こんにちは、{{ $notifiable->name }} さん！

以下のボタンをクリックして、メールアドレスを確認してください。

<x-mail::button :url="$url" color="primary">
メール確認
</x-mail::button>

このリンクは60分間有効です。  
もしこのサービスへのアカウント登録に心当たりがない場合は、本メールは破棄してください。

{{ config('app.name') }}
</x-mail::message>