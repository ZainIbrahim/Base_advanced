var globalurl;
let link;

export let update_action = '';
export let delete_action = '';
var user_id = '';
let func_type = ''
let parameters;
export let actions = [];
export let prams = [];
export function get_link() {
    if (window.location.href.indexOf('View') != -1) {
        parameters = window.location.href.slice(window.location.href.indexOf('View') + 5);
        // .split('.')
        link = parameters;
        return parameters
    } else {
        return link;
    }

}

export function only_intialize(url, prams) {
    // checking path for this user
    globalurl = url
    prams = data
    get_link()

}

export function intialize({ url: url, load_func: load_func = "getData", data, frm_type: frm_type = 'dml' }) {
    // checking path for this user
    if (window.location.href.indexOf('view') != -1) {
        parameters = window.location.href.slice(window.location.href.indexOf('view') + 5);
        // .split('.')
        link = parameters;
        // this.link = parameters;
        globalurl = url
        func_type = load_func
        // console.log(data);
        prams = data
        get_link()
        checking_actions(url);

    }

    var btn_action = "INSERT";
    $("#Insert").on("click", function () {
        document.getElementById("frm").reset();
        btn_action = "INSERT"
        show_modal();
    });


    function show_modal() {
        $("#mdl").modal('show');
    }

    $(document).on('click', "a.Update", function (e) {
        e.preventDefault();
        var action_id = $(this).attr('id');
        btn_action = "UPDATE";
        show_modal();
        FetchData(url, action_id)

    });

    $(document).on('click', 'a.Delete', function (e) {
        e.preventDefault();
        var id = $(this).attr('id');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this " + link,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    del({ url: url,id: id });
                } else {
                    Mystoast("Your Data is Save", "info");
                }
            });
    });

    // form_submition
    $('#frm').on("submit", function (e) {
        e.preventDefault();
        var fd = new FormData($(this)[0])
        // console.log(fd)
        if (btn_action == "INSERT") {
            fd.append("action", "insert")
        } else { fd.append("action", "update") }
        fd.append('proc_name', prams['proc_name'])
        fd.append('tbl', prams['tbl'])
        // if(frm_type == 'loop');{
        //     fd.append('array_data',prams['array_data'])
        // }
        fd.append('priv', prams['priv'])
        fd.append('type', frm_type)
        // (btn_action == "INSERT") ? fd.append("action", "insert"): fd.append("action", "update");
        $.ajax({
            method: "POST",
            url: url,
            data: fd,
            dataType: "JSON",
            contentType: false,
            processData: false,
            complete: function (data) {

                var status = data.status;
                // console.log(data.status)
                var message = data.responseJSON.message;
                // console.log(message)
                if (status == 200) {
                    Mystoast(message, "success");
                    // console.log(link)
                    checking_actions(url);
                    $('#mdl').modal('hide')
                } else {
                    Mystoast(message, "error");
                }

            },
            error: function (data) {
                var message = data.responseJSON.message;
                $('#mdl').modal('hide')
                Mystoast(message, "error");
            }

        });



    });

}
// fill function
export function Fill({ url: url, target: target, title: title = 'Please Select', id: id = 'id', name: name = 'name', act_name: act_name = 'fill' }) {
    prams['type'] = act_name
    $.ajax({
        method: "POST",
        url: url,
        data: { "action": "fill", prams },
        dataType: "JSON",
        async: true,
        complete: function (data) {
            var status = data.status;
            // console.log(data.status)
            var options = '';
            var message = data.responseJSON.message;
            if (status == 200) {

                options += "<option value=''>" + title + "</option>";

                message.forEach(function (item, i) {

                    options += `<option value="` + item[id] + `"> ` + item[name] + `</option>`;

                });

                $("#" + target).html(options);
            } else {
                Mystoast(message, "error");
            }



        },
        error: function (data) {
            var message = data.responseJSON.message;
            Mystoast(message, "error");
        }
    });

}
//fetch function
export function FetchData(url, id) {
    prams['type'] = 'Fetch'
    prams['id'] = id
    $.ajax({
        method: "POST",
        url: url,
        data: { 'action': "fetch", prams },
        dataType: "JSON",
        async: true,
        complete: function (data) {

            var status = data.status;
            // console.log(data.status)
            var message = data.responseJSON.message[0];
            if (status == 200) {
                var len = Object.keys(message).length;
                for (var i = 0; i < len; i++) {
                    // console.log("#" + Object.keys(message)[i])
                    $("#" + Object.keys(message)[i]).val(message[Object.keys(message)[i]])
                }
            } else {
                Mystoast(message, "error");
            }

        },
        error: function (data) {
            var message = data.responseJSON.message;
            Mystoast(message, "error");
        }

    });

}
//delete function
export function del({ url, id } = {}) {
    prams['type'] = 'Delete'
    prams['id'] = id
    $.ajax({
        method: "POST",
        url: url,
        data: { 'action': 'del', prams },
        dataType: "JSON",
        async: true,
        complete: function (data) {
            var status = data.status;
            // console.log(data.status)
            var message = data.responseJSON.message;
            if (status == 200) {
                window.scroll(0, 0);
                Mystoast(message, "success");
                checking_actions(url);
                // $('#mdl').modal('hide')
            } else {
                Mystoast(message, "error");
            }

        },
        error: function (data) {
            var message = data.responseJSON.message;
            $('#mdl').modal('hide')
            Mystoast(message, "error");
        }

    });
}

