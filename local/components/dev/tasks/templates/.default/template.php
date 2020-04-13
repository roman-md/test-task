<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>

<div class="table task">

    <div class="row table-bordered">
        <div class="col th">id</div>
        <div class="col th">Название</div>
        <div class="col th">Исполнитель</div>
        <div class="col th">Статус</div>
        <div class="col th">Описание</div>
        <div class="col th">Действия</div>
    </div>
    <?foreach ($arResult['TASKS']['ITEMS'] as $keyTask => $arTask):?>
        <div class="row table-bordered">
            <div class="col td">
                <?= $arTask['ID']?>
            </div>
            <div class="col td">
                <?= $arTask['UF_TASK_NAME']?>
            </div>
            <div class="col td">
                <?foreach ($arTask['UF_TASK_EXECUTOR'] as $executorKey => $executorId):?>
                    <?= $arResult['USERS'][$executorId]['UF_USER_FIO'] . ' '?>
                <?endforeach;?>
            </div>
            <div class="col td">
                <?= $arResult['TASKS']['FIELDS']['UF_TASK_STATUS']['LIST_PROPERTIES'][$arTask['UF_TASK_STATUS']]['VALUE']?>
            </div>
            <div class="col td">
                <?= $arTask['UF_TASK_DESCRIPTION']?>
            </div>
            <div class="col td">
                <span class="remove-task h-btn" data-type-operation="delete" data-task-id="<?= $arTask['ID']?>">Удалить</span>
                /
                <span class="update-task task-button h-btn" data-name-operation="Изменение задачи" data-type-operation="update" data-task-id="<?= $arTask['ID']?>" data-toggle="modal" data-target="#taskModal">Редактировать</span>
            </div>
        </div>
    <?endforeach;?>
</div>
<button type="button" class="btn btn-success task-button" data-name-operation="Добавление задачи" data-type-operation="add" data-task-id="" data-toggle="modal" data-target="#taskModal">Добавить задачу</button>

<script>
    function getDataForUpdateTask(taskId) {
        var updateTaskData = <?= json_encode($arResult['TASKS']['ITEMS'])?>;
        return updateTaskData[taskId];
    }
</script>
