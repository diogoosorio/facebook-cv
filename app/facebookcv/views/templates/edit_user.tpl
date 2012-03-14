<div class="formulario-ajax" id="edit-user">
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Email</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="user_email" value="{if isset($user['user_email'])}{$user['user_email']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Nome</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="user_name" value="{if isset($user['user_name'])}{$user['user_name']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Website</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="user_website" value="{if isset($user['user_website'])}{$user['user_website']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Linkedin</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="user_linkedin" value="{if isset($user['user_linkedin'])}{$user['user_linkedin']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Título da Página</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="user_page_title" value="{if isset($user['user_page_title'])}{$user['user_page_title']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Frase Trabalho</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="user_highlight_work" value="{if isset($user['user_highlight_work'])}{$user['user_highlight_work']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Frase Escola</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="user_highlight_school" value="{if isset($user['user_highlight_school'])}{$user['user_highlight_school']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Frase Paixão</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="user_highlight_pashion" value="{if isset($user['user_highlight_pashion'])}{$user['user_highlight_pashion']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Frase Casa</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="user_highlight_location" value="{if isset($user['user_highlight_location'])}{$user['user_highlight_location']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento ajax-btn">
		<button class="facebookcv-action" method="editUser" params="submit:1">Guardar</button>
	</div>
</div>