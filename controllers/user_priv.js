$(document).ready(function() {
    load();
    fill();
    var check = [];
    document.getElementById("submit").disabled = true;
    $("#user_id").on("change", function() {
        var user_id = $(this).val();
        if (user_id == 0) {
            Mystoast("Oops ! Please Select User To Grant", "error");
            document.getElementById("submit").disabled = true;
            $("input[type='checkbox']").prop("checked", false);
            return;
        } else {
            document.getElementById("submit").disabled = false;
            fetch(user_id);
        }

    });

    $("#tbl").on('change', "input[name='actions[]']", function() {
        console.log("clicked");
        check = []
        if ($(this).is(":checked")) {
            var sub_menus = $(this).attr("sub_menu");
            $("input[type='checkbox'][name='sub_menus[]'][value='" + sub_menus + "']").prop('checked', true);
        }

        $("input[name='actions[]']").each(function() {
            if ($(this).is(":checked")) {
                check.push($(this).val());
            }
        });
        if (check.length == 0) {
            var sub_menus = $(this).attr("sub_menu");
            $("input[type='checkbox'][name='sub_menus[]'][value='" + sub_menus + "']").prop('checked', false);
        }
    });
    $("#tbl").on('change', "input[name='sub_menus[]']", function() {
        var sub_menus = '';
        if ($(this).is(":checked")) {
            sub_menus = $(this).val();
            console.log(sub_menus);
            $("input[name='actions[]']").each(function() {
                if (($(this).attr('sub_menu') == sub_menus)) {
                    $(this).prop("checked", true);
                } else {
                    return;
                }
            });
        } else if ($(this).prop('checked', false)) {
            sub_menus = $(this).val();
            console.log(sub_menus);
            $("input[name='actions[]']").each(function() {
                if (($(this).attr('sub_menu') == sub_menus)) {
                    $(this).prop("checked", false);
                } else {
                    return;
                }
            });
        }

    });

    // form submittion
    $("#frm").on("submit", function(e) {
        e.preventDefault();
        var sub_menus = [];
        var menus = [];
        var actions = [];
        var user_id = $("#user_id").val();
        $("input[name='actions[]']").each(function() {
            if ($(this).is(":checked")) {
                menus.push($(this).attr("menus"));
                sub_menus.push($(this).attr("sub_menu"));
                actions.push($(this).val());
            }

        });
        var data = {
            'action': 'insert',
            'user_id': user_id,
            'menus': menus,
            'sub_menus': sub_menus,
            'actions': actions

        };
        $.ajax({
            method: "POST",
            url: "../models/user_privAPI.php",
            data: data,
            dataType: "JSON",
            complete: function(data) {
                var status = data.status;
                // console.log(data.status)
                var message = data.responseJSON.message;
                if (status == 200) {
                    Mystoast(message, "success");
                    document.getElementById("submit").disabled = true;
                    $("input[type='checkbox']").prop("checked", false);
                    $("#user_id").val(0);
                    location.reload();
                    document.body.scrollTop = document.documentElement.scrollTop = 0;
                } else {
                    Mystoast(message, "error");
                }

            },
            error: function(data) {
                var message = data.responseJSON.message;
                $('#mdl').modal('hide')
                Mystoast(message, "error");
            }

        });


    });



    //Load Priv function
    function load() {
        $("#tbl tr").remove();

        $.ajax({
            method: "POST",
            url: "../models/user_privAPI.php",
            data: { 'action': "load" },
            dataType: "JSON",
            async: true,
            complete: function(data) {
                var status = data.status;
                // console.log(data.status)
                var message = data.responseJSON.message;
                var tr = '';
                var menu_type = '';
                sub_menu = '';
                if (status == 200) {

                    message.forEach(function(item, i) {
                        if (menu_type != item['menu_name']) {
                            tr += `<tr  " style="background-color: #484c7f;color: white; font-weight:600; border-top: 0.3px solid #dad4d4;">`;
                            tr += `<td> <i class="` + item['icon'] + `" style="color: white; "></i> &nbsp;&nbsp;
                            <label style="color: white; ">` + item['menu_name'] + `</label>
                            </td>`;

                            menu_type = item['menu_name'];

                        }
                        if (sub_menu != item['sub_menu_name']) {
                            tr += `<tr class=" mt-3" style="margin-left: 100px;">`;

                            tr += `<td>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <input type="checkbox"  name="sub_menus[]" id="` + item['sub_id'] + `" value="` + item['sub_id'] + `"  menu_id="` + item['menu_id'] + `">
                            <label  for="check">` + item['sub_menu_name'] + `</label>
                       
                        </td>`;
                            sub_menu = item['sub_menu_name'];
                        }
                        // actions
                        tr += `<tr class=" mt-3" style="margin-left: 100px;">`;

                        tr += `<td>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <input type="checkbox"   id="` + item['action_id'] + `" value="` + item['action_id'] + `" name="actions[]"  sub_menu="` + item['sub_id'] + `" menus="` + item['menu_id'] + `">
                            <label class="text-primary"  for="check">` + item['name'] + `</label>
                       
                        </td>`;

                    });
                    $("#tbl tbody").append(tr);
                } else {
                    Mystoast(message, "error");
                }

            },
            error: function(data) {
                var message = data.responseJSON.message;
                $('#mdl').modal('hide')
                Mystoast(message, "error");
            }
        });

    }


    //fill function
    function fill() {
        $.ajax({
            method: "POST",
            url: "../models/user_privAPI.php",
            data: { 'action': "fill" },
            dataType: "JSON",
            async: true,
            complete: function(data) {
                var status = data.status;
                // console.log(data.status)
                var option = '';
                var message = data.responseJSON.message;
                if (status == 200) {
                    option += "<option value='0'>" + "Please Choose  User To Grant/Revoke Priviledge " + "</option>";
                    message.forEach(function(item, i) {
                        option += `<option value="` + item['user_id'] + `">` + item['user_name'] + `</option>`;
                    });
                    $('#user_id').html(option);
                } else {
                    Mystoast(message, "error");
                }

            },
            error: function(data) {
                var message = data.responseJSON.message;
                $('#mdl').modal('hide')
                Mystoast(message, "error");
            }

        });

    }

    // fetch method
    function fetch(user_id) {

        $.ajax({
            method: "POST",
            url: "../models/user_privAPI.php",
            data: { "action": "fetch_actions", "user_id": user_id },
            dataType: "JSON",
            async: true,
            complete: function(data) {
                var status = data.status;
                // console.log(data.status)
                var message = data.responseJSON.message;
                $("input[type='checkbox']").prop('checked', false);
                if (status == 200) {
                    message.forEach(function(item, i) {
                        $("input[type='checkbox'][name='menus[]'][value='" + item['menu_id'] + "']").prop('checked', true);
                        $("input[type='checkbox'][name='sub_menus[]'][value='" + item['sub_id'] + "']").prop('checked', true);
                        $("input[type='checkbox'][name='actions[]'][value='" + item['action_id'] + "']").prop('checked', true);
                    });
                } else {
                    Mystoast(message, "error");
                }

            },
            error: function(data) {
                var message = data.responseJSON.message;
                $('#mdl').modal('hide')
                Mystoast(message, "error");
            }
        });

    }
    // toaster
    function Mystoast(message, type) {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "100",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "show",
            "hideMethod": "hide"
        };
        if (type == "success")
            toastr.success(message);
        else if (type == "error")
            toastr.error(message);
        else if (type == "warning")
            toastr.warning(message);
        else if (type == "info")
            toastr.info(message);
    }

});