export function getData(url, update_action, delete_action, type) {
    var loader = `<tr><td class=' text-center' colspan ='100%'><center class='mt-4'> <img src='../uploads/processing1.gif'  class='rounded-circle' width='150' /></center></td></tr> `;
    prams['type'] = 'Load'
    $.ajax({
        method: "POST",
        url: url,
        data: { 'action': "load", prams },
        dataType: "JSON",
        async: true,
        complete: function (data) {

            var status = data.status;

            if (status == 200) {
                var message = data.responseJSON.message;
                var check = (update_action == 'Update' || delete_action == "Delete") ? true : false;
                // alert(func_type)
                // console.log(message);
                if (func_type == 'getData') {
                    $("#tbl tbody").html(loader);
                    var row = '';
                    var col = "<tr>";
                    var index = ''
                    for (index in message[0]) {
                        col += `<td style="font-weight: bolder">` + index + `</td>`;
                    }
                    if (check == true) {
                        col += `<td style="font-weight: bolder">Action</td></tr>`;
                    }
                    message.forEach(function (item, i) {
                        // col = "<tr><td>" + Object.keys(item) + "</td></tr>";
                        row += "<tr>"
                        for (index in item) {
                            row += "<td>" + item[index] + "</td>";
                        }
                        if (update_action == "Update" && delete_action == "Delete") {
                            row += `<td>
                                        <a href="#" class=" btn btn-primary Update" id='` + item['ID'] + `' >
                                        <i class=" icofont-edit-alt"></i>
                                        </a>`;
                            row += `&nbsp`;
                            row += `<a href="#" class=" btn btn-danger Delete" id='` + item['ID'] + `' >
                                    <i class=" icofont-delete-alt"></i>
                                    </a>
                                    </td>`;
                        } else if (update_action == 'Update') {
                            row += `<td>
                                        <a href="#" class=" btn btn-primary Update" id='` + item['ID'] + `' >
                                        <i class=" icofont-edit-alt"></i>
                                        </a>
                                    </td>`;

                        } else if (delete_action == 'Delete') {
                            // console.log("delete " + delete_action);
                            row += `<td> 
                                        <a href="#" class=" btn btn-danger Delete" id='` + item['ID'] + `' >
                                        <i class=" icofont-delete-alt"></i>
                                        </a>
                                        </td>`;
                        } else {
                            $(".action").hide();
                        }
                        row += "</tr>";

                        // console.log(Object.keys(item));
                        $("#tbl tbody").html(row);
                        $("#tbl thead").html(col);
                    });


                    // console.log(col);
                    $("#tbl").DataTable().destroy();
                    $("#tbl thead").html(col);
                    $("#tbl tbody").html(row);
                    $('#tbl').DataTable({
                        responsive: true
                    });
                    $("#tbl").DataTable().draw();
                } else {
                    if (type == 'getUsers') {
                        getUsers(update_action, delete_action, message)
                    }
                }

            } else {
                row += "<tr><td class=' text-center' colspan ='100%'>Data Not Found </td></tr>";
                $("#tbl tbody").html(row);
            }

        },
        error: function (data) {

        }

    });

}


