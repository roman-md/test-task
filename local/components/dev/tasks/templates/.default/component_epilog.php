<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?//new dBug($arResult)?>

<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="taskForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Добавление задачи</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="taskOperationType" value="">
                    <input type="hidden" id="taskId" value="">
                    <div class="form-group">
                        <label for="taskName">Название</label>
                        <input type="text" class="form-control" id="taskName" placeholder="Название задачи" required>
                    </div>
                    <div class="form-group">
                        <label for="taskExecutor">Исполнитель</label>
                        <select id="taskExecutor" class="form-control" multiple required>
                            <?foreach ($arResult['USERS'] as $keyUser => $arUser):?>
                                <option value="<?= $arUser['ID']?>"><?= $arUser['UF_USER_FIO']?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="taskStatus">Статус</label>
                        <select id="taskStatus" class="form-control">
                            <?foreach ($arResult['TASKS']['FIELDS']['UF_TASK_STATUS']['LIST_PROPERTIES'] as $keyStatus => $arStatus):?>
                                <option value="<?= $arStatus['ID']?>"><?= $arStatus['VALUE']?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="taskDescription">Описание</label>
                        <textarea class="form-control" id="taskDescription" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                    <button type="button" class="btn btn-primary" id="taskSave">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
