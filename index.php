<?php
  include('./auth/auth_session.php');
  include('./auth/conn.php');
  $sql = "SELECT * FROM items";
  $res = mysqli_query($con, $sql);

  // get cart items based on user - using session
  $sql1 = "SELECT * FROM cart WHERE uid = '" . $_SESSION['id'] . "'";
  $result = mysqli_query($con, $sql1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="./custom.js"></script>
</head>
<body>
  <div class="header-box d-flex align-items-center justify-content-between">
    <div class="dropdown">
      <a class="dropdown-toggle text-decoration-none d-flex align-items-center m-2" id="dropdownMenuButton1" data-bs-toggle="dropdown">
        <h4 class="text-warning me-2">Hello,</h4>
        <h5 class="m-0"><?php echo $_SESSION['username']; ?></h5>
      </a>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="./auth/logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
  <div class="mt-5">
    <div class="container">
      <div class="main-page">
        <div class="row">
          <?php
          // Initialize an empty array to store quantities by iid
          $cart_quantities = array();
          // Fetch all quantities from the cart table and store in $cart_quantities array
          while ($row1 = mysqli_fetch_assoc($result)) {
            $cart_quantities[$row1['iid']] = $row1['quantity'];
          }
          while ($row = mysqli_fetch_assoc($res)) {
          ?>
            <div class="d-flex justify-content-center mb-2">
              <div class="row card d-flex shadow w-100 position-relative pb-5  pt-2" id="item-box">
                <div class="col-2">
                  <div class="d-flex align-items-center">
                    <p class="mb-0 ps-1"><?php echo $row['name'] ?></p>
                  </div>
                </div>
                <div class="col-2 card-body p-0 position-absolute end-0">
                  <div class="d-flex flex-column float-end pe-3">
                    <div class="">
                      <p class="m-0 float-end cost" data-card-id="card<?php echo $row['id'] ?>">₹ <?php echo $row['price'] ?></p>
                    </div>
                    <div class="2">
                      <?php
                      // Check if quantity exists for current $row['id'] in $cart_quantities array
                      if (isset($cart_quantities[$row['id']])) {
                        // Quantity exists, show increase/decrease controls
                      ?>
                        <a href="#" class="btn bg-add-count-color add-item-count" id="fruit<?php echo $row['id']; ?>">
                          <span class="remove" data-item-price="<?php echo $row['price']; ?>"> - </span>
                          <span class="count-inc-dec" data-inc-dec-id="<?php echo $row['id']; ?>"><?php echo $cart_quantities[$row['id']]; ?></span>
                          <span class="add" data-item-price="<?php echo $row['price']; ?>"> + </span>
                        </a>
                      <?php
                      } else {
                        // Quantity does not exist, show Add + button
                      ?>
                        <a href="#" class="btn bg-add-color add-item" id="fruit<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>" data-item-price="<?php echo $row['price']; ?>">Add +</a>
                        <a href="#" class="btn bg-add-count-color add-item-count" id="fruit<?php echo $row['id']; ?>" style="display: none;">
                                    <span class="remove" data-item-price="<?php echo $row['price']; ?>"> - </span>
                                    <span class="count-inc-dec" data-inc-dec-id="<?php echo $row['id']; ?>">1</span>
                                    <span class="add" data-item-price="<?php echo $row['price']; ?>"> + </span>
                                </a>
                        
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="order-box border h-100 w-100 mt-4 pb-5 pt-3 px-3 position-sticky">
          <div class="box d-flex p-2">
            <div class="money flex-grow-1">
              <h4>₹ <span class="tcost">0</span></h4>
              <p>Total Order Cost</p>
            </div>
            <div class="items">
              <div class="position-relative mb-2" style="left: 4rem;">
                <i class="fa-solid fa-cart-shopping fa-xl"></i>
                <div class="position-absolute circle-css">
                  <i class="fa-solid fa-circle fa-lg"><span class="count-items">0</span></i>
                </div>
              </div>
              <a class="btn btn-light view-order-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">View Order </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Your Order Summary</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="order-summary" class="mb-2">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Place Order</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>