SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(240) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `descripcion`) VALUES
(1, 'Música'),
(2, 'Libro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(40) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `contrasena` varchar(124) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_baja` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `apellidos`, `dni`, `direccion`, `fecha_nacimiento`, `telefono`, `correo`, `usuario`, `contrasena`, `borrado`, `fecha_alta`, `fecha_baja`) VALUES
(13, 'cliente', 'apellidos cliente', '12312121a', 'dsdada  sd sa ad sa', '1989-07-19', '890890890', 'cliente@gmail.com', 'cliente', '4983a0ab83ed86e0e7213c8783940193', 0, '2014-01-09 15:34:58', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `descripcion`) VALUES
(1, 'realizado'),
(2, 'pagado'),
(3, 'enviado'),
(4, 'finalizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iva`
--

CREATE TABLE IF NOT EXISTS `iva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(32) NOT NULL,
  `valor` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `iva`
--

INSERT INTO `iva` (`id`, `descripcion`, `valor`) VALUES
(1, 'General', 21),
(2, 'Reducido', 10),
(3, 'Superreducido', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea_venta`
--

CREATE TABLE IF NOT EXISTS `linea_venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_orden` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` double NOT NULL,
  `fk_venta` int(11) NOT NULL,
  `fk_producto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_producto` (`fk_producto`),
  KEY `fk_venta` (`fk_venta`),
  KEY `id_orden` (`id_orden`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `linea_venta`
--

INSERT INTO `linea_venta` (`id`, `id_orden`, `cantidad`, `precio`, `fk_venta`, `fk_producto`) VALUES
(1, 1, 1, 10.89, 7, 27),
(2, 1, 5, 10.89, 8, 27),
(3, 1, 1, 20.57, 9, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(256) NOT NULL,
  `descripcion` text NOT NULL,
  `fk_categoria` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_base` double NOT NULL,
  `fk_iva` int(11) NOT NULL,
  `fk_vendedor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria` (`fk_categoria`),
  KEY `fk_categoria_2` (`fk_categoria`),
  KEY `fk_iva` (`fk_iva`),
  KEY `fk_vendedor` (`fk_vendedor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `fk_categoria`, `stock`, `precio_base`, `fk_iva`, `fk_vendedor`) VALUES
(1, 'El cazador de sueños', 'Autor: Stephen King.<br> Había una vez cuatro chicos, compañeros en todo, que decidieron proteger a un chico indefenso atormentado por el tirano del colegio. Su acción marcó un cambio decisivo en sus vidas. Un cambio tan grande que tardarían 25 años en comprender su importancia... Ahora son adultos, con más problemas y más desilusiones, pero una vez al año se reúnen para cazar en los bosques de Maine. Este año un desconocido entra en su cabaña y, aturdido y confuso, balbucea que ha visto unas extrañas luces en el cielo. Y parece que no está equivocado... En poco tiempo los cuatro amigos se encuentran en medio de una lucha terrorífica contra seres de otro mundo. La única posibilidad de salvación radica en encontrar a aquel amigo del pasado, el que sabía cazar sueños y que también sabrá frustrar los sueños de los invasores... Una obra maestra del terror y una historia de ternura y amistad profunda.', 2, 6, 15, 1, 1),
(2, 'La llave del destino', 'Autor: Glenn Cooper. <br> Monasterio de Rouac, 1307. A las puertas de la muerte el abad y último monje de la hermandad quiere dejar constancia de su legado por escrito: el secreto que explica su enorme longevidad y que ha escondido con celo durante más de doscientos años. En unas misteriosas cuevas donde parece que solo haya roca caliza y húmeda oscuridad, se encuentra la fórmula de la eterna juventud. Un aparente milagro que sin embargo, puede convertirse en una maldición...', 2, 4, 16, 1, 1),
(3, 'Sueño mortal', 'Autor: Greg Iles. <br> Jordan Glass es una fotógrafa de éxito. Estando de vacaciones en Hong Kong, decide visitar el Museo de Arte. Allí observa que muchos la miran con curiosdad. Al cabo de unos minutos se encuentra con una exposición de un pintor anónimo titulada Mujeres desnudas en reposo, que exhibe una misteriosa serie de cuadros que han causado sensación en el mundo del arte moderno. Los expertos han llegado a la conclusión de que las telas muestran mujeres desnudas que no están dormidas, sino muertas… Cuando Jordan se acerca al último cuadro de la serie, la sangre se le congela: la mujer del cuadro es idéntica a ella misma. ', 2, 4, 19, 1, 1),
(4, 'El libro de las almas', 'Autor: Glenn Cooper <br>\r\nUn ex agente del FBI, que participó en uno de los descubrimiento más sorprendentes de la humanidad, el hallazgo de una biblioteca medieval con un legado de vida y muerte, debe ahora encontrar un libro perdido: un ejemplar de la biblioteca que contiene las claves del inquietante futuro que nos aguarda. EL DESTINO FINAL DE LA HUMANIDAD ESTÁ ESCRITO, PERO SOLO ALGUNOS LO SABEN. ¿QUÉ HARÍAS SI SUPIERAS LA FECHA DEL FIN DEL MUNDO? «Una obra que lleva más allá la maravillosa y terrorífica idea de La biblioteca de los muertos.» Corriere della Sera', 2, 10, 16, 1, 1),
(5, 'El fin de los escribas', 'Autor: Glenn Cooper <br>\r\nEl fin de los escribas, de Glenn Cooper, autor de otros libros como La llave del destino, es el esperado desenlace de la trilogía de La biblioteca de los muertos (La biblioteca de los muertos, El libro de las almas) Esta novela negra está ambientada en el año 2026. Mientras una humanidad conmocionada se acerca a la fatídic a fecha del fin del mundo, una joven afirma tener una información que podría cambiar un destino que todos creen inmutable: ¿y si la orden de los escribas no se hubiera extinguido con el suicidio colectivo de la abadía de Vectis en 1296? ¿Es posible cambiar el destino?', 2, 3, 17, 1, 1),
(6, 'El libro de los muertos', 'Autor: Glenn Cooper <br>\r\nBretaña, siglo VII. En la abadía de Vectis crece Octavus, un niño al que le auguran poderes diabólicos. Octavus no tarda en empezar a escribir una lista de nombres y fechas sin ningún sentido aparente. Pero poco después, cuando una muerte en la abadíacoincide con un nombre y una fecha de la lista, el miedo se apodera de los monjes. Nueva York, en la actualidad. Un asesino en serie tiene atemorizada a toda la ciudad. Poco antes de morir, las víctimas reciben una postal con la fecha de su muerte escrita. ¿Quién está detrás de estas muertes? Un secreto escalofriante, oculto desde hace siglos, está a punto de ser revelado. Un thriller soberbio dotado de una intriga estremecedora que ya ha conquistado a más de un millón de lectores en todo el mundo."Un libro increíble."Katherine Neville"Un thriller inteligente, una novela inolvidable."Book Reporter"La biblioteca de los muertos no pierde ritmo ni tan siquiera cuando se aventura en busca de los secretos de un convento que recuerda al de Umberto Eco."Corriere della Sera', 2, 4, 21, 1, 1),
(27, 'El evangelio del mal', 'Autor: Patrick Graham.\r\nNorte de Italia, siglo XIV: una monja se condena a una muerte horrible para ocultar un texto maldito que procede de las sombras de la historia. Siglos más tarde, una agente del FBI y un sacerdote exorcista se lanzan a una angustiosa aventura en la que desafían a la muerte ya la personificación misma del Mal. Su objetivo: ha llar un escrito, desaparecido en la época medieval, cuyo contenido podría hacer que el mundo quedara a merced de los adoradores del diablo.', 2, 12, 9, 1, 1),
(29, 'La hija del apocalipsis', 'Autor: Patrick Graham.\r\nUNA NARRACIÓN APOCALÍPTICA DE ACCIÓN, AVENTURA Y FANTASÍAEN LA QUE UNA NIÑA SE CONVIERTE EN LA ÚNICA ESPERANZA PARA SALVAR A LA HUMANIDAD."Patrick Graham nos propone una persecución en plena tempestad que deja sin aliento, con escenarios grandiosos y una ambientación propia del fin del mundo. Una novela de una fuerza increí ble."Page des Librairies"Un thriller al límite de lo fantástico. Tras El evangelio del mal, premio Maisons de la Presse, La hija del Apocalipsis es una novela de la que no podrás escapar."Livres Hebdo"Alta tecnología, complots, ultraviolencia, huracanes y búsqueda místico-bíblica: Graham es un francés que domina perfectamente los ingredientes del best seller estadounidense. Terriblemente bien hecho."Hebdomadaire Paris"Un thriller tan fantástico como terrorífico y fascinante. Una intriga de trama apasionante y suspense creciente que se vive como una persecución de desenlace imprevisible."Le Point', 2, 2, 10, 1, 1),
(30, 'El juego de Ender', 'El juego de Ender, de Orson Scott Card, autor de otras obras como La tierra desprevenida o Sombras en fuga, es la novela de mayor aceptación en la moderna narrativa de ciencia ficción. El juego de Ender ha dado lugar a una saga con millones de seguidores. Escritor prolífico, Orson Scott Card es autor de numerosas novelas y sagas, como la del Retorno, la de Ender y la de fantasía protagonizada por Alvin Maker, el Hacedor. Ha obtenido numerosos premios, entre ellos el Nebula de 1985 y el Hugo de 1986 a la mejor novela por la presente El juego de Ender y el Nebula de 1986 y el Hugo de 1987 por La voz de los muertos. La Tierra se ve amenazada por una raza extraterrestre, los insectores, que se comunican telepáticamente y consideran no tener nada en común con los humanos, a quienes pretenden destruir. Para vencerlos es necesario una nueva clase de genio militar, y por ello se ha permitido el nacimiento de Ender, lo que constituye, en cierta forma, una anomalía, pues es el tercer hijo de una pareja en un mundo que ha limitado estrictamente a dos el número de descendientes. El niño Ender deberá aprender todo lo relativo a la guerra en los videojuegos y en los peligrosos ensayos de batallas espaciales que realiza con sus compañeros. A la habilidad en el tratamiento de las emociones, ya característica de Orson Scott Card, se une en este libro el interés por el empleo de las simulaciones por ordenador y los juegos de fantasía en la formación militar, estratégica y psicológica del protagonista. «El juego de Ender es una novela de acción y aventuras trepidante, pero también un libro moralmente complejo y profundo. Card transforma una aventura casi juvenil en una historia trágica sobre la destrucción de la única especie sensible que el hombre ha descubierto en el universo.» HoustonPost «Una historia con acción e ideas que hasta quienes no leen ciencia ficción devorarán con avidez.» Ipulp Fiction', 2, 11, 18, 1, 1),
(31, 'El maestro del prado', 'Juan Eslava Galán recomienda: ?Una obra maestra que abre ventanas a un mundo apasionante. Una lectura que cambia para siempre nuestra visión del arte?. El maestro del prado y las pinturas proféticas, de Javier Sierra, autor de obras como Roswell: secreto de estado o Las puertas templarias, es una novela negra con la que d escubriremos de la mano de su autor los secretos que se ocultan tras las pinturas más importantes del Museo del Prado. Javier Sierra es el único autor español contemporáneo que ha logrado situar sus novelas en el top ten de los libros más vendidos en Estados Unidos. Sus obras se traducen a más de cuarenta idiomas y son fuente de inspiración para muchos lectores que buscan algo más que entretenimiento en un relato de intriga. Formado en el mundo del periodismo ?fue director de la revista Más Allá de la Ciencia durante siete años, además de presentador y director de espacios en radio y televisión-, ahora invierte su tiempo en investigar arcanos de la Historia y escribir sobre ellos. Al más puro estilo de los relatos de enigmas de Javier Sierra. El maestro del Prado presenta un apasionante recorrido por las historias más desconocidas y secretas de una de las pinacotecas más importantes del mundo, el Museo del Prado. Una historia fascinante de cómo un aprendiz de escritor aprendió a mirar cuadros y a entender unos mensajes ocultos que difieren de la ortodoxia de la Iglesia católica, una institución que en el Renacimiento era visto más como opresores que como espiritual. Una nueva obra que entusiasmará a los miles de seguidores de Javier Sierra.', 2, 5, 19, 1, 1),
(33, 'Inferno 3', 'autor Dan Brown vuelve a los misterios históricos con su personaje favorito, el profesor de simbología Robert Langdon, con la  novela Inferno, inspirada en La Divina Comedia de Dante y que saldrá a la venta el 16 de mayo. En sus bestsellers internacionales El código Da Vinci, Ángeles y demonios y El símbolo perdido, Dan Brown au nó con maestría historia, arte, códigos y símbolos. En su fascinante nuevo thriller, Brown recupera su esencia con su novela más ambiciosa hasta la fecha. En el corazón de Italia, el catedrático de Simbología de Harvard Robert Langdon se ve arrastrado a un mundo terrorífico centrado en una de las obras maestras de la Literatura más imperecederas y misteriosas de la Historia: el Infierno de Dante. Con este telón de fondo, Langdon se enfrenta a un adversario escalofriante y lidia con un acertijo ingenioso en un escenario de arte clásico, pasadizos secretos y ciencia futurista. Apoyándose en el oscuro poema épico de Dante, Langdon, en una carrera contrarreloj, busca respuestas y personas de confianza antes de que el mundo cambie irrevocablemente.', 2, 6, 10, 1, 1),
(34, 'José Luis Perales - Mis 30 Mejores Canciones (1994)', 'Ficha Técnica:<br>\n', 1, 10, 24, 1, 1),
(35, 'Linkin Park - Underground XIII ', 'Lanzamiento: November 18, 2013\r\nLonguitud: 42:90\r\nGenero: Nu metal, rap rock, industrial metal, electronic rock\r\nLabel: Machine Shop\r\nProductor: Mike Shinoda, Linkin Park\r\nTracklist:\r\n1Basquiat (2007 Demo)\r\n2Holding Company (Lost in the Echo 2011 Demo)\r\n3Primo (I''ll Be Gone, Longform 2010 Demo)\r\n4Hemispheres (2011 Demo)\r\n5Cumulus (2002 Demo)\r\n6Pretty Birdy (Somewhere I Belong 2002 Demo)\r\n7Universe (2006 Demo)\r\n8Apaches (Until It Breaks Demo, No. 1)\r\n9Foot Patrol (Until It Breaks Demo, No. 2)\r\n10Three Band Terror (Until It Breaks, No. 3)\r\n11Truth Inside a Lie (By Ryan Giles, LPU Sessions 2013)\r\n12Change (By Beta State, LPU Sessions 2013)', 1, 12, 14, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE IF NOT EXISTS `vendedor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contrasena` varchar(32) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `vendedor`
--

INSERT INTO `vendedor` (`id`, `contrasena`, `usuario`) VALUES
(1, '81dc9bdb52d04dc20036dbd8313ed055', 'vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE IF NOT EXISTS `venta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` double NOT NULL,
  `fk_estado` int(11) NOT NULL,
  `fk_cliente` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente` (`fk_cliente`),
  KEY `fk_estado` (`fk_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `fecha`, `total`, `fk_estado`, `fk_cliente`) VALUES
(7, '2014-01-09 16:02:50', 10.89, 1, 13),
(8, '2014-01-09 16:03:21', 10.89, 1, 13),
(9, '2014-01-09 16:25:39', 20.57, 1, 13);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `linea_venta`
--
ALTER TABLE `linea_venta`
  ADD CONSTRAINT `linea_venta_ibfk_1` FOREIGN KEY (`fk_venta`) REFERENCES `venta` (`id`),
  ADD CONSTRAINT `linea_venta_ibfk_2` FOREIGN KEY (`fk_producto`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`fk_categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`fk_iva`) REFERENCES `iva` (`id`),
  ADD CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`fk_vendedor`) REFERENCES `vendedor` (`id`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`fk_estado`) REFERENCES `estado` (`id`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`fk_cliente`) REFERENCES `cliente` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
