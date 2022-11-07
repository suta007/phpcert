<?php
return
    [
        'list' => [
            'sarabun' => [
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNewItalic.ttf',
                'B' => 'THSarabunNewBold.ttf',
                'BI' => 'THSarabunNewBoldItalic.ttf',
            ],
            'niramit' => [
                'R' => 'THNiramitAS.ttf',
                'I' => 'THNiramitASItalic.ttf',
                'B' => 'THNiramitASBold.ttf',
                'BI' => 'THNiramitASBoldItalic.ttf',
            ],

            'charmofau' => [
                'R' => 'THCharmofAU.ttf',
                'B' => 'THCharmofAU.ttf',
            ],
            'tokpokki' => [
                'R' => 'MNTokpokki.ttf',
                'I' => 'MNTokpokkiItalic.ttf',
                'B' => 'MNTokpokkiBold.ttf',
                'BI' => 'MNTokpokkiBoldItalic.ttf',
            ],
            'chanok' => [
                'R' => 'JSChanokNormal.ttf',
                'B' => 'JSChanokNormal.ttf',
            ],
            'wansika' => [
                'R' => 'JSWansikaItalic.ttf',
                'B' => 'JSWansikaItalic.ttf',
            ],
        ],
        'path' => [
            'public/fonts',
        ],
        'select' => [
            [
                'name' => 'TH Sarabun New',
                'value' => 'sarabun',
            ],
            [
                'name' => 'TH Niramit AS',
                'value' => 'niramit',
            ],
            [
                'name' => 'TH Charm Of AU',
                'value' => 'charmofau',
            ],
            [
                'name' => 'MN Tok Pok Ki',
                'value' => 'tokpokki',
            ],
            [
                'name' => 'JS Chanok',
                'value' => 'chanok',
            ],
            [
                'name' => 'JS Wansika',
                'value' => 'wansika',
            ],
        ],
    ];

/*
$obj = json_decode(json_encode(config("font.select")), false);
echo "<select name='' id=''>";
foreach ($obj as $item) {
echo "<option value='{$item->value}'>{$item->name}</option>";
}
echo "</select>";
 */
