<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
    'GROUPS' => [],
	'PARAMETERS' => [
		'HLBLOCK_TASKS_ID' => [
			'PARENT' => 'BASE',
			'NAME' => GetMessage('HLBLOCK_TASKS_ID'),
			'TYPE' => 'STRING',
		],
		'HLBLOCK_USERS_ID' => [
			'PARENT' => 'BASE',
			'NAME' => GetMessage('HLBLOCK_USERS_ID'),
			'TYPE' => 'STRING',
		],
        'CACHE_TIME' => ['DEFAULT' => 36000000],
    ],
];
