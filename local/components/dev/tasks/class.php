<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\Loader,
    Bitrix\Main\Entity,
    Bitrix\Highloadblock as HL;


Loader::includeModule("highloadblock");

class Tasks extends CBitrixComponent
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

        switch ($arPostData['taskOperationType']){
            case 'delete':
                $this->deleteTask($arPostData['task_id']);
            break;
            case 'update':
                $this->updateTask($arPostData);
            break;
            case 'add':
                $this->addTask($arPostData);
            break;
            case 'search':
                $this->arParams['SEARCH_TASK_NAME'] = $arPostData['searchTaskName'];
            break;
        }

        if ($this->startResultCache(false, false)) {
            $CACHE_MANAGER->RegisterTag('hlblock_tasks');
            $this->GetResult();
            $this->includeComponentTemplate();
        }

    }


    /* Метод получает на вход Id элемента хл-блока задачи
     * Удаляет элемент хл-блока задачи
     * */
    protected function deleteTask($hlElementId)
    {
        $entityTasksClass = $this->getHlEntity(['ID' => $this->arParams['HLBLOCK_TASKS_ID']])->getDataClass();
        $entityTasksClass::Delete($hlElementId);
    }

    /* Метод получает на вход массив данных для обновления элемента хл-блока задачи
     * Обновляет элемент хл-блока задачи
     * Возвращает результат успеха операции
     * */
    protected function updateTask($arData)
    {
        $entityTasksClass = $this->getHlEntity(['ID' => $this->arParams['HLBLOCK_TASKS_ID']])->getDataClass();

        $data = [
            'UF_TASK_NAME' => $arData['taskName'],
            'UF_TASK_EXECUTOR' => $arData['taskExecutor'],
            'UF_TASK_STATUS' => $arData['taskStatus'],
            'UF_TASK_DESCRIPTION' => $arData['taskDescription']
        ];

        $result = $entityTasksClass::update($arData['taskId'], $data);

        return $result;
    }

    /* Метод получает на вход массив данных для создания элемента хл-блока задачи
     * Создает элемент хл-блока задачи
     * Возвращает Id нового элемента хл-блока задачи
     * */
    protected function addTask($arData)
    {
        $entityTasksClass = $this->getHlEntity(['ID' => $this->arParams['HLBLOCK_TASKS_ID']])->getDataClass();

        $data = [
            'UF_TASK_NAME' => $arData['taskName'],
            'UF_TASK_EXECUTOR' => $arData['taskExecutor'],
            'UF_TASK_STATUS' => $arData['taskStatus'],
            'UF_TASK_DESCRIPTION' => $arData['taskDescription']
        ];

        $result = $entityTasksClass::add($data);

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

        foreach ($arProperties as $arProp){
            $arPropertiesResult[$arProp['FIELD_NAME']] = $arProp;
        }
        unset($arProperties);

        return $arPropertiesResult;
    }

    protected function GetResult()
    {
        $taskFilter = [];
        $searchTaskName = $this->arParams['SEARCH_TASK_NAME'];
        if ($searchTaskName){
            $taskFilter = [
                'UF_TASK_NAME' => $searchTaskName
            ];
        }

        //Получение данных из hl-блока задачи
        $entityTasksClass = $this->getHlEntity(['ID' => $this->arParams['HLBLOCK_TASKS_ID']])->getDataClass();
        $resTasks = $entityTasksClass::getList([
            'select' => [
                'ID',
                'UF_TASK_NAME',
                'UF_TASK_EXECUTOR',
                'UF_TASK_STATUS',
                'UF_TASK_DESCRIPTION',
            ],
            'filter' => $taskFilter
        ]);

        while ($arTask = $resTasks->Fetch()){
            $arTasks['ITEMS'][$arTask['ID']] = $arTask;
        }

        //Получение свойств hl-блока задачи
        $arTasks['FIELDS'] = $this->getHlFields($this->arParams['HLBLOCK_TASKS_ID']);

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

        $this->arResult =[
            'TASKS'  => $arTasks,
            'USERS'  => $arUsers,
        ];

    }

}
