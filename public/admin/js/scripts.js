
APP = {
	
	iCheckProgramas: function(){
		
		//revisar aqui nao funciona
	  $('input[name="programas[]"]').on('click', function() {
                var that = $(this);
                var parentUL = that.parent().parent();
			var parentChk = parentUL.parent().find("input:first");
					var oneChecked = false;
					parentUL.find("input").each(function(){oneChecked = oneChecked || this.checked;});
					console.log(oneChecked);
					parentChk.attr("checked", oneChecked);
		});
			
		//ifUnchecked
	},

	select2Comp: function(){
		
	 	function formatResult(item) {
          if(!item.id) {
            return item.text;
          }
          return '<i class="fa '+ item.text+'"></i> ' + item.text;
        }
		
		function formatSelection(item) {
		  return '<i class="fa '+ item.text+'"></i> ' + item.text;
        }
		
		$('select.select2').select2({
 			allowClear: true,
			formatResult: formatResult,
			formatSelection: formatSelection
		});
	},
	
	//Modal confirm
	confirmModal: function(){
		$('#modal-confirm').on('show.bs.modal', function(e) {
			var url = $(e.relatedTarget).data('url');
			var value = $(e.relatedTarget).data('value')
			$(e.currentTarget).find("#paramValue").html( value );
			$(e.currentTarget).find("#linkConfirm").attr('href', url);
		});
		
		$('#modal-confirm').on('hidden.bs.modal', function () {
			$(this).removeData();
		});
	},
	
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
	
	//form validacao form grupos
	validateGrupos: function(){
		
		$("#form-grupos").validate({
			errorElement: 'label',
			errorClass: 'error',
			focusInvalid: false,
			ignore: "",
			rules: {
				descricao: "required",
				nome: "required"	
			},
			messages: {
				descricao: "Informe uma descrição para o Grupo",
				nome: "Informe um Nome para o Grupo"
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
		this.validateGrupos();
		this.iCheck();
		this.altPass();
		this.confirmModal();
		this.select2Comp();
		this.iCheckProgramas();
	}
};