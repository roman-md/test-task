<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\Loader,
    Bitrix\Main\Entity,
    Bitrix\Highloadblock as HL;

Loader::includeModule("highloadblock");

class Users extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['HLBLOCK_TASKS_ID'] = (int) $arParams['HLBLOCK_TASKS_ID'];
        $arParams['HLBLOCK_USERS_ID'] = (int) $arParams['HLBLOCK_USERS_ID'];
        if (!$arParams['CACHE_TIME']){
            $arParams['CACHE_TIME'] = 36000000;
        } else {
            (int) $arParams['CACHE_TIME'];
        }
        return $arParams;
    }

    public function executeComponent()
    {
        global $CACHE_MANAGER;
        $arPostData = Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getPostList()->toArray();

        switch ($arPostData['userOperationType']){
            case 'delete':
                $this->deleteUser($arPostData['user_id']);
                break;
            case 'update':
                $this->updateUser($arPostData);
                break;
            case 'add':
                $this->addUser($arPostData);
                break;
        }

        if ($this->startResultCache(false,false)){

            $CACHE_MANAGER->RegisterTag('hlblock_users');
            $this->GetResult();
            $this->includeComponentTemplate();
        }

    }

    /* Метод получает на вход Id элемента хл-блока пользователи
     * Проверяет есть ли задачи, где пользователь является единственным исполнителем
     * Возвращает true или false
     * */
    protected function getUserTasks($userId)
    {
        $canDelete = true;

        $entityTasksClass = $this->getHlEntity(['ID' => $this->arParams['HLBLOCK_TASKS_ID']])->getDataClass();
        $resTask = $entityTasksClass::getList([
            'select' => [
                'UF_TASK_EXECUTOR'
            ],
            'filter' => [
                'UF_TASK_EXECUTOR' => $userId
            ],
            'cache' => [
                'ttl' => $this->arParams['CACHE_TIME']
            ]
        ]);
        while ($arTask = $resTask->Fetch()){
            if (count($arTask['UF_TASK_EXECUTOR']) == 1){
                $canDelete = false;
                break;
            }
        }

        return $canDelete;
    }

    /* Метод получает на вход Id элемента хл-блока пользователи
     * Удаляет элемент хл-блока пользователи
     * */
    protected function deleteUser($hlElementId)
    {


        $canDelete = $this->getUserTasks($hlElementId);

        if ($canDelete){
            $entityUserClass = $this->getHlEntity(['ID' => $this->arParams['HLBLOCK_USERS_ID']])->getDataClass();
            $entityUserClass::Delete($hlElementId);
        } else {
            $this->arParams['CANT_DELETE_USER_ID'] = $hlElementId;
        }
    }



    /* Метод получает на вход массив данных для обновления элемента хл-блока пользователи
     * Обновляет элемент хл-блока пользователи
     * Возвращает результат успеха операции
     * */
    protected function updateUser($arData)
    {
        $entityUserClass = $this->getHlEntity(['ID' => $this->arParams['HLBLOCK_USERS_ID']])->getDataClass();

        $data = [
            'UF_USER_FIO' => $arData['userName'],
            'UF_POSITION' => $arData['userPosition']
        ];

        $result = $entityUserClass::update($arData['userId'], $data);

        return $result;
    }

    /* Метод получает на вход массив данных для создания элемента хл-блока пользователи
     * Создает элемент хл-блока пользователи
     * Возвращает Id нового элемента хл-блока пользователи
     * */
    protected function addUser($arData)
    {
        $entityUserClass = $this->getHlEntity(['ID' => $this->arParams['HLBLOCK_USERS_ID']])->getDataClass();

        $data = [
            'UF_USER_FIO' => $arData['userName'],
            'UF_POSITION' => $arData['userPosition']
        ];

        $result = $entityUserClass::add($data);

        return $result;

    }

    /* Метод получает на вход ID или NAME hl-блока
     * Возвращает Id hl-блока
     * */
    protected function getHlId($arHlData)
    {
        if ($arHlData['ID']){
            $hlId = $arHlData['ID'];
        } elseif($arHlData['NAME']) {
            $arHlInfo = HL\HighloadBlockTable::getList([
                'filter' => [
                    'TABLE_NAME' => $arHlData['NAME']
                ]
            ])->fetch();
            if ($arHlInfo['ID']){
                $hlId = $arHlInfo['ID'];
            }
        }

        if (!$hlId){
            return false;
        }

        return $hlId;
    }

    /* Метод получает на вход ID или NAME hl-блока
     * Возвращает класс, для работы с данными
     * */
    protected function getHlEntity($arHlData)
    {
        $hlId = $this->getHlId($arHlData);

        if ($hlId){
            $hlblock = HL\HighloadBlockTable::getById($hlId)->fetch();
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);

            return $entity;
        }

        return false;
    }

    /* Метод получает на вход ID hl-блока
     * Возвращает массив свойств hl-блока
     * */
    protected function getHlFields($hlId)
    {
        $arProperties = [];
        $rsData = CUserTypeEntity::GetList(
            [],
            [
                'ENTITY_ID' => 'HLBLOCK_' . $hlId,
            ]
        );

        while($arRes = $rsData->GetNext()) {
            $arProperties[$arRes['ID']] = $arRes;
            if ($arRes['SETTINGS']['DISPLAY'] == ('CHECKBOX' || 'LIST')){
                $arPropertiesIDs[] = $arRes['ID'];
            }
        }

        $rsListProp = CUserFieldEnum::GetList(
            [],
            [
                'USER_FIELD_ID' => $arPropertiesIDs
            ]
        );

        while ($arListProp = $rsListProp->GetNext()){
            if ($arProperties[$arListProp['USER_FIELD_ID']]){
                $arProperties[$arListProp['USER_FIELD_ID']]['LIST_PROPERTIES'][$arListProp['ID']] = $arListProp;
            }
        }

        return $arProperties;
    }

    protected function GetResult()
    {
        //Получение данных из hl-блока пользователи
        $entityUsersClass = $this->getHlEntity(['ID' => $this->arParams['HLBLOCK_USERS_ID']])->getDataClass();
        $resUser = $entityUsersClass::getList([
            'select' => [
                'ID',
                'UF_USER_FIO',
                'UF_POSITION',
            ],
        ]);

        while ($arUser = $resUser->Fetch()){
            $arUsers[$arUser['ID']] = $arUser;
        }

        $this->arResult['USERS'] = $arUsers;
    }

}
