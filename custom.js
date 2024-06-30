$(document).ready(function () {
  var countItems = parseInt($(".count-items").text());
  var tcost = 0;
  var itemsCost = {};
  $(".add-item").click(function () {
    var itemPrice = parseInt($(this).data("item-price")); // Fetch item price
    var itemId = $(this).closest(".d-flex").find(".cost").data("card-id"); // Fetch item ID
    countItems++;
    $(".count-items").text(countItems);
    var cost = parseInt(
      $(this).closest(".d-flex").find(".cost").text().replace("₹", "").trim()
    );
    tcost = tcost + cost;
    $(".tcost").text(tcost);

    // Initialize item cost in itemsCost if it's the first time adding this item
    if (!itemsCost[itemId]) {
      itemsCost[itemId] = 0;
    }

    // Update item cost in itemsCost
    itemsCost[itemId] += itemPrice;

    // Update order summary for this item
    updateOrderSummary(itemId);
    $(this).css("display", "none");
    $(this).siblings(".bg-add-count-color").addClass("display-block-important");

    var copiedContent = $(this).closest("#item-box").clone();
    $("#order-summary").append(copiedContent);

    // backend

    var item_id = parseInt($(this).closest(".d-flex").find(".count-inc-dec").data("inc-dec-id"));
    var quantity = $('.count-inc-dec[data-inc-dec-id="' + item_id + '"]').first().text();

    updateQuantity(item_id, quantity);

    $.ajax({
      url: "add_in_db.php",
      type: "POST",
      data: {
        item_id: item_id,
        quantity: quantity
      },
      dataType: "json",
      success: function(response) {
        alert(response);
      },
    });

  // end of add-item click 
  });

  function updateItemCount(element) {
    var incElem = $(element).siblings(".count-inc-dec");
    var inc = parseInt(incElem.text());
    inc++;
    incElem.text(inc);
    countItems++;
    $(".count-items").text(countItems);
    //cost calc
    var itemPrice = parseInt($(element).data("item-price"));
    var itemId = $(element).closest(".d-flex").find(".cost").data("card-id");
    tcost = tcost + itemPrice;
    $(".tcost").text(tcost);

    // Update order summary cost for this item
    if (!itemsCost[itemId]) {
      itemsCost[itemId] = 0;
    }
    itemsCost[itemId] += itemPrice;
    updateOrderSummary(itemId);

    // update order-summary count
    var itemID = $(element).siblings(".count-inc-dec").data("inc-dec-id");
    $("#order-summary")
      .find('.count-inc-dec[data-inc-dec-id="' + itemID + '"]')
      .text(inc);

    // update main-page count
    $(".main-page")
      .find('.count-inc-dec[data-inc-dec-id="' + itemID + '"]')
      .text(inc);
    return inc;
  }
  function updateOrderSummary(itemId) {
    var osCostElem = $("#order-summary").find(
      '.cost[data-card-id="' + itemId + '"]'
    );
    var osCost = itemsCost[itemId];
    osCostElem.text("₹ " + osCost); // Assuming order summary cost display format
  }
  function updateItemCountRemove(element) {
    var rmElem = $(element).siblings(".count-inc-dec");
    var rm = parseInt(rmElem.text());
    if (rm > 0) {
      rm--;
      rmElem.text(rm);
      countItems--;
      $(".count-items").text(countItems);

      //cost calc
      var cost = parseInt(
        $(element)
          .closest(".d-flex")
          .find(".cost")
          .text()
          .replace("₹", "")
          .trim()
      );
      tcost = tcost - cost;
      $(".tcost").text(tcost);

      // update order-summary count
      var itemID = $(element).siblings(".count-inc-dec").data("inc-dec-id");
      $("#order-summary")
        .find('.count-inc-dec[data-inc-dec-id="' + itemID + '"]')
        .text(rm);

      // update main-page count
      $(".main-page")
        .find('.count-inc-dec[data-inc-dec-id="' + itemID + '"]')
        .text(rm);
    }
  }
  // Add and remove items functionality main page
  $(".add").click(function () {
    var newQuantity = updateItemCount(this);
    var item_id = parseInt($(this).closest(".d-flex").find(".count-inc-dec").data("inc-dec-id"));
    // Call updateQuantity function to log quantity
    updateQuantity(item_id, newQuantity);

    $.ajax({
      url: "add_in_db.php",
      type: "POST",
      data: {
        uitem_id: item_id,
        nq: newQuantity
      },
      dataType: "json",
      success: function(response) {
        alert(response);
      },
    });
  });
  $(".remove").click(function () {
    updateItemCountRemove(this);

    // Call updateQuantity function to log quantity
    updateQuantity($(this).data("id"))
  });

  //  Add and remove in modal
  $("#order-summary").on("click", ".add", function () {
    updateItemCount(this);
    // Call updateQuantity function to log quantity
    updateQuantity($(this).data("id"))
  });
  $("#order-summary").on("click", ".remove", function () {
    updateItemCountRemove(this);
    // Call updateQuantity function to log quantity
    updateQuantity($(this).data("id"))
  });

// Function to update quantity and log it
function updateQuantity(item_id, quantity) {
  console.log("iid",item_id);
  console.log("q",quantity);
}
});
