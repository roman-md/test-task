<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
    "dev:tasks",
    "",
    Array(
        "HLBLOCK_TASKS_ID" => 2,
        "HLBLOCK_USERS_ID" => 1,
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A"
    )
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
