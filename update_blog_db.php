<?php
require_once 'includes/db.php';

echo "<h1>Actualización de la Base de Datos: Entradas del Blog con HTML Completo</h1>";

try {
    $pdo->exec("ALTER TABLE blog_posts ADD COLUMN contenido_html TEXT");
} catch (Exception $e) {
}

try {
    $pdo->exec("ALTER TABLE blog_posts ADD COLUMN slug VARCHAR(255)");
} catch (Exception $e) {
}

$pdo->exec("TRUNCATE TABLE blog_posts");

$html_post_1 = <<<HTML
<p>Como en cualquier ámbito, empezando por nuestra vida personal y terminando por el ámbito profesional, cuidar los detalles será lo que nos haga diferentes, y ser diferentes es lo único que nos hará distinguirnos en un terreno tan saturado como es el de los eventos. Por ello, rodearse de profesionales que cuiden, desde un primer momento, cada una de las piezas que componen este sector, es imprescindible para lograr un resultado de diez.</p>
<p>Detenerse en ese pequeño detalle es imprescindible para crear el evento perfecto.</p>
<img src="assets/images/blog/eventos_que_marcan_la_diferencia_tuevent.jpg" alt="Detail Image" style="width:100%; margin: 30px 0; border-radius: 8px;">
<h3>Cuidar los detalles en todas las fases del evento.</h3>
<p>El cuidado de los detalles ha de ser exhaustivo en cada una de las piezas que componen el engranaje de un gran evento. No hay que olvidar que cualquier imprevisto puede empañar el resto de la celebración, por lo que hay que anticiparse. Detalles en los que detenerse a la hora de crear un evento:</p>
<ol style="margin-left: 20px; margin-bottom: 20px;">
    <li><strong>La elección de la sede:</strong> la sede es la base de todo. Debe ser un espacio acorde a lo que se quiere transmitir. Cuidaremos de que sea de fácil acceso para todos, que cumpla con la normativa de seguridad y si además se trata de una sede sostenible, mucho mejor.</li>
    <li><strong>Los proveedores:</strong> rodearse de profesionales de confianza que ofrezcan un servicio de calidad. Debemos cuidar que los tiempos de montaje y desmontaje se cumplan, así como que el servicio durante el evento sea el adecuado.</li>
    <li><strong>El kit de bienvenida:</strong> es la primera toma de contacto con el invitado. Una forma de que se sienta parte del evento desde el primer momento. Por ello, si es personalizado y ofrece algo útil para el desarrollo del mismo, mejor.</li>
    <li><strong>El obsequio para ponentes y organizadores:</strong> Ni excesivo, ni escaso. También prima la originalidad y si puede ser personalizado mucho mejor.</li>
    <li><strong>El programa social:</strong> Dotará de contenido al evento, por eso es primordial. Debe ser coordinado y ofrecer actividades que den sentido al objetivo final del evento, por eso tiene que estar detallado a la perfección. Controlar el programa social puede ser una tarea difícil, pero os aseguramos que es una de las claves del éxito de tu evento.</li>
</ol>
<h3>¡Llegó la hora de demostrar que se ha cuidado hasta el último detalle del evento!</h3>
<p>Cuidar todas las fases tiene su recompensa y no dejar nada a la improvisación será el detonante para que tanto tu cliente como sus invitados disfruten de todas las piezas del evento, generando en ellos una visión y experiencia global inolvidable.</p>
HTML;

