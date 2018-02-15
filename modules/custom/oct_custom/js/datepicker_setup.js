Drupal.behaviors.powerworks_datepicker =
  function(context){
  var startDate = new Date();
  //initTimepicker();
  //initNewTimepiker();

/*
  $("input[id^=edit-field-class-start-day-0-value]").datepicker({
      dateFormat: "d M, yy",
      altFormat: "d M, yy",
      minDate: startDate,
      numberOfMonths: 3
  });
  $("input[id^=edit-field-class-end-day-0-value]").datepicker({
      dateFormat: "d M, yy",
      altFormat: "d M, yy",
      minDate: startDate,
      numberOfMonths: 3
  });
  $("input[id^=edit-field-class-start-time-0-value]").timepicker({
      ampm: true,
      hourGrid: 2,
      minuteGrid: 10,
      width: 600
  });
  $("input[id^=edit-field-class-end-time-0-value]").timepicker({
      ampm: true,
      hourGrid: 2,
      minuteGrid: 10,
      width: 600
  });
  */
};

function initTimepicker(){
  $('.field-class-time-list .form-text').each(function(){
    $(this).timepicker({
        ampm: true,
        hourGrid: 2,
        minuteGrid: 10,
        width: 500
    });
  });
}
function initNewTimepiker(){
  $('.field-class-time-list .form-text').each(function(){
    $(this).timepicker({});
  });
}