// checking actions for this user
export function checking_actions(url) {
    // console.log('user_id ' + user_id + ' link ' + link)
    var fields = {
        'proc_name': "usp_check_actions",
        'link': get_link(),
        'type': 'get_actions'
    };
    $.ajax({
        method: "POST",
        url: "../Models/baseApi",
        data: {
            "action": "fetch",
            "prams": fields,
        },
        dataType: "JSON",
        async: true,
        complete: function (data) {
            var status = data.status;
            var message = data.responseJSON.message;
            if (status == 200) {
                message.forEach(function (item, i) {
                    if (item['name'] == 'Update') {
                        update_action = item['name'];
                    } else if (item['name'] == 'Delete') {
                        delete_action = item['name'];

                    }
                });
                // console.log(Base.delete_action)
                // return [update_action, delete_action]
                getData(url, update_action, delete_action, func_type)



            } else {
                Mystoast(message, "error");
            }

        },
        error: function (data) {
            var message = data.responseJSON.message;
            Mystoast(message, "error");
        }
    });
}
export function Mystoast(message, type) {
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
export function getNav() {
    var fields = {
        'proc_name': "usp_select_nav",
        'type': 'get_nav'
    };
    $.ajax({
        method: "POST",
        url: "../Models/baseApi",
        data: {
            "action": "fetch",
            "prams": fields,
        },
        dataType: "JSON",
        async: true,
        complete: function (data) {

            var status = data.status;
            // console.log(data.status)
            var message = data.responseJSON.message;
            var li = '';
            var menu = '';
            if (status == 200) {
                message.forEach(function (item, i) {


                    if (menu != item['menu_name']) {
                        if (menu != '') {
                            li += `</ul></li>`;
                        }

                        li += `<li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#` + item['menu_name'] + `" href="` + item['menu_name'] + `">
                            <i class="` + item['icon'] + `"></i> <span>` + item['menu_name'] + `</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                            <ul class="sub-menu collapse" id="` + item['menu_name'] + `">`

                        // li += `<li class="sidebar-item">
                        // <a href="#` + item['menu_name'] + `" data-toggle="collapse" class="sidebar-link collapsed">
                        //     <i class="` + item['icon'] + ` "></i> <span class="align-middle">` + item['menu_name'] + `</span>
                        // </a>
                        // <ul id="` + item['menu_name'] + `" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">`;
                        menu = item['menu_name'];
                    }
                    li += `<li><a class="ms-link" href="` + item['link'] + `"><span>` + item['sub_menu_name'] + `</span></a></li>`;
                    // li += ` <li class="sidebar-item"><a class="sidebar-link" href="` + item['link'] + `">` + item['sub_menu_name'] + `</a>
                    // </li>`;

                });
                $("#sidbarnav").html(li);
            } else {
                Mystoast(message, "error");
            }

        },
        error: function (data) {
            var message = data.responseJSON.message;
            Mystoast(message, "error");
        }

    });

}

export function fetch_profile() {
    var curent_link = '';
    if (window.location.href.indexOf('view') != -1) {
        parameters = window.location.href.slice(window.location.href.indexOf('view') + 5);
        // .split('.')
        curent_link = parameters;
        // alert(curent_link)
        // this.link = parameters;
    }
    var fields = {
        'proc_name': "usp_check_actions",
        'link': '',
        'type': 'get_image'
    };
    $.ajax({
        method: "POST",
        url: "../Models/baseApi",
        data: {
            "action": "fetch",
            "prams": fields,
        },
        dataType: "JSON",
        async: true,
        complete: function (data) {

            var status = data.status;
            // console.log(data.status)
            var message = data.responseJSON.message[0];
            if (status == 200) {
                // $('#password').val(message['password']);
                $("#user_id").val(message['user_id']);
                var img = message['img_profile'];
                document.getElementById("img_prof").src = "../uploads/" + img;
                document.getElementById("img_header").src = "../uploads/" + img;

                if (curent_link == 'profile') {
                    document.getElementById("prof_image").src = "../uploads/" + img;
                }
                // Mystoast(message,"success")
            } else {
                Mystoast(message, "error");
            }

        },
        error: function (data) {
            var message = data.responseJSON.message;
            $('#mdl').modal('hide')
            Mystoast(message, "error");
        }

    });

}

export function profile_content() {

    $('#frm_edit_profile_content').on("submit", function (e) {
        e.preventDefault();
        var password = $('#password').val();
        var user_id = $("#id").val();

        var post = {
            'action': 'Update',
            'proc_name': 'usp_update_pass',
            'user_id': user_id,
            'password': password,
            "type": "dml"
        };
        swal({
            title: "Are you sure?",
            text: "To Change Your password!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "../Models/baseAPI",
                        method: "POST",
                        data: post,
                        dataType: "JSON",
                        async: true,
                        complete: function (data) {
                            var status = data.status;
                            var message = data.responseJSON.message;
                            if (status == 200) {
                                Mystoast(message, "success");
                                window.location.href = 'logout.php';
                                $("#frm_edit_profile_content")[0].reset();

                            } else {
                                Mystoast(message, "error");

                            }

                        },
                        error: function (data) {
                            Mystoast(data.message, "error")
                        }

                    });
                } else {
                    Mystoast("Your Pass is not changed", "info")
                }
            });


    });
    //image update form.....
    $('#img_update_frm').on("submit", function (e) {
        e.preventDefault();
        var fd = new FormData();
        var files = $('#file')[0].files[0];
        var user_id = $('#id').val();
        fd.append('file', files);
        fd.append('id', user_id);
        fd.append('action', 'img');

        $.ajax({
            url: '../Models/baseAPI',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            complete: function (data) {

                var status = data.status;
                // console.log(data.status)
                var message = data.responseJSON.message;
                if (status == 200) {
                    Mystoast(message, "success");
                    document.getElementById("img_update_frm")[0].reset;
                    $(".dropify-preview").css("display", "none");
                    fetch_profile();
                } else {
                    Mystoast(message, "error");
                }

            },
            error: function (data) {
                var message = data.responseJSON.message;
                $('#mdl').modal('hide')
                Mystoast(message, "error");
            }

        });

    });

}

