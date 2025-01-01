jQuery(document).ready(function ($) {
  $("#search").on("input", function () {
    const query = $(this).val();

    if (query.length > 2) {
      $.ajax({
        url: ajax_url,
        type: "POST",
        data: {
          action: "fetch_search_results",
          keyword: query,
        },
        success: function (data) {
          $("#result").html(data).fadeIn();
        },
      });
    } else {
      $("#result").fadeOut();
    }
  });

  // open search box using id
  $("#search_icon").on("click", function (e) {
    e.preventDefault();
    $(this).addClass("active");
    $(".search_box").addClass("active");
    setTimeout(() => {
      $(".search_box inpiy[type=text]").focus();
    }, 500);
  });

  // Close suggestions when clicking outside
  $(document).on("click", function (e) {
    if (!$(e.target).closest("#searchform").length) {
      $("#result").fadeOut();
    }
  });

  $(".close_search").on("click", function () {
    $(".search_box").removeClass("active");
  });

  $(document).keyup(function (e) {
    if (e.key === "Escape") {
      $(".search_box").removeClass("active");
    }
  });
});
