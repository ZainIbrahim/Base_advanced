<?php

include "head.php";
include "sidebar.php";
include "header.php";
?>

    <!-- Body: Body -->
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h5 class="card-title mb-0">
                                Users Management
                                <button class="btn btn-dark float-right" id="Insert">
                                <i class="icofont-plus-circle"></i>
                                Add
                            </button>
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover align-middle mb-0" id="tbl" style="width:100%">
                                <thead>
                                  
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal" id="mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel1">Users Model</h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST" id="frm">
                                <div class="form-group">
                                    <label for="user_name" class="control-label">User Name:</label>
                                    <input type="hidden" id="user_id" name="user_id">
                                    <input type="hidden" id="session_id" name="session_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="hidden" id="type" name="type" value="<?php echo $_SESSION['user_type']; ?>">
                                    <input type="text" class="form-control" id="user_name" name="user_name" required placeholder="User Name">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required placeholder="Email">
                                </div>
                                <div class="form-group" id="row">

                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="emp" class="control-label">Full name:</label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" required placeholder="Full Name">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="user_status" class="control-label">User Status:</label>
                                            <select name="user_status" id="user_status" class=" form-control" title="Select User Status" required>
                                    <option value="0">Please Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="disabled">Disabled</option>
                                </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="type" class="control-label">User Status:</label>
                                            <select name="user_type" id="user_type" class=" form-control" title="Select User Type" required>

                                </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="date" class="control-label">Date</label>
                                    <input type="date" id="date" name="date" class=" form-control" required value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal" id="mdl_image" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update The Image.</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST" id="img_update_frm" enctype="multipart/form-data">
                                <input type="hidden" id="id" name="id">
                                <input type="file" id="file" name="file" class="dropify" required />


                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php

include "footer.php";
?>
                <!-- <script src="../controllers/users.js"></script> -->
                <script type="module">
    import {intialize,checking_actions,Mystoast,fetch_profile} from '../controllers/baseScript.js'
    var url = "../models/baseAPI.php"
    var update_action = ''
    var delete_action= ''
    var prams = {
            'priv': 'USR000',
            'tbl': "users",
            'proc_name': "usp_users",
            'id': "",
            'user_name': "",
            'email': "",
            'password': "",
            'full_name': "",
            'user_status': "",
            'user_type': "",
            'date': ""
        };

        intialize({
            url: url,
            load_func: "getUsers",
            data: prams
        })

        


    var type = $('#type').val();
    if (type == 'Admin') {
        var row = ` <option value="">Please Select Type</option>
        <option value="Admin">Admin</option>
        <option value="User">User</option>`;

        $('#user_type').html(row);
    } else {
        var row = ` <option value="">Please Select Type</option>
        <option value="User">User</option>`;
        $('#user_type').html(row);
    }

    $(document).on('click', "a.img", function(e) {
        e.preventDefault();
        $("#id").val($(this).attr('user_id'));
        $("#mdl_image").modal('show');
    });

    $("#Insert").on("click", function() {
        var row = `
        <div id ="pass">
        <label for="password" class="control-label">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
        </div>`
        $("#row").html(row)
    });

    //image update form.....
    $('#img_update_frm').on("submit", function(e) {
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
                    Mystoast(message, "success")
                    checking_actions(url,session_id, 'users');
                    fetch_profile();
                    $("#mdl_image").modal('hide');
                    document.getElementById('img_update_frm').reset();
                    $(".dropify-preview").css("display", "none");
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

</script>
