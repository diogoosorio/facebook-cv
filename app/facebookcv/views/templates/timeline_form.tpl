<div class="formulario-ajax" id="edit-timeline">
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Tipo</label>
		</div>
		<div class="ajax-input">
			<select name="tl_type">
				{foreach from=$types item=type}
				<option value="{$type}" {if isset($entry['tl_type']) and $entry['tl_type'] eq $type}selected="selected"{/if}>{ucfirst($type)}</option>
				{/foreach}
			</select>
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>URL da Imagem (Máx 100px de largura)</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="tl_thumb" value="{if isset($entry['tl_thumb'])}{$entry['tl_thumb']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>URL</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="tl_url" value="{if isset($entry['tl_url'])}{$entry['tl_url']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Descrição URL</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="tl_inner_desc" value="{if isset($entry['tl_inner_desc'])}{$entry['tl_inner_desc']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Título</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="tl_url" value="{if isset($entry['tl_title'])}{$entry['tl_title']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Data</label>
		</div>
		<div class="ajax-input">
			<input type="text" class="datepicker" name="tl_datel" value="{if isset($entry['tl_date'])}{$entry['tl_date']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Data Fim</label>
		</div>
		<div class="ajax-input">
			<input type="text" class="datepicker" name="tl_end_date" value="{if isset($entry['tl_end_date'])}{$entry['tl_end_date']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento">
		<div class="ajax-label">
			<label>Texto</label>
		</div>
		<div class="ajax-input">
			<input type="text" name="tl_main_desc" value="{if isset($entry['tl_main_desc'])}{$entry['tl_main_desc']}{/if}" />
		</div>
		<div class="limpar"></div>
	</div>
	
	<div class="ajax-elemento ajax-btn">
		<button class="facebookcv-action" method="{$action}" params="submit:1">Guardar</button>
	</div>
</div>