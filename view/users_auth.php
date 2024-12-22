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
                                Users Privillage
                            </button>
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" id="frm">
                                <div class="form-group mb-5">
                                    <input type="hidden" id="session_id" name="session_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <div class="col-md-6">
                                        <select class=" form-control" id="user_id" name="user_id" required title="Select User">

                                </select>
                                    </div>
                                </div>


                                <div class=" table table-responsive table-borderless">
                                    <table class="table" id="tbl">
                                        <thead>


                                        </thead>

                                        <tbody>
                                      


                                        </tbody>
                                    </table>

                                </div>
                                <div class="card-footer">
                                    <div class="col-md-4">
                                        <button type="submit" id="submit" name="submit" class=" form-control btn btn-primary">Grant Priviledge</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


      
    </div>

    <?php

    include "footer.php";
?>
<script src="../controllers/user_priv.js"></script>