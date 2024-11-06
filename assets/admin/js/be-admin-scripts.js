(function ($) {
  $(document).ready(function () {
    // show notification
    function showNotification(message) {
      Toastify({
        text: message,
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true, 
        style: {
          background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
        onClick: function () {},
      }).showToast();
    }

    // handle save credentials
    $("#credential-save").on("click", function (e) {
      e.preventDefault();

      // get credentials from form
      let client_id = $("#client-id").val();
      let client_secret = $("#client-secret").val();

      // make ajax call to save credentials
      $.ajax({
        url: bulkProductImport.ajax_url,
        method: "POST",
        data: {
          action: "save_client_credentials",
          nonce: bulkProductImport.nonce,
          client_id: client_id,
          client_secret: client_secret,
        },
        success: function (response) {
          if (response.success) {
            let successMessage = response.data;
            // Display an info toast with no title
            showNotification(successMessage);
            window.location.reload();
          } else {
            let errorMessage = response.data;
          }
        },
        error: function () {
          alert("An error occurred. Please try again.");
          window.location.reload();
        },
      });
    });

    // handle db tables creation
    $("#save-table-prefix").on("click", function (e) {
      e.preventDefault();

      let tablePrefix = $("#table-prefix").val();

      $.ajax({
        type: "POST",
        url: bulkProductImport.ajax_url,
        data: {
          action: "save_table_prefix",
          nonce: bulkProductImport.nonce,
          table_prefix: tablePrefix,
        },
        success: function (response) {
          let successMessage = response.data;
          // Display an info toast with no title
          showNotification(successMessage);
          // window.location.reload();
        },
      });
    });

    // handle db tables creation
    $("#options-save").on("click", function (e) {
      e.preventDefault();

      let option1 = $("#option1").val();

      $.ajax({
        type: "POST",
        url: bulkProductImport.ajax_url,
        data: {
          action: "save_options",
          nonce: bulkProductImport.nonce,
          option1: option1,
        },
        success: function (response) {
          let successMessage = response.data;
          // Display an info toast with no title
          showNotification(successMessage);
          // window.location.reload();
        },
      });
    });

    // tabs
    $("#tabs").tabs();

    function initializeConfetti(buttonId) {
      let button = document.getElementById(buttonId);
      let confetti = new Confetti(buttonId);
      confetti.setCount(75);
      confetti.setSize(1);
      confetti.setPower(25);
      confetti.setFade(false);
      confetti.destroyTarget(false);

      button.addEventListener("click", function () {
        confetti.shoot();
      });
    }
    // Initialize confetti for each button
    initializeConfetti("credential-save");
    initializeConfetti("save-table-prefix");

    // copy to clipboard
    function copyToClipboard(text) {
      let tempInput = document.createElement("input");
      tempInput.style.position = "absolute";
      tempInput.style.left = "-9999px";
      tempInput.value = text;
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand("copy");
      document.body.removeChild(tempInput);
    }

    document.getElementById("status-cp").addEventListener("click", function () {
      let statusApi = document.getElementById("status-api").textContent;
      copyToClipboard(statusApi);
      showNotification("Copied to clipboard!");
    });

    document.getElementById("delete-cp").addEventListener("click", function () {
      let deleteApi = document.getElementById("delete-api").textContent;
      copyToClipboard(deleteApi);
      showNotification("Copied to clipboard!");
    });

    document
      .getElementById("delete-trash-cp")
      .addEventListener("click", function () {
        let deleteTrashApi =
          document.getElementById("delete-trash-api").textContent;
        copyToClipboard(deleteTrashApi);
        showNotification("Copied to clipboard!");
      });

    document
      .getElementById("delete-woo-cats-cp")
      .addEventListener("click", function () {
        let deleteWooCats = document.getElementById(
          "delete-woo-cats-api"
        ).textContent;
        copyToClipboard(deleteWooCats);
        showNotification("Copied to clipboard!");
      });

    document
      .getElementById("sync-products-cp")
      .addEventListener("click", function () {
        let syncProducts = document.getElementById(
          "sync-products-api"
        ).textContent;
        copyToClipboard(syncProducts);
        showNotification("Copied to clipboard!");
      });

    document
      .getElementById("insert-products-cp")
      .addEventListener("click", function () {
        let productInsertDB = document.getElementById(
          "insert-products-api"
        ).textContent;
        copyToClipboard(productInsertDB);
        showNotification("Copied to clipboard!");
      });

    document
      .getElementById("insert-price-cp")
      .addEventListener("click", function () {
        let syncProducts = document.getElementById(
          "insert-price-api"
        ).textContent;
        copyToClipboard(syncProducts);
        showNotification("Copied to clipboard!");
      });

    document
      .getElementById("insert-stock-cp")
      .addEventListener("click", function () {
        let syncProducts = document.getElementById(
          "insert-stock-api"
        ).textContent;
        copyToClipboard(syncProducts);
        showNotification("Copied to clipboard!");
      });
  });
})(jQuery);
