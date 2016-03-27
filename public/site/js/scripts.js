$( document ).ready(function() {
  /* activate jquery isotope */
  var $container = $('#posts').isotope({
    itemSelector : '.item',
    isFitWidth: true
  });

  $(window).smartresize(function(){
    $container.isotope({
      columnWidth: '.col-sm-4'
    });
  });
  
  $container.isotope({ filter: '*' });

    // filter items on button click
  /*$('#filters').on( 'click', 'button', function() {
    var filterValue = $(this).attr('data-filter');
    $container.isotope({ filter: filterValue });
  });*/
  
	$("#frm-contato").validate({
		debug: true,
		errorElement: 'label',
		errorClass: 'error',
		focusInvalid: false,
		ignore: "",
		rules: {
			txtemail: {
				required: true,
				email: true
			},
			txtnome: { 
				required: true 
			},
			txtmensagem: { 
				required: true,
				minlength: 20,
				maxlength: 200,
			}
		},
		messages: {
			txtemail: {
				required: "Nos diga seu email para contato.",
				email: "Ops..verifique se você digitou o email correto."
			},
			txtnome: {
				required: "Nos diga seu nome..."
			},
			txtmensagem: {
				required: "Escreva algo...",
				minlength: "Sua mensagem deve ter no mínimo 20 caracteres..",
				maxlength: "Sua mensagem deve ter no máximo 200 caracteres.."
			}
		},
		errorPlacement: function (error, element) { 				
			if (element.parent().parent().parent(".i-checks").size() > 0) {
				error.appendTo(element.parent().parent().parent().parent("div:first"));
			}
			else {
				error.insertAfter(element);
			}
		},
		submitHandler: function(form) {	
			form.submit();
		}
	});  
});