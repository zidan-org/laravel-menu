/**
 * load loading
 */
$(document).ajaxStart(function () {
    $("#ajax_loader").show();
}).ajaxStop(function () {
    $("#ajax_loader").hide('slow');
});
/**
 * change label
 */
$(document).on('keyup', '.edit-menu-item-title' ,function(){
    var title = $(this).val();
    var index = $('.edit-menu-item-title').index($(this));
    $('.menu-item-title').eq(index).html(title);
});

function addCustomMenu() {
    $.ajax({
        data: {
            labelmenu: $('#form-create-item-menu input[name="label"]').val(),
            linkmenu: $('#form-create-item-menu input[name="url"]').val(),
            rolemenu: $('#form-create-item-menu select[name="role"]').val(),
            iconmenu: $('#form-create-item-menu input[name="icon"]').val(),
            idmenu: $('#idmenu').val()
        },
        url: addCustomMenur,
        type: 'POST',
        success: function (response) {
            window.location.reload();
        },
        complete: function () { }
    });
}

function updateItem(id = 0) {
    if (id) {
        var label = $('#idlabelmenu_' + id).val();
        var clases = $('#clases_menu_' + id).val();
        var url = $('#url_menu_' + id).val();
        var icon = $('#icon_menu_' + id).val();
        var role_id = 0;
        if ($('#role_menu_' + id).length) {
            role_id = $('#role_menu_' + id).val();
        }

        var data = {
            label: label,
            clases: clases,
            url: url,
            icon: icon,
            role_id: role_id,
            id: id
        };
    } else {
        var arr_data = [];
        $('.menu-item-settings').each(function (k, v) {
            var id = $(this)
                .find('.edit-menu-item-id')
                .val();
            var label = $(this)
                .find('.edit-menu-item-title')
                .val();
            var clases = $(this)
                .find('.edit-menu-item-classes')
                .val();
            var url = $(this)
                .find('.edit-menu-item-url')
                .val();
            var icon = $(this)
                .find('.edit-menu-item-icon')
                .val();
            var role = $(this)
                .find('.edit-menu-item-role')
                .val();
            arr_data.push({
                id: id,
                label: label,
                class: clases,
                link: url,
                icon: icon,
                role_id: role
            });
        });

        var data = {
            arraydata: arr_data
        };
    }
    $.ajax({
        data: data,
        url: updateItemr,
        type: 'POST',
        beforeSend: function (xhr) {
            if (id) { }
        },
        success: function (response) { },
        complete: function () {
            if (id) { }
        }
    });
}

function actualizarMenu(serialize) {
    $.ajax({
        dataType: 'json',
        data: {
            data: serialize,
            menuName: $('#menu-name').val(),
            idMenu: $('#idmenu').val()
        },
        url: generateMenuControlr,
        type: 'POST',
        success: function (response) {
            /**
             * update text option
             */
            $(`select[name="menu"] option[value="${$('#idmenu').val()}"]`).html($('#menu-name').val());
        }
    });
}

function deleteItem(id) {
    $.ajax({
        dataType: 'json',
        data: {
            id: id
        },
        url: deleteItemMenur,
        type: 'POST',
        success: function (response) {
            window.location = currentItem;
        }
    });
}

function deleteMenu() {
    var r = confirm('Do you want to delete this menu ?');
    if (r == true) {
        $.ajax({
            dataType: 'json',
            data: {
                id: $('#idmenu').val()
            },
            url: deleteMenugr,
            type: 'POST',
            success: function (response) {
                if (!response.error) {
                    alert(response.resp);
                    window.location = menuwr;
                } else {
                    alert(response.resp);
                }
            }
        });
    } else {
        return false;
    }
}

function createNewMenu() {
    if (!!$('#menu-name').val()) {
        $.ajax({
            dataType: 'json',
            data: {
                menuname: $('#menu-name').val()
            },
            url: createNewMenur,
            type: 'POST',
            success: function (response) {
                window.location = menuwr + '?menu=' + response.resp;
            }
        });
    } else {
        alert('Enter menu name!');
        $('#menu-name').focus();
        return false;
    }
}


$(document).ready(function () {
    if ($('#nestable').length) {
        $('#nestable').nestable({
            expandBtnHTML: '',
            collapseBtnHTML: '',
            callback: function (l, e) {
                updateItem();
                actualizarMenu(l.nestable('toArray'));
            }
        });
    }
});