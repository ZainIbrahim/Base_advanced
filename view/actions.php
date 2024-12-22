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
                                Actions Management
                                <button class="btn btn-dark float-right" id="Insert">
                                <i class="icofont-plus-circle"></i>
                                Add
                            </button>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table class="table table-hover align-middle mb-0"  id="tbl" style="width:100%">
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
        </div>


        <div class="modal" id="mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Action Model</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="frm">
                        <div class="form-group">
                            <label for="name" class="control-label">Action Name:</label>
                            <input type="hidden" id="action_id" name="action_id">
                            <input type="hidden" id="session_id" name="session_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <select name="name" id="name" class=" form-control" title="Select User Name" required>
                            <option value="0">Please Select Action</option>
                            <option value="View">View</option>
                            <option value="Insert">Insert</option>
                            <option value="Update">Update</option>
                            <option value="Delete">Delete</option>
                            <option value="Print">Print</option>
                            <option value="PDF">PDF</option>
                            <option value="Excel" >Excel</option>   
                                    <option value=" Generate">Generate</option>
                        </select>
                        </div>
                        <div class="form-group">
                            <label for="sub_id" class="control-label">Page</label>
                            <select name="sub_id" id="sub_id" class=" form-control" title="Select SubMenus" required>

                        </select>
                        </div>
                        <div class="form-group">
                            <label for="date" class="control-label">Date</label>
                            <input type="date" id="date" name="date" class=" form-control" required value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="modal-footer">
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
<!-- <script src="../controllers/actions.js"></script> -->

<script type="module">
    import {intialize,Fill,checking_actions} from '../controllers/baseScript.js'
    var url = "../models/baseAPI"
    var prams = {
            'priv': 'AC000',
            'tbl': "actions",
            'proc_name': "usp_actions",
            'id': "",
            'name': "",
            'sub_id': "",
            'date': ""
        };

        intialize({
            url: url,
            data: prams
        })
    Fill({url:url,target:'sub_id',title:'Please Select Page',id:'sub_id'})


</script>

