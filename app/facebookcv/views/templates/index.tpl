<!doctype html>
<html lang="pt-PT">
	<head>
		<!--
		Olá! Se está a ver esta mensagem é porque provavelmente está a tentar discernir
		o que realmente sei fazer.
		
		Para acomodar este micro-site desenvolvi de raiz uma pequena framework que obedece ao padrão
		MVC. Ainda é um trabalho em desenvolvimento, mas pode consultar o código seguindo
		o endereço: https://github.com/diogoosorio
		
		Se quiser recolher mais alguma informação sobre mim, visite o endereço: http://diogoosorio.com/site/employers
		-->
		<meta charset="utf-8">
		<base href="">
		<title>{$user['user_page_title']}</title>
		
		<link rel="stylesheet" href="{$public_url}css/reset.css" media="all">
		<link rel="stylesheet" href="{$public_url}css/960.css" media="all">
		<link rel="stylesheet" href="{$public_url}css/sprites.css" media="all">
		<link rel="stylesheet" href="{$public_url}css/redmond/jquery-ui-1.8.18.custom.css" media="all">
		<link rel="stylesheet" href="{$public_url}css/style.css" media="all">
	</head>
	<body>
			{if $admin}
			<div id="barra-admin" class="draggable">
				<ul>
					<li>
						<a href="javascript:void(0);" class="facebookcv-action" method="editUser">
							Editar Configurações
						</a>
					</li>
				</ul>
			</div>
			{/if}
		<!-- Top Header -->
		<header id="top-header">
			<div class="container_16">
				<!-- Logo e Icones -->
				<div class="grid_7" style="position: relative;">
					<!-- Logotipo -->
					<h1 id="logo">
						<a title="Logotipo da página" href="{$base_url}">
							{$user['user_page_title']}
						</a>
					</h1>
					<!-- Logotipo -->
					
					<!-- Menu Amigos -->
					<section id="amigos" class="caixa-destaque-topo amigos">
						<h3>Pedidos de Amizade</h3>
						
						<div class="contentor-destaque">
							<img class="imagem-pedido-amigo" src="{$public_url}images/foto-request.jpg" alt="Pedido Amigo" />
							
							<ul class="pedido-amigo">
								<li>
									<h5>Diogo Osório</h5>
									Lisboa, Portugal
									<p>Convidou-o a marcar uma entrevista de trabalho com ele.</p>
									
									<p style="margin-top: 20px; ">
										<a href="javascript:void(0);" class="normal-azul facebookcv-action" method="goToAndClick" params="id:contactar,click:contact">Confirmar</a>
									</p>
									<div class="limpar"></div>
								</li>
							</ul>
							
							<div class="limpar"></div>
						</div>
						
						<div class="footer-caixa-cinzento"> 
							<a target="_blank" href="http://www.facebook.com/#/{$user['user_fb_ID']}">Ir para o perfil de {substr($user['user_name'], 0, strpos($user['user_name'], ' '))}</a>
						</div>
					</section>
					<!-- Menu Amigos -->
					
					<!-- Amigos, mensagens e notificações -->
					<ul id="icones-header">
						<li><a id="friend-request" href="javascript:void(0);"><span class="sprite sprite-friends-blue"></span></a></li>
						<li><a href="javascript:void(0);"><span class="sprite sprite-message-blue"></span></a></li>
						<li><a href="javascript:void(0);"><span class="sprite sprite-globe-blue"></span></a></li>
					</ul>
					<!-- Amigos, mensagens e notificações -->
				</div>
				<!-- Logo e Icones -->
				
				<!-- Menu -->
				<div class="grid_8 prefix_1 contentor-menu">
					<nav id="nav-menu-principal">
						<ul id="menu-principal">
							<li class="contentor-image-mini"><img src="http://graph.facebook.com/{$user['user_fb_ID']}/picture?type=square" alt="Diogo Osório" /></li>
							<li><a href="javascript:void(0);" class="facebookcv-action" method="timeline" params="type:work">Trabalho</a></li>
							<li><a href="javascript:void(0);" class="facebookcv-action" method="timeline" params="type:education">Formação</a></li>
							<li><a href="javascript:void(0);" class="facebookcv-action" method="timeline" params="type:portfolio">Portfolio</a></li>
							<li><a href="http://diogoosorio.com/site/employers/" target="_blank">Sobre</a></li>
							{if $static}
								{foreach from=$static item=$page}
									<li><a href="javascript:void(0)" class="facebookcv-action" method="static" param="{$page['st_ID']}">{$page['st_name']}</a>
								{/foreach}
							{/if}
						</ul>
					</nav>
				</div>
				<!-- Menu -->
			</div>
		</header>
		<!-- Top Header -->
		
		<!-- Conteúdo -->
		<div class="container_16" id="contentor-conteudo">			
			<!-- Conteúdo Principal -->
			<section id="conteudo-principal" class="grid_13">
				
				<!-- Contentor Introducao -->
				<section id="contentor-introducao">
					<img id="imagem-introducao" src="https://graph.facebook.com/{$user['user_fb_ID']}/picture?type=large" alt="Diogo Osório" />
					
					<!-- Social Media -->
					<div id="social-media">
						<ul id="social">
							<li><div class="fb-like" data-send="false" data-layout="box_count" data-width="60" data-show-faces="false"></div></li>
							<li><g:plusone size="tall"></g:plusone></li>
							<li><a class='twitter-share-button' data-count='vertical' data-via='myaccount' expr:data-text='data:post.title' expr:data-url='data:post.canonicalUrl' href='http://twitter.com/share'>Tweet</a></li>
							<li><script type="IN/Share" data-counter="top"></script></li>
						</ul>
					</div>
					<!-- Social Media -->
					
					<h2 id="user_name">{$user['user_name']}</h2>
					
					<!-- Destaques -->
					<div id="destaques">
						<ul>
							{if isset($user['user_highlight_work'])}
							<li>
								<span class="sprite sprite-work"></span>
								<span id="user_highlight_work">{$user['user_highlight_work']}</span>
							</li>
							{/if}
							
							{if isset($user['user_highlight_school'])}
							<li>
								<span class="sprite sprite-school"></span>
								<span id="user_highlight_school">{$user['user_highlight_school']}</span>
							</li>
							{/if}
							
							{if isset($user['user_highlight_pashion'])}
							<li>
								<span class="sprite sprite-heart"></span>
								<span id="user_highlight_pashion">{$user['user_highlight_pashion']}</span>
							</li>
							{/if}
							
							{if isset($user['user_highlight_location'])}
							<li>
								<span class="sprite sprite-house"></span>
								<span id="user_highlight_work">{$user['user_highlight_location']}</span>
							</li>
							{/if}
						</ul>
					</div>
					<!-- Destaques -->
					
					<!-- Portfolio Rápido -->
					<div id="portfolio-rapido">
						<ul id="ul-portfolio-rapido">
							{if isset($portfolio) and is_array($portfolio)}
								{foreach from=$portfolio item=entry}
									<li>
										<a href="{$entry['tl_url']}" target="_blank">
											<img src="{$public_url}images/uploads/{$entry['tl_thumb']}" alt="{$entry['tl_title']}">
										</a>
									</li>
								{/foreach}
							{/if}
						</ul>
					</div>
					<!-- Portfólio Rápido -->
					
					<!-- Ver tudo -->
					<a href="javascript:void(0);" id="ver-tudo" class="facebookcv-action" method="slide" params="id:ul-portfolio-rapido">Ver Mais</a>
					<!-- Ver tudo -->
					
					<div class="limpar"></div>
				</section>
				<!-- Contentor Introducao -->
				
				<!-- Timeline -->
				<section id="timeline">
					<div id="linha-timeline"></div>
					
					<!-- Caixa -->
					<div class="elemento" id="contactar" style="padding-top: 20px;">
						<div class="col-esquerda caixa-timeline">
							<div class="caixa-apontador"></div>
							<div class="caixa-contentor">
								<ul id="contacto-menu">
									<li>
										<a class="sprite sprite-email menu-actual" href="javascript:void(0);" id="box-contacto">
											Contacto
										</a>
									</li>
									<li {if !$user['user_website']}style="display: none;"{/if}> 
										<a class="sprite sprite-website" href="{$user['user_website']}" target="_blank">
											Website
										</a>
									</li>
									
									<li {if !$user['user_linkedin']}style="display: none;"{/if}>
										<a class="sprite sprite-linkedin2" href="{$user['user_linkedin']}" target="_blank">
											LinkedIn
										</a>
									</li>
								</ul>
								
								<div id="contacto-caixa">
									<div id="contacto-triangulo"></div>
									<textarea id="contact" rows="10" cols="20">Entre em contacto comigo aqui...</textarea>
									<div class="caixa-footer">
										<div class="caixa-footer-adicionar">
											<a class="add-friend" href="#"></a>
										</div>
										
										<div class="caixa-footer-btn">
											<a class="normal-azul facebookcv-action" href="javascript:void(0);" method="sendMessage" params="area:contact" id="contacto-enviar">Enviar</a>
										</div>
										
										<div class="limpar"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="limpar"></div>
					</div>
					<!-- /Caixa -->
					
						
					{foreach from=$timeline item=entry}
						<div class="timeline-separator type-{$entry['tl_type']}">
							{include file='timeline.tpl' entry=$entry}
						</div>
					{/foreach}
					<!-- /Entriesk-->
				</section>
				<!-- Timeline -->
			</section>
			<!-- /Conteúdo Principal -->
		
			<!-- Sidebar -->
			<aside id="barra-lateral" class="grid_3">
				<!-- Anúncios -->
				<section id="contentor-anuncios" title="Anúncios">
					
					<h4>Patrocinado</h4>
					
					<ul id="anuncios">
						<li>
							<h5>Ajude-me e Parilhe a Página!</h5>
							
							<a class="sprite sprite-sidebar-ad" href="javascript:void(0);"></a>
							<p>
								Nesta altura difícil estou à procura do meu Trabalho de Sonho! 								
							</p>
							<p>
								Se gostou da ideia, ajude-me partilhando a página com os seus amigos.
							</p>
						</li>
						
						<li>
							<h5>Porquê?</h5>
							
							<p>
								Se quer saber um pouco mais sobre mim ou
								sobre este projecto, convido-o a vistar
								<a href="http://diogoosorio.com/site/employers" target="_blank">esta
								página</a>.
							</p>
						</li>
					</ul>
				</section>
				<!-- Anúncios -->
				
				<!-- Cronologia -->
				<nav id="cronologia">
					<ul>
					 	{foreach from=$years item=year name=years}
						<li>
							<a id="year-{$year[0]}" {if $smarty.foreach.years.first}class="cronogolia-actual facebookcv-action"{else}class="facebookcv-action"{/if} method="goToYear" params="year:{$year[0]}" href="javascript:void(0);">{$year[0]}</a>
						</li>
						{/foreach}
					</ul>
				</nav>
				<!-- Cronologia -->
			</aside>
			<!-- /Sidebar -->
		</div>
		<!-- /Conteúdo -->
		
		<!-- Footer -->
		<footer id="footer-principal">
			Desenvolvido por <a href="http://diogoosorio.com" target="_blank">Diogo Osório</a>. Inspirado no <a href="http://www.facebook.com" target="_blank">Facebook</a>. 
			Este site não está de forma alguma associado ao <a href="http://www.facebook.com" target="_blank">Facebook</a>.
		</footer>
		<!-- /Footer -->
		<div id="fb-root"></div>
		
		<script type="text/javascript" src="{$public_url}js/jquery.js"></script>
		<script type="text/javascript" src="{$public_url}js/scrollto.js"></script>
		<script type="text/javascript" src="{$public_url}js/jquery-ui.js"></script>
		<script type="text/javascript" src="{$public_url}js/ajaxfileupload.js"></script>
		<script type="text/javascript" src="{$public_url}js/facebookcv.js"></script>
		<script type="text/javascript">
			var ajaxUrl = '{$base_url}index.php/ajax/';
			var isAdmin = {if $admin}true{else}false{/if};
		</script>
		
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