export function login() {
    $('#user_name').on("keyup", function () {
        $(this).val($(this).val().replace(/[^A-z,0-9\.]+/g, ""));
    });
    $('#password').on("keyup", function () {
        $(this).val($(this).val().replace(/[^A-z,0-9\.]+/g, ""));
    })
    $("#frm_login").on("submit", function (e) {
        e.preventDefault();
        var user_name = $("#user_name").val();
        var password = $("#password").val();
        var data = {
            "action": "login",
            "user_name": user_name,
            "password": password

        };
        var user_type = $('#user_type').val();
        $.ajax({
            method: "POST",
            url: "../models/loginAPI",
            data: data,
            async: true,
            complete: function (data) {

                var status = data.status;
                // console.log(data.status)
                var message = data.responseJSON.message;
                if (status == 200) {
                    window.location = "../view/index";
                } else {
                    if (message == 'blocked') {
                        Mystoast("You are blocked user please contact the admin!", "error");
                    } else {
                        Mystoast(message, "error");
                    }

                }

            },
            error: function (data) {
                var message = data.responseJSON.message;
                $('#mdl').modal('hide')
                Mystoast(message, "error");
            }

        });

    });
}

export function sendmail() {
    var token = '';
    if (window.location.href.indexOf('?') != -1) {
        var parameters = window.location.href.slice(window.location.href.indexOf('?') + 1).split('=');
        token = parameters[1];
    }

    if (token != "" && token != undefined) {
        $("#login-box").hide();
        $("#reset-box").show();
    }
    $("#reset").on("click", function (e) {
        var pass = $("#pass").val();
        var confirm = $("#confirm").val();
        if (pass == "") {
            Mystoast("Please Enter password !", "error");
            return;
        } else if (confirm == "") {
            Mystoast("Please Confirm password !", "error");
            return;
        } else if (pass != confirm) {
            Mystoast("Password does not Match !", "error");
            return;
        } else {
            $.ajax({
                method: "POST",
                url: "../models/sendemailApi",
                data: {
                    'action': 'resetpassword',
                    'token': token,
                    'pass': pass
                },
                dataType: "JSON",
                async: true,
                complete: function (data) {

                    var status = data.status;
                    // console.log(data.status)
                    var message = data.responseJSON.message;
                    if (status == 200) {
                        Mystoast(message, "success");
                        $('#frm_reset')[0].reset()
                        window.location = "../view/auth-signin"
                    } else {
                        Mystoast(message, "error");
                    }

                },
                error: function (data) {
                    var message = data.responseJSON.message;
                    $('#mdl').modal('hide')
                    Mystoast(message, "error");
                }
            });
        }
    });
    $("#forget").on("click", function (e) {
        var to = $("#email").val();
        if (to == "") {
            Mystoast("Please Enter Email !", "error");
            return;
        }
        $("#load").addClass("fa fa-spinner fa-spin");
        document.getElementById("forget").disabled = true;
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "../models/sendemailApi",
            data: { 'action': 'requestforget', 'to': to },
            dataType: "JSON",
            async: true,
            complete: function (data) {

                var status = data.status;
                // console.log(data.status)
                var message = data.responseJSON.message;
                if (status == 200) {
                    $("#email").val("");
                    Mystoast(message, "success");
                    $("#load").removeClass("fa fa-spinner fa-spin");
                    document.getElementById("forget").disabled = false;
                } else {
                    Mystoast(message, "error");
                    $("#load").removeClass("fa fa-spinner fa-spin");
                    document.getElementById("forget").disabled = false;
                }

            },
            error: function (data) {
                var message = data.responseJSON.message;
                $("#load").removeClass("fa fa-spinner fa-spin");
                document.getElementById("forget").disabled = false;
                Mystoast(message, "error");
            }

        });



    });
}

