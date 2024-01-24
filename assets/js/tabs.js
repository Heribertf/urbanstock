$(document).ready(function () {
  // Initially hide all list items in tab-content
  $(".tab-content li").hide();

  $(".method-content li").hide();

  // Show list items of the initially selected group
  $(".tab-content .group-1").show();

  $(".method-content .mpesa").show();

  $(".tab-nav")
    .find("button")
    .click(function (e) {
      var theFilter = $(this).data("filter");

      e.preventDefault();

      // Remove "active" class from all buttons
      $(".tab-nav").find("button").removeClass("active");

      // Add "active" class to the clicked button
      $(this).addClass("active");

      // Hide all list items
      $(".tab-content li").hide();

      // Show list items of the selected group
      $(".tab-content").find(theFilter).show();
    });

  $(".tab-btns")
    .find("button")
    .click(function (e) {
      var theFilter = $(this).data("filter");

      e.preventDefault();

      // Remove "active" class from all buttons
      $(".tab-btns").find("button").removeClass("active");

      // Add "active" class to the clicked button
      $(this).addClass("active");

      // Hide all list items
      $(".method-content li").hide();

      // Show list items of the selected group
      $(".method-content").find(theFilter).show();
    });
});
