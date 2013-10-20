function open(event) {
	event.preventDefault();
	$('body').toggleClass('form-open');
}

$(function(){
	$('#closeForm').on('click', function(){
		$('body').removeClass('form-open');
	})
	$('#addWebsite').on('click', open);
});


$(function() {
	$('.activate').on('click', function(){
		$('div.active').removeClass('active');
		$(this).parents('.box').addClass('active');

		var location = $(this).data('loc'),
			pendingSite = $(this).data('id');

		$.ajax({
			url: 'app/index.php',
			data: { action: "avt", location : location, id: pendingSite }
		});
	});
});


$(function(){
    $( "form#addWebsite" ).on( "submit", function(e) {
      e.preventDefault();
      var data = $(this).serialize();
      console.log(data);
       $.ajax({
			url: 'app/index.php',
			data: data,
			success: function(result){
				$('.success .wrap').html(result);
           		$('.success').addClass('show');
           		setTimeout(function() {
				    $('.success').removeClass('show');
					$('body').removeClass('form-open');
				}, 2000);
				setTimeout(function() {
					location.reload();
				}, 2500);
        	}
		});
    });
});

$(function(){
	$('.delete').on('click', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$.ajax({
			url: 'app/index.php',
			data: { action: "rem", id: id},
			success: function() {
				location.reload();
			}
		});
	});
});