$html_post_2 = <<<HTML
<p>Las agencias de eventos con servicios integrales están en pleno auge. Ofrecer servicios a medida es la nueva moda a la hora de crear eventos. Proyectos llave en mano con el fin de ofrecer comodidad a los clientes, sin necesidad de recurrir a terceros.</p>
<p>Cada vez son más las empresas que optan por esta modalidad para que todos los aspectos técnicos, decorativos y humanos estén bajo el mismo paraguas creativo, garantizando que el diseño preconcebido en la primera reunión se materialice de forma perfecta en la fase final de producción.</p>
<img src="assets/images/blog/Sabor_granada_andalucia_sabor_agencia_tuevent_2019.jpg" alt="Sabor Granada Tuevent" style="width:100%; margin: 30px 0; border-radius: 8px;">
<h3>Ventajas de un proyecto "llave en mano":</h3>
<ol style="margin-left: 20px; margin-bottom: 20px;">
    <li><strong>Eventos a medida:</strong> Diseños centrados puramente en los objetivos específicos del cliente.</li>
    <li><strong>Sin intermediarios:</strong> Comunicación mucho más fluida, rápidez de ejecución y optimización de plazos y presupuestos.</li>
    <li><strong>Diseño profesional:</strong> Un equipo multidisciplinar formado por especialistas en Protocolo, Comunicación, PR y Producción visual, todos a una.</li>
    <li><strong>Resultados creativos íntegros:</strong> La coherencia visual se mantiene intacta desde el render en 3D hasta la estructura física en madera o truss.</li>
    <li><strong>Flexibilidad absoluta:</strong> El cliente siempre decide si desea implicarse en determinadas fases operativas o delegar la responsabilidad plena al equipo gestor.</li>
</ol>
<p><strong>El Caso de Éxito de Sabor Granada en Andalucía Sabor 2019:</strong><br>
Un ejemplo inmejorable del despliegue integral. Nuestro equipo de Tuevent se encargó del desarrollo espacial completo en el recinto Fibes de Sevilla. Trabajamos las áreas especializadas de showcooking y degustaciones, la impresión digital gran formato, y la arquitectura efímera completa necesaria para cobijar la amplia delegación granadina con éxito rotundo.
</p>
HTML;

$html_post_3 = <<<HTML
<p>Los negocios locales son el alma económica y social de una ciudad. Revitalizar los barrios a través de la organización de eventos es la estrategia de marketing experiencial más valorada actualmente por las asociaciones de comerciantes. Es la evolución natural de la venta.</p>
<img src="assets/images/blog/expo_peligros_2019_tuevent_autoridades_ayuntamiento_peligros_photocall.jpg" alt="Expo Peligros Tuevent" style="width:100%; margin: 30px 0; border-radius: 8px;">
<h3>Dinamización urbana como reclamo</h3>
<p>A través de la concepción de eventos corporativos y ferias en plena calle o recintos públicos (como Pop-up stores, Street Food markets o Showrooms colectivos), conseguimos generar un tráfico peatonal intensivo directamente hacia las zonas de interés comercial. El evento no es el fin, es la excusa perfecta para atraer al comprador local.</p>
<p>Además, al crear un punto de encuentro vecinal cálido y festivo, fortalecemos el vínculo emocional entre los residentes de la población y los comerciantes de toda la vida. Un sentimiento de comunidad que ninguna tienda online puede igualar.</p>
<h3>El Ejemplo de Expo Peligros 2019</h3>
<p>Llevado a cabo junto con el Ayuntamiento de Peligros y ASEMPE (Asociación de Empresarios de Peligros), materializamos un encuentro multidepartamental donde el tejido empresarial tuvo el protagonismo. A través de conciertos en directo, desfiles de moda de los establecimientos locales, y distintos talleres formativos y lúdicos, convertimos la exposición comercial en una auténtica fiesta de revitalización, consiguiendo un récord de visitantes y visibilidad de marca de los negocios involucrados.</p>
<p>En conclusión, el comercio local tiene en la organización de eventos profesionales a su mejor aliado no sólo para las jornadas de ventas directas, sino para crear una identidad de marca comunitaria sólida y perdurable.</p>
HTML;

