<?php
return [
    'locations'=>[
        //те локации в которые сохраняются бекапы
        'input'=>[
            'input1'=>'C:\backups\the-brain',
            'input2'=> 'D:\kostya\backups\the-brain',
            'mega'=>"D:\kostya\Память\PRIVATE\TheBrainBackups",
            'google'=>"D:\kostya\Google Диск\PRIVATE\TheBrainBackups",
        ],
        //те локации из которых беруться бекапы
        'output'=>[
            'the-brain'=>[
                'path'=>'D:\kostya\Desktop\TheBrainBackups',
                'sync'=>['input1','input2','mega','google'],
            ]
        ]
    ],
    'logger'=>[
        'rootLogger'=>[
            'appenders'=>['default']
        ],
        'appenders'=>[
            'default'=>[
                'class'=>'LoggerAppenderRollingFile',
                'layout'=>[
                    'class'=>'LoggerLayoutSimple'
                ],
                'params'=>[
                    'file'=>'./logs/file.log',
                    'maxFileSize' => '5MB',
                    'maxBackupIndex' => 50,
                ]
            ]
        ]
    ]
];
