<?php

include "head.php";
include "sidebar.php";
include "header.php";
?>

    <!-- Body: Body -->
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body text-center p-5">
                        <input type="hidden" id="session_id" value="<?php echo $_SESSION['user_id'];?>">
                        <img src="../assets/images/no-data.svg" class="img-fluid mx-size" alt="No Data">
                        <div class="mt-4 mb-2">
                            <span class="text-muted">No data to show</span>
                        </div>
                        <button type="button" class="btn btn-white border lift mt-1">Get Started</button>
                        <button type="button" class="btn btn-primary border lift mt-1">Back to Home</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>

    <?php

    include "footer.php";
?>