$html_post_4 = <<<HTML
<h3>La pasión como motor de nacimiento</h3>
<p>Hoy estamos de estreno. Inauguramos de forma oficial el blog corporativo de la agencia Tuevent. Queremos que este espacio actúe como una ventana abierta a nuestro sector, donde periódicamente desgranaremos los misterios, las tendencias y los casos reales del vertiginoso mundo de la Organización de Eventos.</p>
<img src="assets/images/blog/RRSS_200px200px-04.png" alt="Logo Tuevent" style="max-width:300px; display:block; margin: 30px auto; border-radius: 8px;">
<p>Tuevent nace como agencia integral apostando fuertemente por cuatro valores fundamentales:</p>
<ol style="margin-left: 20px; margin-bottom: 20px;">
    <li><strong>Cercanía:</strong> Trato hiper-personalizado, nos convertimos en un miembro más de vuestra empresa.</li>
    <li><strong>Transparencia:</strong> Procesos operativos claros, presupuestos optimizados y sin sorpresas.</li>
    <li><strong>Creatividad:</strong> Rechazamos los eventos estándar. Cada producción tiene una identidad única, espectacular e inolvidable.</li>
    <li><strong>Compromiso Profesional:</strong> La obsesión por el detalle nos delata.</li>
</ol>
<p>Estamos capacitados para abarcar espectros amplísimos de servicio: desde elegantes Eventos Corporativos, Cumbres e Institucionales, Relaciones Públicas (PR), hasta la más dura Producción Técnica logísticamente perfecta, complementándolo todo con nuestra amplia experiencia en Gabinete de Comunicación y difusiones mediáticas.</p>
<p>Arrancamos este viaje emocionados e impacientes por transformar vuestras grandes ideas en eventos memorables.</p>
<p><em>Bienvenidos.</em><br>
Fdo: El equipo directivo de Tuevent.</p>
HTML;

$posts = [
    [
        'titulo' => 'Cuidar los detalles en un evento, de principio a fin, es lo que marca la diferencia.',
        'contenido' => 'Cuidar los detalles en todas las fases de un evento es primordial para marcar la diferencia.',
        'contenido_html' => $html_post_1,
        'imagen' => 'assets/images/blog/eventos_que_marcan_la_diferencia_tuevent.jpg',
        'fecha_publicacion' => '2019-10-03',
        'slug' => 'cuidar-los-detalles-en-un-evento-de-principio-a-fin-es-lo-que-marca-la-diferencia'
    ],
    [
        'titulo' => 'Proyectos llave en mano como última tendencia en los eventos.',
        'contenido' => 'Las agencias de eventos con servicios integrales están en pleno auge. Ofrecer servicios a medida es la nueva moda a la hora de crear eventos.',
        'contenido_html' => $html_post_2,
        'imagen' => 'assets/images/blog/Sabor_granada_andalucia_sabor_agencia_tuevent_2019.jpg',
        'fecha_publicacion' => '2019-09-30',
        'slug' => 'proyectos-llave-en-mano-como-ultima-tendencia-en-los-eventos'
    ],
    [
        'titulo' => 'Eventos que fomentan el comercio local.',
        'contenido' => 'Cómo hacer un evento local',
        'contenido_html' => $html_post_3,
        'imagen' => 'assets/images/blog/expo_peligros_2019_tuevent_autoridades_ayuntamiento_peligros_photocall.jpg',
        'fecha_publicacion' => '2019-09-16',
        'slug' => 'eventos-que-fomentan-el-comercio-local'
    ],
    [
        'titulo' => 'Bienvenidos a Tuevent',
        'contenido' => 'Bienvenida del Director a la agencia Tuevent. Inauguramos nuestro blog con la carta del director',
        'contenido_html' => $html_post_4,
        'imagen' => 'assets/images/blog/RRSS_200px200px-04.png',
        'fecha_publicacion' => '2019-07-02',
        'slug' => 'bienvenidos-a-tuevent'
    ]
];

$stmt = $pdo->prepare("INSERT INTO blog_posts (titulo, contenido, contenido_html, imagen, fecha_publicacion, slug) VALUES (?, ?, ?, ?, ?, ?)");

$count = 0;
foreach ($posts as $post) {
    if ($stmt->execute([$post['titulo'], $post['contenido'], $post['contenido_html'], $post['imagen'], $post['fecha_publicacion'], $post['slug']])) {
        $count++;
    }
}

echo "<p>Se han insertado $count entradas con el HTML extendido idéntico al sitio web.</p>";
echo "<a href='blog_tuevent.php'>Volver al blog</a>";
?>