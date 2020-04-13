<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//new dBug($arParams['CANT_DELETE_USER_ID']);
//new dBug($arResult['CANT_DELETE_USER_ID']);
?>

<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="userForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Добавление задачи</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="userOperationType" value="">
                    <input type="hidden" id="userId" value="">
                    <div class="form-group">
                        <label for="userName">Имя</label>
                        <input type="text" class="form-control" id="userName" required>
                    </div>
                    <div class="form-group">
                        <label for="userPosition">Должность</label>
                        <input type="text" class="form-control" id="userPosition" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                    <button type="button" class="btn btn-primary" id="userSave">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
