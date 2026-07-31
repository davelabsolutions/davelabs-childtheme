<?php
/**
 * DaveLabs modern front page.
 *
 * Template Name: DaveLabs Command Home
 * Template Post Type: page
 *
 * @package davelabs-command
 */

if ( ! function_exists( 'davelabs_command_get_tagged_logos' ) ) {
	function davelabs_command_get_tagged_logos( $tag ) {
		$logos       = array();
		$attachments = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'post_status'    => 'inherit',
				'posts_per_page' => 100,
				'orderby'        => 'menu_order date',
				'order'          => 'ASC',
				'meta_query'     => array(
					array(
						'key'     => '_wp_attachment_image_alt',
						'value'   => $tag,
						'compare' => 'LIKE',
					),
				),
			)
		);

		foreach ( $attachments as $attachment ) {
			$alt      = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
			$name     = trim( str_replace( $tag, '', $alt ) );
			$image_id = (int) $attachment->ID;

			$logos[] = array(
				'name' => $name ? $name : get_the_title( $image_id ),
				'url'  => wp_get_attachment_image_url( $image_id, 'medium' ),
				'alt'  => $name ? $name : get_the_title( $image_id ),
			);
		}

		return array_values(
			array_filter(
				$logos,
				function ( $logo ) {
					return ! empty( $logo['url'] );
				}
			)
		);
	}
}

$header_logos = davelabs_command_get_tagged_logos( '#logo_header' );
$brand_logo   = ! empty( $header_logos ) ? $header_logos[0]['url'] : get_stylesheet_directory_uri() . '/assets/img/logo-redes.png';
$project_image_base = get_stylesheet_directory_uri() . '/assets/img/projects/';

$clients = array(
	array( 'name' => 'Google' ),
	array( 'name' => 'airbnb' ),
	array( 'name' => 'Creative Market' ),
	array( 'name' => 'shopify' ),
	array( 'name' => 'amazon' ),
	array( 'name' => 'airbnb' ),
	array( 'name' => 'Google' ),
	array( 'name' => 'stripe' ),
);

$client_logos = davelabs_command_get_tagged_logos( '#logo_cliente' );

if ( ! empty( $client_logos ) ) {
	$clients = $client_logos;
}

$services = array(
	array(
		'code'  => '01',
		'label' => 'Software',
		'title' => 'Desarrollo web y sistemas a medida',
		'text'  => 'Creamos sitios, plataformas, paneles internos, APIs e integraciones que conectan tu operación real con herramientas digitales estables.',
		'items' => array( 'WordPress avanzado', 'Sistemas internos', 'APIs e integraciones' ),
	),
	array(
		'code'  => '02',
		'label' => 'AI Ops',
		'title' => 'Automatización con inteligencia artificial',
		'text'  => 'Diseñamos flujos con IA para clasificar solicitudes, responder clientes, generar reportes, conectar datos y reducir trabajo repetitivo.',
		'items' => array( 'Asistentes internos', 'Bots operativos', 'Reportes inteligentes' ),
	),
	array(
		'code'  => '03',
		'label' => 'Cloud',
		'title' => 'Servidores, hosting y despliegues',
		'text'  => 'Aprovisionamos infraestructura, migramos sitios, configuramos dominios, correos, SSL, backups, monitoreo y ambientes productivos.',
		'items' => array( 'VPS y cloud', 'Backups', 'Monitoreo' ),
	),
	array(
		'code'  => '04',
		'label' => 'Network',
		'title' => 'Redes, vigilancia y soporte técnico',
		'text'  => 'Instalamos y mantenemos redes, cámaras, equipos, usuarios, accesos remotos y soporte correctivo/preventivo para empresas.',
		'items' => array( 'Redes empresariales', 'CCTV', 'Soporte continuo' ),
	),
);

$systems = array(
	array( 'name' => 'Arquitectura', 'value' => 'Mapeo técnico, rutas críticas, seguridad y plan de implementación.' ),
	array( 'name' => 'Construcción', 'value' => 'Desarrollo, configuración, integraciones, pruebas y documentación.' ),
	array( 'name' => 'Operación', 'value' => 'Soporte, monitoreo, mejoras, backups y continuidad del servicio.' ),
);

