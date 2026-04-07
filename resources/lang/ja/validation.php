<?php

return [
    'required' => ':attribute は必須です。',
    'email'    => ':attribute は有効なメールアドレスを入力してください。',
    'unique'   => 'すでに登録済みの:attribute です。',
    'confirmed'=> ':attributeと:attribute確認が一致しません。',
    'min'      => [
        'string' => ':attribute は:min文字以上で入力してください。',
    ],
    'max'                  => [
        'string' => ':attributeは:max文字以内で入力してください。',
        'file' => ':attributeは:maxKB以内にしてください。',
    ],
    'password' => [
        'letters' => ':attributeには少なくとも1文字の英字を含めてください。',
        'mixed'   => ':attributeには少なくとも1文字の大文字と1文字の小文字を含めてください。',
        'numbers' => ':attributeには少なくとも1つの数字を含めてください。',
        'symbols' => ':attributeには少なくとも1つの記号（!@#$%^&*など）を含めてください。',
        'uncompromised' => ':attributeは過去に流出したパスワードです。別のパスワードを使用してください。',
    ],
    'image' => ':attributeは画像ファイル（jpg, png など）を選択してください。',

    'current_password' => 'パスワードが正しくありません。',
    
    'attributes' => [
        'name'     => '名前',
        'email'    => 'メールアドレス',
        'password' => 'パスワード',
        'icon_image' => 'プロフィール画像', 
    ],
];