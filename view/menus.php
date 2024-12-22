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
                            Menus Management
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
    </div>


    <div class="modal" id="mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Menus Model</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="frm">
                        <div class="form-group">
                            <label for="name" class="control-label">Menu Name:</label>
                            <input type="hidden" id="menu_id" name="menu_id">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group">
                            <label for="icon" class="control-label">Menu Icon:</label>
                            <input type="text" class="form-control" id="icon" name="icon" required>
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

    <?php

    include "footer.php";
    ?>
    <script type="module">
        import {
            intialize
        } from '../controllers/baseScript.js'
        var url = "../models/baseAPI"
        var prams = {
            'priv': 'M000',
            'tbl': "menus",
            'proc_name': "usp_menus",
            'id': "",
            'name': "",
            'icon': "",
            'date': ""
        };

        intialize({
            url: url,
            data: prams
        })
    </script>

    <!-- <script src="../controllers/menus.js"></script> -->