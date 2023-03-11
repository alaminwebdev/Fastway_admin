<?php include('db_connect.php') ?>
<?php
$twhere = "";
if ($_SESSION['login_type'] != 1)
  $twhere = "  ";
?>
<!-- Info boxes -->
<?php if ($_SESSION['login_type'] == 1) : ?>
  <div class="row">
    <div class="col-12">
      <div class="small-box admin_bg shadow-sm border">
        <div class="p-5">
          <h3>
            Welcome <?php echo $_SESSION['login_name'] ?> ! <span class="badge badge-pill badge-success">Admin</span>
          </h3>
        </div>
        <div class="icon">
          <i class="fa fa-user"></i>
        </div>

      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
      <div class="small-box bg-info shadow-sm border">
        <div class="inner">
          <h3><?php echo $conn->query("SELECT * FROM branches")->num_rows; ?></h3>
          <p>Total Branches </p>
        </div>
        <div class="icon">
          <i class="fa fa-building"></i>
        </div>
        <a href="index.php?page=branch/branch_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
      <div class="small-box bg-success shadow-sm border">
        <div class="inner">
          <h3><?php echo $conn->query("SELECT * FROM parcels")->num_rows; ?></h3>

          <p>Total Parcels</p>
        </div>
        <div class="icon">
          <i class="fas fa-box"></i>
        </div>
        <a href="index.php?page=parcel_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
      <div class="small-box bg-danger shadow-sm border">
        <div class="inner">
          <h3><?php echo $conn->query("SELECT * FROM users where type != 1")->num_rows; ?></h3>

          <p>Total Staff</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <a href="index.php?page=staff/staff_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <hr>
    <?php
    $status_arr = array("Item Accepted by Courier", "Collected", "Shipped", "In-Transit", "Arrived At Destination", "Out for Delivery", "Ready to Pickup", "Delivered", "Picked-up", "Unsuccessfull Delivery Attempt");

    $bg_arr = array("bg-secondary", "bg-dark", "bg-success", "bg-light", "bg-info", "bg-secondary", "bg-secondary", "bg-dark", "bg-success", "bg-danger");

    $icon_arr = array("fas fa-clipboard-check", "fas fa-check-square", "fas fa-truck", "fas fa-shipping-fast", "fas fa-location-arrow", "fas fa-truck-loading", "fas fa-truck-pickup", "fas fa-check", "fas fa-hand-holding-heart", "fas fa-ban");

    foreach ($status_arr as $k => $v) :
    ?>
      <div class="col-12 col-sm-6 col-md-4">

        <div class="small-box shadow-sm border <?php echo $bg_arr[$k] ?>">
          <div class="inner">
            <h3><?php echo $conn->query("SELECT * FROM parcels where status = {$k} ")->num_rows; ?></h3>

            <p><?php echo $v ?></p>
          </div>
          <div class="icon">
            <i class="<?php echo $icon_arr[$k] ?>"></i>
          </div>
          <a href="index.php?page=parcel_list&s=<?php echo $k ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

    <?php endforeach; ?>
  </div>

<?php else : ?>
  <div class="row">
    <div class="col-12">
      <div class="small-box bg-light shadow-sm border">
        <div class="p-5">
          <?php
          $branch = array();
          $branches = $conn->query("SELECT *,concat(address,', ',city) as addresss FROM branches where id in ($_SESSION[login_branch_id]) ");
          while ($row = $branches->fetch_assoc()) :
            $branch[$row['id']] = $row['addresss'];
          endwhile;

          ?>
          <h3>
            Welcome <?php echo $_SESSION['login_name'] ?> !
          </h3>
          <p><span class="badge badge-pill badge-success">
              <?php echo ucwords($branch[$_SESSION['login_branch_id']]) ?> Branch!
            </span></p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>

      </div>
    </div>
    <?php
    $status_arr = array("Item Accepted by Courier", "Collected", "Shipped", "In-Transit", "Arrived At Destination", "Out for Delivery", "Ready to Pickup", "Delivered", "Picked-up", "Unsuccessfull Delivery Attempt", "Pending");

    $bg_arr = array("bg-secondary", "bg-dark", "bg-success", "bg-light", "bg-info", "bg-secondary", "bg-secondary", "bg-dark", "bg-success", "bg-warning", "bg-danger");

    $icon_arr = array("fas fa-clipboard-check", "fas fa-check-square", "fas fa-truck", "fas fa-shipping-fast", "fas fa-location-arrow", "fas fa-truck-loading", "fas fa-truck-pickup", "fas fa-check", "fas fa-hand-holding-heart", "fas fa-ban");

    foreach ($status_arr as $k => $v) :
    ?>
      <div class="col-12 col-sm-6 col-md-4">

        <div class="small-box shadow-sm border <?php echo $bg_arr[$k] ?>">
          <div class="inner">
            <h3><?php echo $conn->query("SELECT * FROM parcels where status = {$k} ")->num_rows; ?></h3>

            <p><?php echo $v ?></p>
          </div>
          <div class="icon">
            <i class="<?php echo $icon_arr[$k] ?>"></i>
          </div>
          <a href="index.php?page=parcel_list&s=<?php echo $k ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

    <?php endforeach; ?>
  </div>


<?php endif; ?>