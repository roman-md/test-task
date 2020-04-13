<?php

use \Bitrix\Main\Entity\Event,
    \Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler('', 'TasksOnAfterAdd', 'ChangeTasks');
$eventManager->addEventHandler('', 'TasksOnAfterUpdate', 'ChangeTasks');
$eventManager->addEventHandler('', 'TasksOnAfterDelete', 'ChangeTasks');

function ChangeTasks(Event $event)
{
    global $CACHE_MANAGER;
    $CACHE_MANAGER->ClearByTag('hlblock_tasks');
}

$eventManager->addEventHandler('', 'UsersOnAfterAdd', 'ChangeUsers');
$eventManager->addEventHandler('', 'UsersOnAfterUpdate', 'ChangeUsers');
$eventManager->addEventHandler('', 'UsersOnAfterDelete', 'ChangeUsers');

function ChangeUsers(Event $event)
{
    global $CACHE_MANAGER;
    $CACHE_MANAGER->ClearByTag('hlblock_users');
    $CACHE_MANAGER->ClearByTag('hlblock_tasks');
}
