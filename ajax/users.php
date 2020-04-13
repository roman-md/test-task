<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
//\CModule::IncludeModule("iblock");
//$apartment_id = Bitrix\Main\Application::getInstance()->getContext()->getRequest()->get('id');

$APPLICATION->IncludeComponent(
    "dev:users",
    "",
    Array(
        "HLBLOCK_USERS_ID" => 1,
        "HLBLOCK_TASKS_ID" => 2,
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A"
    )
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
