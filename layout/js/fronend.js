$(function () {
  "use strict";
  //switch between login & signup
  $(".login-page h1 span").click(function () {
    $(this).addClass("selected").siblings().removeClass("selected");
    $(".login-page form").hide();
    $("." + $(this).data("class")).fadeIn(100);
  });
  //Trigger The Selectboxit
  $("select").selectBoxIt({
    autoWidth: false,
  });
  //Hide Placeholder on form foucs
  $("[placeholder]")
    .focus(function () {
      $(this).attr("data-text", $(this).attr("placeholder"));
      $(this).attr("placeholder", "");
    })
    .blur(function () {
      $(this).attr("placeholder", $(this).attr("data-text"));
    });
  //Add Astrisk On Required Field
  $("input").each(function () {
    if ($(this).attr("required") === "required") {
      $(this).after('<span class ="asterisk">*</span>');
    }
  });
  //confirm
  $(".confirm").click(function () {
    return confirm("Are You Sure");
  });
  //live-preview
  $(".live").keyup(function () {
    $($(this).data("class")).text($(this).val());
  });
});
