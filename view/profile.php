<?php

include "head.php";
include "sidebar.php";
include "header.php";
?>

    <!-- Body: Body -->
    <main class="content">
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <?php
                                // if(isset($_SESSION['img_profile'])){
                                //     $user_image ='../uploads/'. $_SESSION['img_profile'];
                                //     echo  "<center class='mt-4'> <img src='$user_image' id='prof_image' class='rounded-circle' width='150' />";
                                // }
                              
                             
                                ?>
                            <center class='mt-4'> <img src='' id='prof_image' class='rounded-circle' width='150' />
                                <h4 class="card-title mt-2">
                                    <?php echo $_SESSION['full_name'];  ?>
                                </h4>
                                <h6 class="card-subtitle">
                                    <?php echo $_SESSION['user_type'];  ?>
                                </h6>
                                <div class="row text-center justify-content-md-center">
                                    <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>
                                    <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>
                                </div>
                            </center>
                    </div>
                    <div>
                        <hr> </div>
                    <div class="card-body">
                        <h4 class="card-title d-flex">Select Your Image
                        </h4>
                        <form action="" method="POST" id="img_update_frm" enctype="multipart/form-data">
                            <input type="hidden" id="id" name="id" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="file" id="file" name="file" class="dropify" required />
                            <input type="submit" id="submit" class=" btn btn-primary mt-4" name="submit" value="Save">
                        </form>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <!-- Tabs -->

                    <!-- Tabs -->




                    <div class="card-body">
                        <form class="form-horizontal form-material" action="" method="POST" id="frm_edit_profile_content">
                            <div class="form-group" style="margin-top: 40px;">
                                <label for="f_name" class="col-md-12">Users Name</label>
                                <input type="hidden" id="id" name="id" value="<?php echo $_SESSION['user_id']; ?>">
                                <div class="col-md-12">
                                    <input type="text" id="Usersname" name="Usersname" placeholder="Usersname" disabled required class="form-control" value="<?php echo $_SESSION['user_name']; ?>" </div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 40px;">
                                <label for="password" class="col-md-12">Password</label>
                                <div class="col-md-12">
                                    <input type="password" id="password" name="password" placeholder="Password" required class="form-control">
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 40px;">
                                <label for="status" class="col-md-12">Status</label>
                                <div class="col-md-12">
                                    <input type="text" id="status" name="status" placeholder="Status" disabled required class="form-control" value="<?php echo $_SESSION['user_status']; ?>" </div>
                                </div>
                                <div class="form-group" style="margin-top: 40px;">
                                    <label for="type" class="col-md-12">User Type</label>
                                    <div class="col-md-12">
                                        <input type="text" id="type" name="type" placeholder="User type" disabled required class="form-control" value="<?php echo $_SESSION['user_type']; ?>">
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: 40px;">
                                    <label for="type" class="col-md-12">Created Date</label>
                                    <div class="col-md-12">
                                        <input type="date" id="date" name="date" placeholder="date" disabled required class="form-control" value="<?php echo $_SESSION['created_date']; ?>">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                        </form>
                        </div>


                    </div>
                </div>
                <!-- Column -->
            </div>
    </main>
    </div>

    </div>

    <?php

    include "footer.php";
?>
  <script type="module">
    import {fetch_profile,profile_content} from '../controllers/baseScript.js'
    var url = "../models/submenusApi.php"
    fetch_profile()
    profile_content()
                                    
</script>
        <!-- <script src="../controllers/update_profile.js"></script> -->