<div class="formulario-fb">	
	<div class="formulario-fb-inner" id="formulario-contacto">
		<p>
			Preencha o formulário abaixo que eu entrarei em contacto o mais 
			brevemente que me for possivel. Se quiser entrar directamente
			em contacto comigo ligue para o <i>+351 969 518 562</i>.
		</p>
		
		<p>
			<label>Nome</label> <sup class="formulario-fb-erro" id="fb-nome-erro"></sup><br />
			<input type="text" name="name" id="fb-nome" />
		</p>
		
		<p>
			<label>Email</label> <sup class="formulario-fb-erro" id="fb-email-erro"></sup><br />
			<input type="text" name="email" id="fb-email" />
		</p>
		
		<p>
			<label>Contacto Telefónico</label> <sup class="formulario-fb-erro" id="fb-telefone-erro"></sup><br />
			<input type="text" name="telephone" id="fb-telefone" />
		</p>
		
		<p>
			<label>Mensagem</label> <sup class="formulario-fb-erro" id="fb-mensagem-erro"></sup><br />
			<textarea name="message">{if $message}{$message}{/if}</textarea>
		</p>
	</div>
	<div class="formulario-fb-btn">
		<a class="normal-azul facebookcv-action" href="javascript:void(0);" style="color: #FFF; padding: 5px 7px;" method="sendMessage" params="submit:1" id="contacto-enviar">Enviar</a>
	</div>
</div>