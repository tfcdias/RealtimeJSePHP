var nome, img, canal;
	if(window.location.hash.length > 0){
		canal = 'canal '+ window.location.hash;
	}else{
		canal = 'canal global';
	}
        function hAtual(){
           var dat = new Date(), 
               horas = (dat.getHours() < 10) ? '0' + dat.getHours() : dat.getHours(), 
               minutos = (dat.getHours() < 10) ? '0' + dat.getMinutes() : dat.getMinutes();
           return `${horas}:${minutos}`;
        }
	$("#gerar").on('click', function(){
		if($('.gerado').val() == 0){
			$(this).html('Canal Gerado');
			$(this).css('background','#1abc9c');
			$('.gerado').val(document.location.href +'#'+ Math.ceil(Math.random() * 10000));
			$('.gerado').show('slow');
		}
	});
	if(sessionStorage.length > 0){
		nome = sessionStorage.getItem('name');
		img = sessionStorage.getItem('imagem');
                if(nome == "admin"){ $("#bugou").show(); }
		$('body>div.container-login').hide();
		$('body>div.container').show();
	}
	$("#bugou").on('click', function(){
		JSKhanSocket.limpar(canal);
	});
	$('body>div.container-login>div>div>img').on('click', function(){
		if(typeof img == 'undefined'){
			img = $(this).attr('src');
			$(this).css('border','3px solid blue');
		}
	});
        $(document).on('keydown', function(event) {
        if(event.keyCode === 13) {
        $("#bottom").click();
        }
        });
	$('#logar').on('click', function(){
		if($('.container-login>input').val().length > 2 && typeof img != 'undefined'){
			nome = $('body>div.container-login>input').val();
			sessionStorage.setItem('name', nome);
			sessionStorage.setItem('imagem', img);
                        if(nome == "admin"){ $("#bugou").show(); }
			$('body>div.container-login').hide();
			$('body>div.container').show();
		}
	});
	/*var nome = prompt('Qual e seu nome');
	if(nome.length <= 2){
		nome = prompt('Opaa o nome é Ogrigatorio Amigo !');
	}*/
	var socket = JSKhanSocket;
	socket.receber(canal, function(data){
		var d = data[canal];
		$.each(d, function(index, value){ 
                        var [na, me, im, ho] = value;
			socket.verifica('#msgs-body', me, function(){
			$("#msgs-body").append(`<div id="msgs-body-m"><div id="userm"><img src="${im}"/><h4>${na}</h4></div><div id="mensa-gem">${me}<div id="temp">Enviado as ${ho}</div></div></div>`);
                        document.getElementsByTagName('audio')[0].play();
				$("#msgs-body").animate({scrollTop: $('#msgs-body')[0].scrollHeight}, 500);
			});
		});
	});
	$("#bottom").on('click', function(){
		if($(".container>input").val().length > 3){
			var antiFlood = $("#msgs-body").html();
			if(antiFlood.indexOf($(".container>input").val()) == -1){
                                var menviar = $(".container>input").val();
                                menviar = menviar.replace(/(<([^>]+)>)/ig,"");
				socket.enviar(canal, [nome, menviar, img, hAtual], function(cb){
				var dtd = (cb == 'sucesso') ? 'Enviado Ao Socket Com Sucesso' : 'Erro ao Enviar Ao Socket';
				console.log(dtd);
				$(".container>input").val('');
				});}else{
				$(".container>input").val('');
				console.log("Anti Flood");
				$(".container>input").attr('placeholder','Opaa , Sem Flood !');}}});
