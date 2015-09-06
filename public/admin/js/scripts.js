
APP = {
	
	//iCheck
	iCheck: function(){
		$('input[type="radio"]').on('ifChecked', function(event){
			$(this).valid();
		});
	},
	
	//switch
	jsSwitch: function(){
		var elem = document.querySelector('.js-switch');
		var switchery = new Switchery(elem, { color: '#1AB394' });
	},
	
	//alterar Senha
	altPass: function() {
			
		$(".altpass").on('click', function(){
			if($(".passw").hasClass('hidden')) {
				$(".passw").removeClass('hidden');
				$("#alterar_senha").val(1);
			}
			else {				
				$(".passw").addClass('hidden');
				$("#alterar_senha").val(0);
			}
		});			
	},
	
	//form validacao form usuarios
	validateUsuarios: function(){
		
		$("#form-usuarios").validate({
			errorElement: 'label',
			errorClass: 'error',
			focusInvalid: false,
			ignore: "",
			rules: {
				grupo: "required",
				nome: "required",
				email: {
				  required: true,
				  email: true
				},
				senha: {
					required: {
						depends: function() {
							return $("#alterar_senha").val() == 0
					 	}
					}
				},
				conf_senha: {
					required: {
						 depends: function() {
							 return $("#alterar_senha").val() == 0
						 }
					},
					equalTo: {
						param: '#senha',
						depends: function() {
							 return $("#alterar_senha").val() == 0
						}
					}
				},				
				senha_atual: {
					required: {
						depends: function() {
							return $("#alterar_senha").val() == 1
					 	}
					}
				},
				nova_senha: {
					required: {
						depends: function() {
							return $("#alterar_senha").val() == 1
					 	}
					}
				},
				conf_nova_senha: {
					required: {
						 depends: function() {
							 return $("#alterar_senha").val() == 1
						 }
					},
					equalTo: {
						param: '#nova_senha',
						depends: function() {
							 return $("#alterar_senha").val() == 1
						}
					}
				},	
			},
			messages: {
				grupo: "Selecione o Grupo do Usuário",
				nome: "Informe o Nome do Usuário",
				email: {
				  required: "Infome o Email do Usuário",
				  email: "Informe um Email válido"
				},
				senha: "Informe a Senha para Login",
				conf_senha: {
					required: "Confirme a Senha",
					equalTo: "Confirmação de Senha inválida"
				},
				senha_atual: "Informe a Senha atual do Usuário",
				nova_senha: "Informe a Nova Senha do Usuário",
				conf_nova_senha: {
					required: "Confirme a Nova Senha",
					equalTo: "Confirmação da Nova Senha inválida"
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
	},
	
	init: function(){
		this.jsSwitch();
		this.validateUsuarios();
		this.iCheck();
		this.altPass();
	}
};