export function check_link() {
    $('#print').hide();
    $('#export').hide();
    $('#Insert').hide();
    // getting current page link
    if (window.location.href.indexOf('view') != -1) {
        var parameters = window.location.href.slice(window.location.href.indexOf('view') + 5);
        var link = parameters;
        var user_id = $('#session_id').val();
        var fields = {
            'proc_name': "usp_check_actions",
            'link': link,
            'type': 'check_link'
        };
        $.ajax({
            method: "POST",
            url: "../Models/baseApi",
            data: {
                "action": "fetch",
                "prams": fields,
            },
            dataType: "JSON",
            async: true,
            complete: function (data) {

                var status = data.status;
                // console.log(data.status)
                var message = data.responseJSON.message;
                if (status == 200) {

                } else {
                    if (link == 'profile' || link == 'index') { } else {
                        // window.location = "../view/error_page";
                        // console.log("Worong usser");
                    }
                }

            },
            error: function (data) {
                var message = data.responseJSON.message;
                // Mystoast(message, "error");
            }
        });
        var check_fields = {
            'proc_name': "usp_check_actions",
            'link': link,
            'type': 'get_actions'
        };

        // checking actions for this user
        $.ajax({
            method: "POST",
            url: "../Models/baseApi",
            data: {
                "action": "fetch",
                "prams": check_fields,
            },
            dataType: "JSON",
            async: true,
            complete: function (data) {

                var status = data.status;
                // console.log(data.status)
                var message = data.responseJSON.message;
                if (status == 200) {
                    message.forEach(function (item, i) {
                        if (item['name'] == "Insert" || item['name'] == 'print' || item['name'] == 'export') {
                            var action = item['name'];
                            // var targeting = "$(#" + action + ")";
                            $('#' + action).toggle();

                        }


                    });
                } else {
                    // Mystoast(message, "error");
                }

            },
            error: function (data) {
                var message = data.responseJSON.message;
                // Mystoast(message, "error");

            }
        });


    }
}

