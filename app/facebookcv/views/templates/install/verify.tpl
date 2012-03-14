<!doctype html>
<html lang="pt-PT">
	<head>
		<meta charset="utf-8">
		
		<link rel="stylesheet" href="{$public_url}css/reset.css" media="all">
		<link rel="stylesheet" href="{$public_url}css/install.css" media="all">
		
		<title>Facebook CV - Instalação</title>
		
		<script type="text/javascript" src="{$public_url}js/jquery.js"></script>
		<script type="text/javascript" src="{$public_url}js/install.js"></script>
	</head>
	<body>
		<div id="contentor">
			<h1>Configuração do Facebook CV</h1>
			
			<div class="passo" id="passo-1">
				<h3>Estado da Instalação</h3>
				
				<ul id="verificar">
					<li>Ficheiro <i>database.php</i> exsite: {if $config}<span class="ok">Sim</span>{else}<span class="no">Não</span>{/if}</li>
					<li>Ligação à BD estabelecida: {if $db_conn}<span class="ok">Sim</span>{else}<span class="no">Não</span>{/if}</li>
					<li>Schema da BD criado: {if $db_schema}<span class="ok">Sim</span>{else}<span class="no">Não</span>{/if}</li>
					<li>Permissões directório <strong>app/facebookcv/views/compiled</strong>: {if $compile_writable}<span class="ok">Sim</span>{else}<span class="no">Não</span>{/if}</li>
					<li>Permissões directório <strong>app/facebookcv/views/cache</strong>: {if $cache_writable}<span class="ok">Sim</span>{else}<span class="no">Não</span>{/if}</li>
					<li>Permissões directório <strong>public/images/uploads</strong>: {if $uploads_writable}<span class="ok">Sim</span>{else}<span class="no">Não</span>{/if}</li>
					<li>Ficheiro de configuração do Facebook existe: {if $facebook}<span class="ok">Sim</span>{else}<span class="no">Não</span>{/if}</li>
				</ul>
				
				{if !$proceed}
				<p style="text-align: right;">
					<a href="{$base_url}index.php/install/verify">Voltar a tentar</a>
				</p>
				{/if}
				
				{if $proceed}
				<p>
					O último passo é estabelecer a ligação com o Facebook. Por favor dê permissão à sua
					aplicação para continuar.
				</p>
				
				<p style="text-align: center;">
					<a href="javascript:void(0);" id="fb-connect">
						<img src="{$public_url}images/fb-connect.png" alt="Ligar com Facebook" />
					</a>
				</p>
				
				<p id="loading">
					<img src="{$public_url}images/fb-loading.gif" alt="A carregar" />
				</p>
				
				<p class="sucesso" id="verify-success">
					A instalação foi concluída com sucesso. Por favor remova o ficheiro <strong>app/facebookcv/install.php</strong> antes de continuar.
					<a href="{$base_url}">Terminar</a>.
				</p>
				{/if}
			</div>
			
			{if $facebook}
			<div id="fb-root"></div>
			<script type="text/javascript">
				var appID = '{$facebook['appID']}';
				var appSecret = '{$facebook['appSecret']}';
				var base_url = '{$base_url}index.php/';
			</script>
			{/if}
	</body>
</html>