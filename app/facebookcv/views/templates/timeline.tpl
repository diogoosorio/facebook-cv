<!-- Caixa -->
<div class="elemento editable year-{date('Y', strtotime($entry['tl_date']))}" id="elem-{$entry['tl_ID']}">
	<div class="{cycle values='col-direita,col-esquerda'} caixa-timeline">
		{if $admin}
			<a style="right: 26px;" class="facebookcv-action admin-edit" method="editTimeline" params="id:{$entry['tl_ID']}">
				<img src="{$public_url}images/edit.png" alt="" />
			</a>
			
			<a style="right: 5px;" class="facebookcv-action admin-edit" method="deleteTimeline" params="id:{$entry['tl_ID']}">
				<img src="{$public_url}images/delete.png" alt="" />
			</a>
		{/if}
		<div class="caixa-apontador"></div>
		<div class="caixa-contentor">
			<header>
				<div class="header-timeline">
					<img src="http://graph.facebook.com/{$user['user_fb_ID']}/picture?type=square" style="width: 32px; height: 32px;" alt="Diogo Osório" />
				</div>
				<div class="header-timeline-text">
					<span class="timeline-azul bold">Diogo Osório</span>
					{if $entry['tl_type'] == 'work'}
					esteve empregado em
					{elseif $entry['tl_type'] == 'education'}
					estudou em 
					{else}
					concluiu um projecto
					{/if}
					 <a href="{if $entry['tl_url']}{$entry['tl_url']}{else}javascript:void(0);{/if}">{$entry['tl_title']}</a><br />
					{if $entry["tl_date"] and $entry["tl_end_date"]}
						De {$entry["tl_date"]|date_format:"%m/%g"} a {$entry["tl_end_date"]|date_format:"%m/%g"}
					{elseif $entry["tl_date"]}
						Em {$entry["tl_date"]|date_format:"%m/%g"}
					{/if} 
				</div>
				
				<div class="limpar"></div>
			</header>
			
			<div class="caixa-conteudo">
				{if $entry['tl_main_desc']}
				<div class="caixa-descricao">
					{$entry['tl_main_desc']}
				</div>
				{/if}
				
				<div class="caixa-portfolio">
					<div class="caixa-portfolio-imagem">
						{if $entry['tl_url']}
						<a href="{$entry['tl_url']}">
							<img src="{$public_url}images/uploads/{$entry['tl_thumb']}" alt="{$entry['tl_title']}" />
						</a>
						{else}
						<img src="{$public_url}images/uploads/{$entry['tl_thumb']}" alt="{$entry['tl_title']}" />
						{/if}
					</div>
					<div class="caixa-portfolio-descricao">
						<a class="bold" href="{if $entry['tl_url']}{$entry['tl_url']}{else}javascript:void(0);{/if}">{$entry['tl_title']}</a>
						
						{if $entry['tl_inner_desc']}
							<p>{$entry['tl_inner_desc']}</p>
						{/if}
					</div>
					<div class="limpar"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="limpar"></div>
</div>
<!-- /Caixa -->