$use_cases = array(
	'Automatizar respuestas y seguimiento comercial por WhatsApp, correo o CRM.',
	'Levantar servidores seguros con respaldos, dominios, correo y SSL.',
	'Crear dashboards internos para ventas, soporte, inventario o administración.',
	'Instalar redes, cámaras y accesos remotos para equipos operativos.',
);

$projects = array(
	array(
		'badge'   => 'Producto operativo',
		'title'   => 'Contacore',
		'text'    => 'Panel de operación comercial para centralizar contactos, seguimiento, reportes y flujo de trabajo entre equipos.',
		'stack'   => array( 'Dashboard', 'CRM', 'Reportes', 'Automatización' ),
		'metrics' => array( 'Operación centralizada', 'Seguimiento medible' ),
		'image'   => $project_image_base . 'contacore.png',
	),
	array(
		'badge'   => 'Gestión documental',
		'title'   => 'Tramitamos',
		'text'    => 'Experiencia digital para organizar solicitudes, documentos, verificaciones, estados y pasos de aprobación.',
		'stack'   => array( 'Documentos', 'Validación', 'Flujos', 'Estados' ),
		'metrics' => array( 'Procesos ordenados', 'Menos fricción operativa' ),
		'image'   => $project_image_base . 'tramitamos.png',
	),
	array(
		'badge'   => 'IA + Soporte',
		'title'   => 'Automatización en Chatwoot',
		'text'    => 'Flujos para clasificar conversaciones, enrutar tickets, activar respuestas y conectar la atención con procesos internos.',
		'stack'   => array( 'Chatwoot', 'Meta', 'n8n', 'IA' ),
		'metrics' => array( 'Atención más rápida', 'Menos trabajo manual' ),
		'image'   => $project_image_base . 'chatwoot-automation.png',
	),
	array(
		'badge'   => 'Marketing automation',
		'title'   => 'Plugin - Campañas WhatsApp',
		'text'    => 'Plugin para WordPress orientado al envío de notificaciones y campañas de marketing por WhatsApp, con historial, métricas e integraciones.',
		'stack'   => array( 'WordPress', 'Twilio', 'WhatsApp Cloud API', 'Marketing' ),
		'metrics' => array( 'Envíos masivos', 'Métricas de campaña' ),
		'image'   => $project_image_base . 'whatsapp-marketing.png',
	),
);

$properties = array(
	array(
		'key'     => 'contacore',
		'eyebrow' => 'Suite comercial',
		'title'   => 'Contacore',
		'text'    => 'Centraliza contactos, seguimiento, reportes y automatizaciones comerciales en un panel diseñado para que los equipos vendan y operen con claridad.',
		'items'   => array( 'CRM operativo', 'Seguimiento comercial', 'Reportes ejecutivos' ),
		'cta'     => 'Ver Contacore',
		'url'     => home_url( '/contacore/' ),
		'image'   => $project_image_base . 'contacore.png',
	),
	array(
		'key'     => 'praeva',
		'eyebrow' => 'Inteligencia documental',
		'title'   => 'Praeva',
		'text'    => 'Organiza expedientes, verificaciones, documentos y decisiones con una experiencia preparada para procesos que necesitan control, trazabilidad y menos fricción.',
		'items'   => array( 'Expedientes digitales', 'Validación de datos', 'Flujos de aprobación' ),
		'cta'     => 'Ver Praeva',
		'url'     => home_url( '/praeva/' ),
		'image'   => '',
	),
);

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'dl-command-home' ); ?>>
<?php wp_body_open(); ?>

