$(document).ready(function() {

  $('#navbar__user').click(function(){
    $('#navbar__actions').toggleClass('active');
  });

  $(document).click(function(event){
    var container = $('#navbar__actions-dropdown');
		if(!container.is(event.target) && container.has(event.target).length === 0 && !$('#navbar__user').is(event.target)) {
      $('#navbar__actions').removeClass('active');
    }
  });
});
