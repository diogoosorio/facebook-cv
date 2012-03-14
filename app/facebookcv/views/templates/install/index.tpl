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
			<h1>Instalação do Facebook CV</h1>
			
			<div class="passo" id="passo-1">
				<h3>Termos de Utilização & Créditos</h3>
				
				<p>
					Bem-vindo ao programa de instalação do <strong>Facebook CV</strong>. Este programa foi desenvolvido
					por <a href="http://diogoosorio.com" target="_blank">Diogo Osório</a> e é distribuído gratuitamente
					sob a licença <a href="http://www.mozilla.org/MPL/2.0/" target="_blank">Mozilla Public License 2.0</a>.
					Ao instalar / modificar este programa, está a aceitar os termos apresentados na licença mencionada
					acima.
				</p>
				
				<p>
					Se gosta do projecto, apoie-o dando-lhe visibilidade nas redes sociais. Por favor utilize os botões
					abaixo para partilhar o projecto com os seus amigos.
				</p>
				
				<ul id="social">
					<li><div class="fb-like" data-href="http://www.sapo.pt" data-send="false" data-layout="box_count" data-width="60" data-show-faces="false"></div></li>
					<li><g:plusone size="tall"></g:plusone></li>
					<li><a class='twitter-share-button' data-count='vertical' data-via='myaccount' expr:data-text='data:post.title' expr:data-url='data:post.canonicalUrl' href='http://twitter.com/share'>Tweet</a></li>
					<li><script type="IN/Share" data-counter="top"></script></li>
				</ul>
				
				<p style="text-align: right;">
					<a href="javascript:void(0);" class="next">Continuar</a>
				</p>
			</div>
			
			<div class="passo" id="passo-2">
				<h3>Instalação da Base de Dados</h3>
				
				<p>
					Para concluir a instalação siga os passos abaixo:
				</p>
				
				<ul class="instrucoes">
					<li>
						Crie uma base de dados MySQL e um utilizador com permissões de leitura
						e escrita à BD. Anote o nome da base de dados, o nome de utilizador e 
						a password respectiva.
					</li>
					
					<li>
						Abra o ficheiro <strong>app/config/database.php</strong> e edite os campos com a 
						informação que anotou no ponto 1. Poderá encontrar mais informações 
						<a href="http://php.net/manual/en/ref.pdo-mysql.connection.php" target="_blank">aqui</a> 
						sobre os elementos que pode incluir na DSN.
					</li>
					
					<li>
						Dê permissões de leitura e escrita (ex <i>chmod 755</i>) às seguintes pastas:
							
							<ul>
								<li><strong>app/facebookcv/views/cache/</strong></li>
								<li><strong>app/facebookcv/views/compiled/</strong></li>
								<li><strong>public/images/uploads</strong></li>
							</ul>
					</li>
				</ul>
				
				<p>
					Depois de executar todos os passos acima, pode passar ao passo seguinte. 
				</p>
				
				<p style="text-align: right;">
					<a href="javascript:void(0);" class="next">Continuar</a>
				</p>
			</div>
			
			<div class="passo" id="passo-3">
				<h3>Integração com o Facebook</h3>
				
				<p>
					O passo final é integrar o programa com o <strong>Facebook</strong>. Para tal
					vai ter de <a href="https://developers.facebook.com/apps" target="_blank">uma
					aplicação Facebook</a>. Retenha a <strong>App ID/API Key</strong> e a <strong>App
					Secret</strong>.  
				</p>
				
				<p>
					Abra o ficheiro <strong>app/config/facebook.php</strong> e introduza os valores que
					recolheu.
				</p>
				
				<p style="text-align: right;">
					<a href="{$base_url}index.php/install/verify">Continuar</a>
				</p>
			</div>
		</div>
		
		<div id="fb-root"></div>
		{literal}
		<!-- Place this render call where appropriate -->
		<script type="text/javascript">
		  window.___gcfg = {lang: 'pt-PT'};
		
		  (function() {
		    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		    po.src = 'https://apis.google.com/js/plusone.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
		<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/pt_PT/all.js#xfbml=1&appId=266553780064210";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		{/literal}
	</body>
</html>