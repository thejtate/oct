Drupal.behaviors.accordion = function (context) {
  $("#edit-field-camps-ad-field-camps-ad-add-more").click(function(){
     $("#edit-field-camps-at-field-camps-at-add-more").click();
  });
  $("#edit-field-camps-ad-field-camps-ad-add-more").keypress(function(){
     $("#edit-field-camps-at-field-camps-at-add-more").keypress();
  });
  $("#edit-field-camps-ad-field-camps-ad-add-more").mousedown(function(){
     $("#edit-field-camps-at-field-camps-at-add-more").mousedown();
  });


  $(".accordion").accordion({
    collapsible: true,
    active: false,
    autoHeight: false
	});

}

