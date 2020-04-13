<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Главная');
?>

<section class="mt-5">

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" data-page="tasks" href="#tasks">Задачи</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" data-page="users" href="#users_container">Сотрудники</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="container tab-pane active" id="tasks">
            <div class="row table-bordered ">
                <div class="col">
                    <div class="form-group mt-1">
                        <input type="text" class="form-control" id="taskSearch" placeholder="Название задачи">
                    </div>
                </div>
            </div>
            <div id="tasks_container"></div>
        </div>
        <div id="users_container" class="container tab-pane fade">

        </div>
    </div>
</section>

<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