<main class="dl-site-shell" id="main">
	<header class="dl-nav" aria-label="<?php esc_attr_e( 'Navegación principal', 'davelabs-command' ); ?>">
		<a class="dl-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'DaveLabs inicio', 'davelabs-command' ); ?>">
			<img src="<?php echo esc_url( $brand_logo ); ?>" alt="" width="38" height="38">
			<span>DaveLabs</span>
		</a>
		<nav class="dl-menu" aria-label="<?php esc_attr_e( 'Secciones', 'davelabs-command' ); ?>">
			<a href="#servicios">Servicios</a>
			<a href="#ia">Automatización</a>
			<a href="#infraestructura">Infraestructura</a>
			<a href="#proyectos">Proyectos</a>
			<a href="#contacto">Contacto</a>
		</nav>
		<a class="dl-nav-cta" href="#contacto">Contáctanos</a>
	</header>

	<section class="dl-hero" aria-labelledby="dl-hero-title">
		<canvas class="dl-network" data-dl-network aria-hidden="true"></canvas>
		<div class="dl-star-field" aria-hidden="true"></div>
		<div class="dl-hero-inner">
			<h1 id="dl-hero-title">Soluciones tecnológicas para tu negocio</h1>
			<p class="dl-hero-lead">Servicios de desarrollo, automatización e infraestructura para acelerar crecimiento, optimizar procesos y llevar tu operación al siguiente nivel.</p>
			<div class="dl-actions">
				<a class="dl-button dl-button-primary" href="#contacto">Impulsar mi negocio</a>
			</div>
		</div>
		<div class="dl-hero-orbit" aria-hidden="true"></div>
		<div class="dl-logo-strip" aria-label="<?php esc_attr_e( 'Clientes DaveLabs', 'davelabs-command' ); ?>">
			<div class="dl-logo-track">
				<?php for ( $loop = 0; $loop < 2; $loop++ ) : ?>
					<?php foreach ( $clients as $client ) : ?>
						<div class="dl-logo-strip-item">
							<?php if ( ! empty( $client['url'] ) ) : ?>
								<img src="<?php echo esc_url( $client['url'] ); ?>" alt="<?php echo esc_attr( $client['alt'] ); ?>" loading="lazy">
							<?php else : ?>
								<span class="dl-logo-word"><?php echo esc_html( $client['name'] ); ?></span>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<section class="dl-section dl-intro" id="servicios">
		<div class="dl-section-head">
			<p class="dl-kicker">Qué hacemos</p>
			<h2>Un partner técnico para construir lo digital y sostener lo operativo.</h2>
		</div>
		<div class="dl-intro-grid">
			<div class="dl-intro-copy">
				<p>DaveLabs une desarrollo, automatización e infraestructura para que no tengas proveedores aislados resolviendo piezas sueltas. Entendemos el proceso, construimos la solución y mantenemos la base técnica funcionando.</p>
			</div>
			<div class="dl-signal-row">
				<span><strong>Dev</strong> Plataformas y sistemas</span>
				<span><strong>AI</strong> Flujos automatizados</span>
				<span><strong>Ops</strong> Servidores y soporte</span>
			</div>
		</div>
	</section>

	<section class="dl-service-lab">
		<?php foreach ( $services as $service ) : ?>
			<article class="dl-service-card">
				<div class="dl-service-top">
					<span><?php echo esc_html( $service['code'] ); ?></span>
					<p><?php echo esc_html( $service['label'] ); ?></p>
				</div>
				<h3><?php echo esc_html( $service['title'] ); ?></h3>
				<p><?php echo esc_html( $service['text'] ); ?></p>
				<ul>
					<?php foreach ( $service['items'] as $item ) : ?>
						<li><?php echo esc_html( $item ); ?></li>
					<?php endforeach; ?>
				</ul>
			</article>
		<?php endforeach; ?>
	</section>

	<section class="dl-ai-panel" id="ia">
		<div class="dl-ai-visual" aria-hidden="true">
			<div class="dl-ai-core">
				<img src="<?php echo esc_url( $brand_logo ); ?>" alt="">
			</div>
			<span class="dl-node dl-node-a">Meta</span>
			<span class="dl-node dl-node-b">Chatwoot</span>
			<span class="dl-node dl-node-c">n8n</span>
			<span class="dl-node dl-node-d">CRM</span>
			<span class="dl-node dl-node-e">ERP</span>
			<span class="dl-node dl-node-f">WhatsApp</span>
			<span class="dl-node dl-node-g">Soporte</span>
			<span class="dl-node dl-node-h">IA</span>
		</div>
		<div class="dl-ai-copy">
			<p class="dl-kicker">Automatización con IA</p>
			<h2>IA conectada a tus sistemas, datos y equipos.</h2>
			<p>No vendemos automatizaciones decorativas. Analizamos tareas repetitivas, conectamos herramientas y dejamos flujos que trabajan con reglas, contexto y supervisión.</p>
			<div class="dl-ai-steps">
				<div><strong>01</strong><span>Identificamos tareas manuales y cuellos de botella.</span></div>
				<div><strong>02</strong><span>Conectamos datos, canales y herramientas existentes.</span></div>
				<div><strong>03</strong><span>Entrenamos flujos, alertas y respuestas operativas.</span></div>
			</div>
		</div>
	</section>

	<section class="dl-section dl-split" id="infraestructura">
		<div>
			<p class="dl-kicker">Infraestructura y soporte</p>
			<h2>La capa técnica que mantiene tu empresa disponible.</h2>
			<p>Servidores, hosting, correos, dominios, respaldos, redes, cámaras y soporte técnico se vuelven parte de un mismo sistema de continuidad.</p>
		</div>
		<div class="dl-stack-panel">
			<?php foreach ( $systems as $index => $system ) : ?>
				<div>
					<strong><?php echo esc_html( '0' . ( $index + 1 ) ); ?></strong>
					<span><?php echo esc_html( $system['name'] ); ?></span>
					<p><?php echo esc_html( $system['value'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="dl-properties" id="propiedades">
		<div class="dl-properties-head">
			<p class="dl-kicker">Propiedades de DaveLabs</p>
			<h2>Productos propios para convertir operación compleja en sistemas claros.</h2>
		</div>
		<div class="dl-property-slider" data-property-slider aria-label="<?php esc_attr_e( 'Slider de propiedades DaveLabs', 'davelabs-command' ); ?>">
			<button class="dl-project-arrow dl-project-arrow-prev" type="button" data-property-prev aria-label="<?php esc_attr_e( 'Propiedad anterior', 'davelabs-command' ); ?>">‹</button>
			<div class="dl-property-track">
				<?php foreach ( $properties as $index => $property ) : ?>
					<article class="dl-property-banner dl-property-<?php echo esc_attr( $property['key'] ); ?>" data-property-slide<?php echo 0 === $index ? '' : ' aria-hidden="true"'; ?>>
						<div class="dl-property-copy">
							<span class="dl-property-eyebrow"><?php echo esc_html( $property['eyebrow'] ); ?></span>
							<h3><?php echo esc_html( $property['title'] ); ?></h3>
							<p><?php echo esc_html( $property['text'] ); ?></p>
							<div class="dl-property-points">
								<?php foreach ( $property['items'] as $item ) : ?>
									<span><?php echo esc_html( $item ); ?></span>
								<?php endforeach; ?>
							</div>
							<a class="dl-button dl-button-primary" href="<?php echo esc_url( $property['url'] ); ?>"><?php echo esc_html( $property['cta'] ); ?></a>
						</div>
						<div class="dl-property-visual" aria-hidden="true">
							<?php if ( ! empty( $property['image'] ) ) : ?>
								<img src="<?php echo esc_url( $property['image'] ); ?>" alt="" loading="lazy">
							<?php else : ?>
								<div class="dl-praeva-ui">
									<span></span>
									<span></span>
									<span></span>
									<span></span>
								</div>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<button class="dl-project-arrow dl-project-arrow-next" type="button" data-property-next aria-label="<?php esc_attr_e( 'Propiedad siguiente', 'davelabs-command' ); ?>">›</button>
			<div class="dl-property-dots" aria-label="<?php esc_attr_e( 'Seleccionar propiedad', 'davelabs-command' ); ?>">
				<?php foreach ( $properties as $index => $property ) : ?>
					<button class="<?php echo 0 === $index ? 'is-active' : ''; ?>" type="button" data-property-dot="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( 'Ver ' . $property['title'] ); ?>"<?php echo 0 === $index ? ' aria-current="true"' : ''; ?>></button>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="dl-section dl-use-cases">
		<div class="dl-section-head">
			<p class="dl-kicker">Casos comunes</p>
			<h2>Problemas reales que podemos resolver contigo.</h2>
		</div>
		<div class="dl-use-grid">
			<?php foreach ( $use_cases as $index => $case ) : ?>
				<article>
					<span><?php echo esc_html( '0' . ( $index + 1 ) ); ?></span>
					<p><?php echo esc_html( $case ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="dl-projects" id="proyectos">
		<div class="dl-projects-head">
			<p class="dl-kicker">Proyectos destacados</p>
			<h2>Proyectos reales con una capa visual más clara y tecnológica.</h2>
			<p>Una muestra de plataformas, flujos y automatizaciones que podemos diseñar, conectar y mantener para operaciones reales.</p>
		</div>
		<div class="dl-project-carousel" data-project-carousel aria-label="<?php esc_attr_e( 'Carrusel de proyectos destacados', 'davelabs-command' ); ?>">
			<button class="dl-project-arrow dl-project-arrow-prev" type="button" data-project-prev aria-label="<?php esc_attr_e( 'Proyecto anterior', 'davelabs-command' ); ?>">‹</button>
			<div class="dl-project-track">
				<?php for ( $loop = 0; $loop < 2; $loop++ ) : ?>
					<?php foreach ( $projects as $project ) : ?>
						<article class="dl-project-card"<?php echo $loop > 0 ? ' aria-hidden="true"' : ''; ?>>
							<figure class="dl-project-image">
								<img src="<?php echo esc_url( $project['image'] ); ?>" alt="<?php echo esc_attr( 'Visual del proyecto ' . $project['title'] ); ?>" loading="lazy">
							</figure>
							<div class="dl-project-content">
								<span class="dl-project-badge"><?php echo esc_html( $project['badge'] ); ?></span>
								<h3><?php echo esc_html( $project['title'] ); ?></h3>
								<p><?php echo esc_html( $project['text'] ); ?></p>
								<div class="dl-project-stack">
									<?php foreach ( $project['stack'] as $tool ) : ?>
										<span><?php echo esc_html( $tool ); ?></span>
									<?php endforeach; ?>
								</div>
								<div class="dl-project-metrics">
									<?php foreach ( $project['metrics'] as $metric ) : ?>
										<strong><?php echo esc_html( $metric ); ?></strong>
									<?php endforeach; ?>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				<?php endfor; ?>
			</div>
			<button class="dl-project-arrow dl-project-arrow-next" type="button" data-project-next aria-label="<?php esc_attr_e( 'Proyecto siguiente', 'davelabs-command' ); ?>">›</button>
		</div>
		<div class="dl-projects-action">
			<a class="dl-button dl-button-secondary" href="<?php echo esc_url( home_url( '/proyectos/' ) ); ?>">Ver más proyectos terminados</a>
		</div>
	</section>

	<section class="dl-cta" id="contacto">
		<p class="dl-kicker">Siguiente paso</p>
		<h2>Hablemos de tu operación tecnológica y armemos una ruta clara.</h2>
		<div class="dl-actions">
			<a class="dl-button dl-button-primary" href="mailto:contacto@davelabs.com.mx">contacto@davelabs.com.mx</a>
			<a class="dl-button dl-button-secondary" href="https://wa.me/5215534546470" target="_blank" rel="noreferrer">WhatsApp</a>
		</div>
	</section>

	<footer class="dl-footer">
		<div class="dl-footer-main">
			<div class="dl-footer-brand">
				<a class="dl-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'DaveLabs inicio', 'davelabs-command' ); ?>">
					<img src="<?php echo esc_url( $brand_logo ); ?>" alt="" width="38" height="38">
					<span>DaveLabs</span>
				</a>
				<p>Desarrollo, automatización con IA, infraestructura, redes, vigilancia, hosting y soporte técnico para operaciones que necesitan avanzar.</p>
			</div>
			<nav class="dl-footer-column" aria-label="<?php esc_attr_e( 'Servicios footer', 'davelabs-command' ); ?>">
				<h3>Servicios</h3>
				<a href="#servicios">Desarrollo de sistemas</a>
				<a href="#ia">Automatización con IA</a>
				<a href="#infraestructura">Servidores y hosting</a>
				<a href="#infraestructura">Redes y vigilancia</a>
			</nav>
			<nav class="dl-footer-column" aria-label="<?php esc_attr_e( 'Navegación footer', 'davelabs-command' ); ?>">
				<h3>Navegación</h3>
				<a href="#servicios">Servicios</a>
				<a href="#proyectos">Proyectos</a>
				<a href="#contacto">Contacto</a>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a>
			</nav>
			<div class="dl-footer-column">
				<h3>Contacto</h3>
				<a href="mailto:contacto@davelabs.com.mx">contacto@davelabs.com.mx</a>
				<a href="https://wa.me/5215534546470" target="_blank" rel="noreferrer">WhatsApp</a>
				<span>México / remoto</span>
				<span>Soporte y proyectos</span>
			</div>
		</div>
		<div class="dl-footer-bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> DaveLabs. Todos los derechos reservados.</span>
			<span>Construido para operar mejor.</span>
		</div>
	</footer>
</main>

<?php wp_footer(); ?>
</body>
</html>
