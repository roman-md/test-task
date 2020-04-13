<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
//new dBug($arParams['CANT_DELETE_USER_ID']);
//new dBug($arResult['CANT_DELETE_USER_ID']);
?>
<div class="table user">
    <div class="row table-bordered">
        <div class="col th">id</div>
        <div class="col th">Имя</div>
        <div class="col th">Должность</div>
        <div class="col th">Действия</div>
    </div>
    <?if ($arParams['CANT_DELETE_USER_ID']):?>
        <div class="row table-bordered">
            <div class="col td">
            Нельзя удалить пользователя <?= $arResult['USERS'][$arParams['CANT_DELETE_USER_ID']]['UF_USER_FIO']?>, есть задачи где он явлвется единственным исполнителем.
            </div>
        </div>
    <?endif;?>
    <?foreach ($arResult['USERS'] as $keyUser => $arUser):?>
        <div class="row table-bordered">
            <div class="col td">
                <?= $arUser['ID']?>
            </div>
            <div class="col td">
                <?= $arUser['UF_USER_FIO']?>
            </div>
            <div class="col td">
                <?= $arUser['UF_POSITION']?>
            </div>
            <div class="col td">
                <span class="remove-user h-btn" data-type-operation="delete" data-user-id="<?= $arUser['ID']?>">Удалить</span>
                /
                <span class="update-user user-button h-btn" data-name-operation="Изменение пользователя" data-type-operation="update" data-user-id="<?= $arUser['ID']?>" data-toggle="modal" data-target="#userModal">Редактировать</span>
            </div>
        </div>
    <?endforeach;?>
</div>
<button type="button" class="btn btn-success user-button" data-name-operation="Добавление задачи" data-type-operation="add" data-user-id="" data-toggle="modal" data-target="#userModal">Добавить пользователя</button>

<script>
    function getDataForUpdateUser(userId) {
        var updateUserData = <?= json_encode($arResult['USERS'])?>;
        return updateUserData[userId];
    }
</script>
