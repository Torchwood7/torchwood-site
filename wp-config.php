<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/admin/web/torchwood.ml/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'admin_wordpress');

/** Имя пользователя MySQL */
define('DB_USER', 'admin_wordpress');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'qXUnwk26hV');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ' P#@I}Fs-NcR-BO7UVP/^MB+An(%cbx$0sXILiR8*Dc)&%R9}6X8W,7R1wdZ4mXH');
define('SECURE_AUTH_KEY',  'rCF7s3[5N-4 Y4lP@Bm MXtQyd35}VqE>e,M#@O)vvc3QQF_^>{J0l6?&[O )(Hw');
define('LOGGED_IN_KEY',    'e}NjTIPv_~RX08}74E=|+}55F1!-m>91y|&R(~~ #r9rO:l+dr8wDW.*5:q{Y$4.');
define('NONCE_KEY',        '=PYY:ZppmQN@1g}G?K1QUHh=t#)Efsv{@.8n)+/s |2AW V{Nx5x=_9bB1P0xF.8');
define('AUTH_SALT',        '0sV_TS16xmL^}yUjnU1D_lT9[C3Tj|JQ}Xeih{XJ:tu<iK1+v2F7$<M/+;?-Sx$Q');
define('SECURE_AUTH_SALT', '`*~QtB/CTu]xKRAW$x93`B|0%4,)|3-^fRda<cP]z$$lDx!a&A*1O:T:bNhem@W[');
define('LOGGED_IN_SALT',   'M_Yl_.VSW{$/jo*BFDcBMC{Q(1-k.,9?aC@t+u3A+8-[Y+62muq|-|*^m^0C &l ');
define('NONCE_SALT',       'wB;$F!r+U+ze@xh+>_Z<SXQM<?]%rq+0^C>Ov8#} r`0l<?U*t%)<Nis+&DfS99!');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
