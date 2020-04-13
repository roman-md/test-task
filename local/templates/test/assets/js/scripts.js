$( document ).ready(function() {

    var ajaxPage = $('.nav-link.active').attr('data-page'),
        ajaxData = {},
        sendForm = true;

    $('.nav-link.active').ready(function() {
        getAjaxPage(ajaxPage, ajaxData);
    });

    $('.nav-link').click(function() {
        ajaxPage = $(this).attr('data-page');
        getAjaxPage(ajaxPage, ajaxData);
    });

    function validateForm(formId) {
        sendForm = true;
        $(formId).find ('input, textarea, select').each(function() {
            if (this.required && $(this).val() == ''){
                $(this).addClass("notValidInput");
                $(this).removeClass("validInput");
                sendForm = false;
            } else {
                $(this).addClass("validInput");
                $(this).removeClass("notValidInput");
            }
        });
    }


    function setEventsTasks() {

        $('.remove-task').click(function() {
            ajaxData = {
                'taskOperationType' : $(this).attr('data-type-operation'),
                'task_id' : $(this).attr('data-task-id')
            };
            getAjaxPage(ajaxPage, ajaxData);
        });

        $('.task-button').click(function() {
            var typeOperation = $(this).attr('data-type-operation'),
                nameOperation = $(this).attr('data-name-operation'),
                taskId = $(this).attr('data-task-id'),
                updateData = {};
            $('#taskModalLabel').html(nameOperation);
            $('#taskOperationType').val(typeOperation);
            $('#taskId').val(taskId);

            if (typeOperation == 'update'){
                updateData = getDataForUpdateTask(taskId);
                $('#taskName').val(updateData['UF_TASK_NAME']);
                $('#taskExecutor').val(updateData['UF_TASK_EXECUTOR']);
                $('#taskStatus').val(updateData['UF_TASK_STATUS']);
                $('#taskDescription').val(updateData['UF_TASK_DESCRIPTION']);
            }
        });

        $('#taskSave').click(function() {
            $(this).removeAttr('data-dismiss');
            validateForm('#taskForm');

            $('#taskForm').find ('input, textarea, select').each(function() {
                ajaxData[this.id] = $(this).val();
                if (this.required && $(this).val() == ''){
                    sendForm = false;
                }
            });
            if (sendForm){
                getAjaxPage(ajaxPage, ajaxData);
                $(this).attr('data-dismiss', 'modal');
            }
        });

        $("#taskSearch").on('change', function(e) {
            ajaxData = {
                'taskOperationType' : 'search',
                'searchTaskName'    : $(this).val()
            };
            getAjaxPage(ajaxPage, ajaxData);
        });
    }
    
    function setEventsUsers() {

        $('.remove-user').click(function() {
            ajaxData = {
                'userOperationType' : $(this).attr('data-type-operation'),
                'user_id' : $(this).attr('data-user-id')
            };
            getAjaxPage(ajaxPage, ajaxData);
        });

        $('#userSave').click(function() {
            $(this).removeAttr('data-dismiss');
            validateForm('#userForm');

            $('#userForm').find ('input, textarea, select').each(function() {
                ajaxData[this.id] = $(this).val();
                if (this.required && $(this).val() == ''){
                    sendForm = false;
                }
            });
            if (sendForm){
                getAjaxPage(ajaxPage, ajaxData);
                $(this).attr('data-dismiss', 'modal');
            }
        });

        $('.user-button').click(function() {
            var typeOperation = $(this).attr('data-type-operation'),
                nameOperation = $(this).attr('data-name-operation'),
                userId = $(this).attr('data-user-id'),
                updateData = {};
            $('#userModalLabel').html(nameOperation);
            $('#userOperationType').val(typeOperation);
            $('#userId').val(userId);

            if (typeOperation == 'update'){
                updateData = getDataForUpdateUser(userId);
                $('#userName').val(updateData['UF_USER_FIO']);
                $('#userPosition').val(updateData['UF_POSITION']);
            }
        });

    }

    function getAjaxPage(page, data) {
        $.ajax({
            type: "POST",
            url: "/ajax/" + page + ".php",
            data: data,
            success: function(html){
                $("#" + page + "_container").html(html);
                if (page == 'tasks'){
                    setEventsTasks();
                }
                if (page == 'users'){
                    setEventsUsers();
                }
            }
        });
        ajaxData = {};
    }

});