function getUsers(update_action, delete_action, data) {


    var row = '';
    var col = "<tr>";;
    var message = data;
    var index = ''
    for (index in message[0]) {
        col += `<td style="font-weight: bolder">` + index + `</td>`;
    }
    col += `<td style="font-weight: bolder">Action</td></tr>`;
    message.forEach(function (item, i) {
        // col = "<tr><td>" + Object.keys(item) + "</td></tr>";
        row += "<tr>"
        for (index in item) {
            if (index == 'Status') {
                if (item['Status'] == 'active') {
                    row += "<td><span class='badge bg-success'>" + item[index] + "</span></td>";
                } else {
                    row += "<td><span class='badge bg-danger'>" + item[index] + "</span></td>";
                }
            } else if (index == 'type') {
                if (item['Type'] == 'Admin') {
                    row += "<td><span class='badge bg-success'>" + item[index] + "</span></td>";
                } else {
                    row += "<td><span class='badge bg-danger'>" + item[index] + "</span></td>";
                }
            } else if (index == 'Image') {
                var user_id = item['ID'];
                var image = '../uploads/' + item['Image'];

                row += `<td width='10%'>
                               
                                <a href="#" class="img" user_id='` + item['ID'] + `' >
                                <img src='` + image + `' class=' img-circle'  width="40%">
                                </a>
                                </td>`;

            } else {
                row += "<td>" + item[index] + "</td>";
            }



        }

        if (update_action == "Update" && delete_action == "Delete") {
            row += `<td>
                        <a href="#" class=" btn btn-primary Update" id='` + item['ID'] + `' >
                        <i class=" icofont-edit-alt"></i>
                        </a>`;
            row += `&nbsp`;
            row += `<a href="#" class=" btn btn-danger Delete" id='` + item['ID'] + `' >
                    <i class=" icofont-delete-alt"></i>
                    </a>
                    </td>`;
        } else if (update_action == 'Update') {
            row += `<td>
                        <a href="#" class=" btn btn-primary Update" id='` + item['ID'] + `' >
                        <i class=" icofont-edit-alt"></i>
                        </a>
                    </td>`;

        } else if (delete_action == 'Delete') {
            // console.log("delete " + delete_action);
            row += `<td> 
                        <a href="#" class=" btn btn-danger Delete" id='` + item['ID'] + `' >
                        <i class=" icofont-delete-alt"></i>
                        </a>
                        </td>`;
        } else {
            $(".action").hide();
        }

        row += "</tr>";

        // console.log(Object.keys(item));
        $("#tbl tbody").html(row);
        $("#tbl thead").html(col);
    });
    console.log(col);
    $("#tbl").DataTable().destroy();
    $("#tbl thead").html(col);
    $("#tbl tbody").html(row);
    $('#tbl').DataTable({
        responsive: true
    });
    $("#tbl").DataTable().draw();




}