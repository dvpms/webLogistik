<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('VERSION', '2.8.14');
if (file_exists(dirname(__FILE__) . '/timthumb-config.php')) require_once('timthumb-config.php');
if (!defined('DEBUG_ON')) define('DEBUG_ON', false);
if (!defined('DEBUG_LEVEL')) define('DEBUG_LEVEL', 1);
if (!defined('MEMORY_LIMIT')) define('MEMORY_LIMIT', '30M');
if (!defined('BLOCK_EXTERNAL_LEECHERS')) define('BLOCK_EXTERNAL_LEECHERS', false);
if (!defined('DISPLAY_ERROR_MESSAGES')) define('DISPLAY_ERROR_MESSAGES', false);
if (!defined('ALLOW_EXTERNAL')) define('ALLOW_EXTERNAL', TRUE);
if (!defined('ALLOW_ALL_EXTERNAL_SITES')) define('ALLOW_ALL_EXTERNAL_SITES', TRUE);
if (!defined('FILE_CACHE_ENABLED')) define('FILE_CACHE_ENABLED', TRUE);
if (!defined('FILE_CACHE_TIME_BETWEEN_CLEANS')) define('FILE_CACHE_TIME_BETWEEN_CLEANS', 86400);
if (!defined('FILE_CACHE_MAX_FILE_AGE')) define('FILE_CACHE_MAX_FILE_AGE', 86400);
if (!defined('FILE_CACHE_SUFFIX')) define('FILE_CACHE_SUFFIX', '.timthumb.txt');
if (!defined('FILE_CACHE_PREFIX')) define('FILE_CACHE_PREFIX', 'timthumb');
if (!defined('FILE_CACHE_DIRECTORY')) define('FILE_CACHE_DIRECTORY', APPPATH . 'cache/images');
if (!defined('MAX_FILE_SIZE')) define('MAX_FILE_SIZE', 10485760);
if (!defined('CURL_TIMEOUT')) define('CURL_TIMEOUT', 10);
if (!defined('WAIT_BETWEEN_FETCH_ERRORS')) define('WAIT_BETWEEN_FETCH_ERRORS', 3600);
if (!defined('BROWSER_CACHE_MAX_AGE')) define('BROWSER_CACHE_MAX_AGE', 864000);
if (!defined('BROWSER_CACHE_DISABLE')) define('BROWSER_CACHE_DISABLE', false);
if (!defined('MAX_WIDTH')) define('MAX_WIDTH', 1500);
if (!defined('MAX_HEIGHT')) define('MAX_HEIGHT', 1500);
if (!defined('NOT_FOUND_IMAGE')) define('NOT_FOUND_IMAGE', '');
if (!defined('ERROR_IMAGE')) define('ERROR_IMAGE', '');
if (!defined('PNG_IS_TRANSPARENT')) define('PNG_IS_TRANSPARENT', FALSE);
if (!defined('DEFAULT_Q')) define('DEFAULT_Q', 90);
if (!defined('DEFAULT_ZC')) define('DEFAULT_ZC', 1);
if (!defined('DEFAULT_F')) define('DEFAULT_F', '');
if (!defined('DEFAULT_S')) define('DEFAULT_S', 0);
if (!defined('DEFAULT_CC')) define('DEFAULT_CC', 'ffffff');
if (!defined('DEFAULT_WIDTH')) define('DEFAULT_WIDTH', 150);
// if (!defined('DEFAULT_HEIGHT')) define('DEFAULT_HEIGHT', 150);
if (!defined('OPTIPNG_ENABLED')) define('OPTIPNG_ENABLED', false);
if (!defined('OPTIPNG_PATH')) define('OPTIPNG_PATH', '/usr/bin/optipng');
if (!defined('PNGCRUSH_ENABLED')) define('PNGCRUSH_ENABLED', false);
if (!defined('PNGCRUSH_PATH')) define('PNGCRUSH_PATH', '/usr/bin/pngcrush');
if (!defined('WEBSHOT_ENABLED')) define('WEBSHOT_ENABLED', false);
if (!defined('WEBSHOT_CUTYCAPT')) define('WEBSHOT_CUTYCAPT', '/usr/local/bin/CutyCapt');
if (!defined('WEBSHOT_XVFB')) define('WEBSHOT_XVFB', '/usr/bin/xvfb-run');
if (!defined('WEBSHOT_SCREEN_X')) define('WEBSHOT_SCREEN_X', '1024');
if (!defined('WEBSHOT_SCREEN_Y')) define('WEBSHOT_SCREEN_Y', '768');
if (!defined('WEBSHOT_COLOR_DEPTH')) define('WEBSHOT_COLOR_DEPTH', '24');
if (!defined('WEBSHOT_IMAGE_FORMAT')) define('WEBSHOT_IMAGE_FORMAT', 'png');
if (!defined('WEBSHOT_TIMEOUT')) define('WEBSHOT_TIMEOUT', '20');
if (!defined('WEBSHOT_USER_AGENT')) define('WEBSHOT_USER_AGENT', "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.2.18) Gecko/20110614 Firefox/3.6.18");
if (!defined('WEBSHOT_JAVASCRIPT_ON')) define('WEBSHOT_JAVASCRIPT_ON', true);
if (!defined('WEBSHOT_JAVA_ON')) define('WEBSHOT_JAVA_ON', false);
if (!defined('WEBSHOT_PLUGINS_ON')) define('WEBSHOT_PLUGINS_ON', true);
if (!defined('WEBSHOT_PROXY')) define('WEBSHOT_PROXY', '');
if (!defined('WEBSHOT_XVFB_RUNNING')) define('WEBSHOT_XVFB_RUNNING', false);
if (!isset($ALLOWED_SITES)) $ALLOWED_SITES = array('blogspot.com','wordpress.com');
timthumb::start();
class timthumb {
	protected $src = "";
	protected $is404 = false;
	protected $docRoot = "";
	protected $lastURLError = false;
	protected $localImage = "";
	protected $localImageMTime = 0;
	protected $url = false;
	protected $myHost = "";
	protected $isURL = false;
	protected $cachefile = '';
	protected $errors = array();
	protected $toDeletes = array();
	protected $cacheDirectory = '';
	protected $startTime = 0;
	protected $lastBenchTime = 0;
	protected $cropTop = false;
	protected $salt = "";
	protected $fileCacheVersion = 1;
	protected $filePrependSecurityBlock = "<?php die('Execution denied!'); //";
	protected static $curlDataWritten = 0;
	protected static $curlFH = false;
	public static function start() {
		$tim = new timthumb();
		$tim->handleErrors();
		$tim->securityChecks();
		if ($tim->tryBrowserCache()) {
			exit(0);
		}
		$tim->handleErrors();
		if (FILE_CACHE_ENABLED && $tim->tryServerCache()) {
			exit(0);
		}
		$tim->handleErrors();
		$tim->run();
		$tim->handleErrors();
		exit(0);
	}
	public function __construct() {
		global $ALLOWED_SITES;
		$this->startTime = microtime(true);
		date_default_timezone_set('UTC');
		$this->debug(1, "Starting new request from " . $this->getIP() . " to " . $_SERVER['REQUEST_URI']);
		$this->calcDocRoot();
		$this->salt = @filemtime(__FILE__) . '-' . @fileinode(__FILE__);
		$this->debug(3, "Salt is: " . $this->salt);
		if (FILE_CACHE_DIRECTORY) {
			if (!is_dir(FILE_CACHE_DIRECTORY)) {
				@mkdir(FILE_CACHE_DIRECTORY);
				if (!is_dir(FILE_CACHE_DIRECTORY)) {
					$this->error("Could not create the file cache directory.");
					return false;
				}
			}
			$this->cacheDirectory = FILE_CACHE_DIRECTORY;
			if (!touch($this->cacheDirectory . '/index.html')) {
				$this->error("Could not create the index.html file - to fix this create an empty file named index.html file in the cache directory.");
			}
		} else {
			$this->cacheDirectory = sys_get_temp_dir();
		}
		$this->cleanCache();
		$this->myHost = preg_replace('/^www\./i', '', $_SERVER['HTTP_HOST']);
		$this->src    = $this->param('src');
		$this->url    = parse_url($this->src);
		$this->src    = preg_replace('/https?:\/\/(?:www\.)?' . $this->myHost . '/i', '', $this->src);
		if (strlen($this->src) <= 3) {
			$this->error("No image specified");
			return false;
		}
		if (BLOCK_EXTERNAL_LEECHERS && array_key_exists('HTTP_REFERER', $_SERVER) && (!preg_match('/^https?:\/\/(?:www\.)?' . $this->myHost . '(?:$|\/)/i', $_SERVER['HTTP_REFERER']))) {
			$imgData = base64_decode("R0lGODlhUAAMAIAAAP8AAP///yH5BAAHAP8ALAAAAABQAAwAAAJpjI+py+0Po5y0OgAMjjv01YUZ\nOGplhWXfNa6JCLnWkXplrcBmW+spbwvaVr/cDyg7IoFC2KbYVC2NQ5MQ4ZNao9Ynzjl9ScNYpneb\nDULB3RP6JuPuaGfuuV4fumf8PuvqFyhYtjdoeFgAADs=");
			header('Content-Type: image/gif');
			header('Content-Length: ' . strlen($imgData));
			header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
			header("Pragma: no-cache");
			header('Expires: ' . gmdate('D, d M Y H:i:s', time()));
			echo $imgData;
			return false;
			exit(0);
		}
		if (preg_match('/^https?:\/\/[^\/]+/i', $this->src)) {
			$this->debug(2, "Is a request for an external URL: " . $this->src);
			$this->isURL = true;
		} else {
			$this->debug(2, "Is a request for an internal file: " . $this->src);
		}
		if ($this->isURL && (!ALLOW_EXTERNAL)) {
			$this->error("You are not allowed to fetch images from an external website.");
			return false;
		}
		if ($this->isURL) {
			if (ALLOW_ALL_EXTERNAL_SITES) {
				$this->debug(2, "Fetching from all external sites is enabled.");
			} else {
				$this->debug(2, "Fetching only from selected external sites is enabled.");
				$allowed = false;
				foreach ($ALLOWED_SITES as $site) {
					if ((strtolower(substr($this->url['host'], -strlen($site) - 1)) === strtolower(".$site")) || (strtolower($this->url['host']) === strtolower($site))) {
						$this->debug(3, "URL hostname {$this->url['host']} matches $site so allowing.");
						$allowed = true;
					}
				}
				if (!$allowed) {
					return $this->error("You may not fetch images from that site. To enable this site in timthumb, you can either add it to \$ALLOWED_SITES and set ALLOW_EXTERNAL=true. Or you can set ALLOW_ALL_EXTERNAL_SITES=true, depending on your security needs.");
				}
			}
		}
		$cachePrefix = ($this->isURL ? '_ext_' : '_int_');
		if ($this->isURL) {
			$arr = explode('&', $_SERVER['QUERY_STRING']);
			asort($arr);
			$this->cachefile = $this->cacheDirectory . '/' . FILE_CACHE_PREFIX . $cachePrefix . md5($this->salt . implode('', $arr) . $this->fileCacheVersion) . FILE_CACHE_SUFFIX;
		} else {
			$this->localImage = $this->getLocalImagePath($this->src);
			if (!$this->localImage) {
				$this->debug(1, "Could not find the local image: {$this->localImage}");
				$this->error("Could not find the internal image you specified.");
				$this->set404();
				return false;
			}
			$this->debug(1, "Local image path is {$this->localImage}");
			$this->localImageMTime = @filemtime($this->localImage);
			$this->cachefile       = $this->cacheDirectory . '/' . FILE_CACHE_PREFIX . $cachePrefix . md5($this->salt . $this->localImageMTime . $_SERVER['QUERY_STRING'] . $this->fileCacheVersion) . FILE_CACHE_SUFFIX;
		}
		$this->debug(2, "Cache file is: " . $this->cachefile);
		return true;
	}
	public function __destruct() {
		foreach ($this->toDeletes as $del) {
			$this->debug(2, "Deleting temp file $del");
			@unlink($del);
		}
	}
	public function run() {
		if ($this->isURL) {
			if (!ALLOW_EXTERNAL) {
				$this->debug(1, "Got a request for an external image but ALLOW_EXTERNAL is disabled so returning error msg.");
				$this->error("You are not allowed to fetch images from an external website.");
				return false;
			}
			$this->debug(3, "Got request for external image. Starting serveExternalImage.");
			if ($this->param('webshot')) {
				if (WEBSHOT_ENABLED) {
					$this->debug(3, "webshot param is set, so we're going to take a webshot.");
					$this->serveWebshot();
				} else {
					$this->error("You added the webshot parameter but webshots are disabled on this server. You need to set WEBSHOT_ENABLED == true to enable webshots.");
				}
			} else {
				$this->debug(3, "webshot is NOT set so we're going to try to fetch a regular image.");
				$this->serveExternalImage();
			}
		} else {
			$this->debug(3, "Got request for internal image. Starting serveInternalImage()");
			$this->serveInternalImage();
		}
		return true;
	}
	protected function handleErrors() {
		if ($this->haveErrors()) {
			if (NOT_FOUND_IMAGE && $this->is404()) {
				if ($this->serveImg(NOT_FOUND_IMAGE)) {
					exit(0);
				} else {
					$this->error("Additionally, the 404 image that is configured could not be found or there was an error serving it.");
				}
			}
			if (ERROR_IMAGE) {
				if ($this->serveImg(ERROR_IMAGE)) {
					exit(0);
				} else {
					$this->error("Additionally, the error image that is configured could not be found or there was an error serving it.");
				}
			}
			$this->serveErrors();
			exit(0);
		}
		return false;
	}
	protected function tryBrowserCache() {
		if (BROWSER_CACHE_DISABLE) {
			$this->debug(3, "Browser caching is disabled");
			return false;
		}
		if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			$this->debug(3, "Got a conditional get");
			$mtime = false;
			if (!is_file($this->cachefile)) {
				return false;
			}
			if ($this->localImageMTime) {
				$mtime = $this->localImageMTime;
				$this->debug(3, "Local real file's modification time is $mtime");
			} else if (is_file($this->cachefile)) {
				$mtime = @filemtime($this->cachefile);
				$this->debug(3, "Cached file's modification time is $mtime");
			}
			if (!$mtime) {
				return false;
			}
			$iftime = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
			$this->debug(3, "The conditional get's if-modified-since unixtime is $iftime");
			if ($iftime < 1) {
				$this->debug(3, "Got an invalid conditional get modified since time. Returning false.");
				return false;
			}
			if ($iftime < $mtime) {
				$this->debug(3, "File has been modified since last fetch.");
				return false;
			} else {
				$this->debug(3, "File has not been modified since last get, so serving a 304.");
				header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
				$this->debug(1, "Returning 304 not modified");
				return true;
			}
		}
		return false;
	}
	protected function tryServerCache() {
		$this->debug(3, "Trying server cache");
		if (file_exists($this->cachefile)) {
			$this->debug(3, "Cachefile {$this->cachefile} exists");
			if ($this->isURL) {
				$this->debug(3, "This is an external request, so checking if the cachefile is empty which means the request failed previously.");
				if (filesize($this->cachefile) < 1) {
					$this->debug(3, "Found an empty cachefile indicating a failed earlier request. Checking how old it is.");
					if (time() - @filemtime($this->cachefile) > WAIT_BETWEEN_FETCH_ERRORS) {
						$this->debug(3, "File is older than " . WAIT_BETWEEN_FETCH_ERRORS . " seconds. Deleting and returning false so app can try and load file.");
						@unlink($this->cachefile);
						return false;
					} else {
						$this->debug(3, "Empty cachefile is still fresh so returning message saying we had an error fetching this image from remote host.");
						$this->set404();
						$this->error("An error occured fetching image.");
						return false;
					}
				}
			} else {
				$this->debug(3, "Trying to serve cachefile {$this->cachefile}");
			}
			if ($this->serveCacheFile()) {
				$this->debug(3, "Succesfully served cachefile {$this->cachefile}");
				return true;
			} else {
				$this->debug(3, "Failed to serve cachefile {$this->cachefile} - Deleting it from cache.");
				@unlink($this->cachefile);
				return true;
			}
		}
	}
	protected function error($err) {
		$this->debug(3, "Adding error message: $err");
		$this->errors[] = $err;
		return false;
	}
	protected function haveErrors() {
		if (sizeof($this->errors) > 0) {
			return true;
		}
		return false;
	}
	protected function serveErrors() {
		if (!DISPLAY_ERROR_MESSAGES) {
			echo '<body bgcolor="#272B30"></body>';
			die();
		}
		$html = '<ul>';
		foreach ($this->errors as $err) {
			$html .= '<li>' . htmlentities($err) . '</li>';
		}
		$html .= '</ul>';
		echo '<h1>A TimThumb error has occured</h1>The following error(s) occured:<br />' . $html . '<br />';
		echo '<br />Query String : ' . htmlentities($_SERVER['QUERY_STRING'], ENT_QUOTES);
		echo '<br />TimThumb version : ' . VERSION . '</pre>';
	}
	protected function serveInternalImage() {
		$this->debug(3, "Local image path is $this->localImage");
		if (!$this->localImage) {
			$this->sanityFail("localImage not set after verifying it earlier in the code.");
			return false;
		}
		$fileSize = filesize($this->localImage);
		if ($fileSize > MAX_FILE_SIZE) {
			$this->error("The file you specified is greater than the maximum allowed file size.");
			return false;
		}
		if ($fileSize <= 0) {
			$this->error("The file you specified is <= 0 bytes.");
			return false;
		}
		$this->debug(3, "Calling processImageAndWriteToCache() for local image.");
		if ($this->processImageAndWriteToCache($this->localImage)) {
			$this->serveCacheFile();
			return true;
		} else {
			return false;
		}
	}
	protected function cleanCache() {
		if (FILE_CACHE_TIME_BETWEEN_CLEANS < 0) {
			return;
		}
		$this->debug(3, "cleanCache() called");
		$lastCleanFile = $this->cacheDirectory . '/timthumb_cacheLastCleanTime.touch';
		if (!is_file($lastCleanFile)) {
			$this->debug(1, "File tracking last clean doesn't exist. Creating $lastCleanFile");
			if (!touch($lastCleanFile)) {
				$this->error("Could not create cache clean timestamp file.");
			}
			return;
		}
		if (@filemtime($lastCleanFile) < (time() - FILE_CACHE_TIME_BETWEEN_CLEANS)) {
			$this->debug(1, "Cache was last cleaned more than " . FILE_CACHE_TIME_BETWEEN_CLEANS . " seconds ago. Cleaning now.");
			if (!touch($lastCleanFile)) {
				$this->error("Could not create cache clean timestamp file.");
			}
			$files = glob($this->cacheDirectory . '/*' . FILE_CACHE_SUFFIX);
			if ($files) {
				$timeAgo = time() - FILE_CACHE_MAX_FILE_AGE;
				foreach ($files as $file) {
					if (@filemtime($file) < $timeAgo) {
						$this->debug(3, "Deleting cache file $file older than max age: " . FILE_CACHE_MAX_FILE_AGE . " seconds");
						@unlink($file);
					}
				}
			}
			return true;
		} else {
			$this->debug(3, "Cache was cleaned less than " . FILE_CACHE_TIME_BETWEEN_CLEANS . " seconds ago so no cleaning needed.");
		}
		return false;
	}
	protected function processImageAndWriteToCache($localImage) {
		$sData    = getimagesize($localImage);
		$origType = $sData[2];
		$mimeType = $sData['mime'];
		$this->debug(3, "Mime type of image is $mimeType");
		if (!preg_match('/^image\/(?:gif|jpg|jpeg|png)$/i', $mimeType)) {
			return $this->error("The image being resized is not a valid gif, jpg or png.");
		}
		if (!function_exists('imagecreatetruecolor')) {
			return $this->error('GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library');
		}
		if (function_exists('imagefilter') && defined('IMG_FILTER_NEGATE')) {
			$imageFilters = array(
				1 => array(
					IMG_FILTER_NEGATE,
					0
				),
				2 => array(
					IMG_FILTER_GRAYSCALE,
					0
				),
				3 => array(
					IMG_FILTER_BRIGHTNESS,
					1
				),
				4 => array(
					IMG_FILTER_CONTRAST,
					1
				),
				5 => array(
					IMG_FILTER_COLORIZE,
					4
				),
				6 => array(
					IMG_FILTER_EDGEDETECT,
					0
				),
				7 => array(
					IMG_FILTER_EMBOSS,
					0
				),
				8 => array(
					IMG_FILTER_GAUSSIAN_BLUR,
					0
				),
				9 => array(
					IMG_FILTER_SELECTIVE_BLUR,
					0
				),
				10 => array(
					IMG_FILTER_MEAN_REMOVAL,
					0
				),
				11 => array(
					IMG_FILTER_SMOOTH,
					0
				)
			);
		}
		$new_width    = (int) abs($this->param('w', 0));
		$new_height   = (int) abs($this->param('h', 0));
		$zoom_crop    = (int) $this->param('zc', DEFAULT_ZC);
		$quality      = (int) abs($this->param('q', DEFAULT_Q));
		$align        = $this->cropTop ? 't' : $this->param('a', 'c');
		$filters      = $this->param('f', DEFAULT_F);
		$sharpen      = (bool) $this->param('s', DEFAULT_S);
		$canvas_color = $this->param('cc', DEFAULT_CC);
		$canvas_trans = (bool) $this->param('ct', '1');
		if ($new_width == 0 && $new_height == 0) {
			$new_width  = (int) DEFAULT_WIDTH;
			$new_height = (int) DEFAULT_HEIGHT;
		}
		$new_width  = min($new_width, MAX_WIDTH);
		$new_height = min($new_height, MAX_HEIGHT);
		$this->setMemoryLimit();
		$image = $this->openImage($mimeType, $localImage);
		if ($image === false) {
			return $this->error('Unable to open image.');
		}
		$width    = imagesx($image);
		$height   = imagesy($image);
		$origin_x = 0;
		$origin_y = 0;
		if ($new_width && !$new_height) {
			$new_height = floor($height * ($new_width / $width));
		} else if ($new_height && !$new_width) {
			$new_width = floor($width * ($new_height / $height));
		}
		if ($zoom_crop == 3) {
			$final_height = $height * ($new_width / $width);
			if ($final_height > $new_height) {
				$new_width = $width * ($new_height / $height);
			} else {
				$new_height = $final_height;
			}
		}
		$canvas = imagecreatetruecolor($new_width, $new_height);
		imagealphablending($canvas, false);
		if (strlen($canvas_color) == 3) {
			$canvas_color = str_repeat(substr($canvas_color, 0, 1), 2) . str_repeat(substr($canvas_color, 1, 1), 2) . str_repeat(substr($canvas_color, 2, 1), 2);
		} else if (strlen($canvas_color) != 6) {
			$canvas_color = DEFAULT_CC;
		}
		$canvas_color_R = hexdec(substr($canvas_color, 0, 2));
		$canvas_color_G = hexdec(substr($canvas_color, 2, 2));
		$canvas_color_B = hexdec(substr($canvas_color, 4, 2));
		if (preg_match('/^image\/png$/i', $mimeType) && !PNG_IS_TRANSPARENT && $canvas_trans) {
			$color = imagecolorallocatealpha($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 127);
		} else {
			$color = imagecolorallocatealpha($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 0);
		}
		imagefill($canvas, 0, 0, $color);
		if ($zoom_crop == 2) {
			$final_height = $height * ($new_width / $width);
			if ($final_height > $new_height) {
				$origin_x  = $new_width / 2;
				$new_width = $width * ($new_height / $height);
				$origin_x  = round($origin_x - ($new_width / 2));
			} else {
				$origin_y   = $new_height / 2;
				$new_height = $final_height;
				$origin_y   = round($origin_y - ($new_height / 2));
			}
		}
		imagesavealpha($canvas, true);
		if ($zoom_crop > 0) {
			$src_x = $src_y = 0;
			$src_w = $width;
			$src_h = $height;
			$cmp_x = $width / $new_width;
			$cmp_y = $height / $new_height;
			if ($cmp_x > $cmp_y) {
				$src_w = round($width / $cmp_x * $cmp_y);
				$src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
			} else if ($cmp_y > $cmp_x) {
				$src_h = round($height / $cmp_y * $cmp_x);
				$src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
			}
			if ($align) {
				if (strpos($align, 't') !== false) {
					$src_y = 0;
				}
				if (strpos($align, 'b') !== false) {
					$src_y = $height - $src_h;
				}
				if (strpos($align, 'l') !== false) {
					$src_x = 0;
				}
				if (strpos($align, 'r') !== false) {
					$src_x = $width - $src_w;
				}
			}
			imagecopyresampled($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
		} else {
			imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		}
		if ($filters != '' && function_exists('imagefilter') && defined('IMG_FILTER_NEGATE')) {
			$filterList = explode('|', $filters);
			foreach ($filterList as $fl) {
				$filterSettings = explode(',', $fl);
				if (isset($imageFilters[$filterSettings[0]])) {
					for ($i = 0; $i < 4; $i++) {
						if (!isset($filterSettings[$i])) {
							$filterSettings[$i] = null;
						} else {
							$filterSettings[$i] = (int) $filterSettings[$i];
						}
					}
					switch ($imageFilters[$filterSettings[0]][1]) {
						case 1:
							imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1]);
							break;
						case 2:
							imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2]);
							break;
						case 3:
							imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3]);
							break;
						case 4:
							imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3], $filterSettings[4]);
							break;
						default:
							imagefilter($canvas, $imageFilters[$filterSettings[0]][0]);
							break;
					}
				}
			}
		}
		if ($sharpen && function_exists('imageconvolution')) {
			$sharpenMatrix = array(
				array(
					-1,
					-1,
					-1
				),
				array(
					-1,
					16,
					-1
				),
				array(
					-1,
					-1,
					-1
				)
			);
			$divisor       = 8;
			$offset        = 0;
			imageconvolution($canvas, $sharpenMatrix, $divisor, $offset);
		}
		if ((IMAGETYPE_PNG == $origType || IMAGETYPE_GIF == $origType) && function_exists('imageistruecolor') && !imageistruecolor($image) && imagecolortransparent($image) > 0) {
			imagetruecolortopalette($canvas, false, imagecolorstotal($image));
		}
		$imgType  = "";
		$tempfile = tempnam($this->cacheDirectory, 'timthumb_tmpimg_');
		if (preg_match('/^image\/(?:jpg|jpeg)$/i', $mimeType)) {
			$imgType = 'jpg';
			imagejpeg($canvas, $tempfile, $quality);
		} else if (preg_match('/^image\/png$/i', $mimeType)) {
			$imgType = 'png';
			imagepng($canvas, $tempfile, floor($quality * 0.09));
		} else if (preg_match('/^image\/gif$/i', $mimeType)) {
			$imgType = 'gif';
			imagegif($canvas, $tempfile);
		} else {
			return $this->sanityFail("Could not match mime type after verifying it previously.");
		}
		if ($imgType == 'png' && OPTIPNG_ENABLED && OPTIPNG_PATH && @is_file(OPTIPNG_PATH)) {
			$exec = OPTIPNG_PATH;
			$this->debug(3, "optipng'ing $tempfile");
			$presize = filesize($tempfile);
			$out     = `$exec -o1 $tempfile`;
			clearstatcache();
			$aftersize = filesize($tempfile);
			$sizeDrop  = $presize - $aftersize;
			if ($sizeDrop > 0) {
				$this->debug(1, "optipng reduced size by $sizeDrop");
			} else if ($sizeDrop < 0) {
				$this->debug(1, "optipng increased size! Difference was: $sizeDrop");
			} else {
				$this->debug(1, "optipng did not change image size.");
			}
		} else if ($imgType == 'png' && PNGCRUSH_ENABLED && PNGCRUSH_PATH && @is_file(PNGCRUSH_PATH)) {
			$exec      = PNGCRUSH_PATH;
			$tempfile2 = tempnam($this->cacheDirectory, 'timthumb_tmpimg_');
			$this->debug(3, "pngcrush'ing $tempfile to $tempfile2");
			$out   = `$exec $tempfile $tempfile2`;
			$todel = "";
			if (is_file($tempfile2)) {
				$sizeDrop = filesize($tempfile) - filesize($tempfile2);
				if ($sizeDrop > 0) {
					$this->debug(1, "pngcrush was succesful and gave a $sizeDrop byte size reduction");
					$todel    = $tempfile;
					$tempfile = $tempfile2;
				} else {
					$this->debug(1, "pngcrush did not reduce file size. Difference was $sizeDrop bytes.");
					$todel = $tempfile2;
				}
			} else {
				$this->debug(3, "pngcrush failed with output: $out");
				$todel = $tempfile2;
			}
			@unlink($todel);
		}
		$this->debug(3, "Rewriting image with security header.");
		$tempfile4 = tempnam($this->cacheDirectory, 'timthumb_tmpimg_');
		$context   = stream_context_create();
		$fp        = fopen($tempfile, 'r', 0, $context);
		file_put_contents($tempfile4, $this->filePrependSecurityBlock . $imgType . ' ?' . '>');
		file_put_contents($tempfile4, $fp, FILE_APPEND);
		fclose($fp);
		@unlink($tempfile);
		$this->debug(3, "Locking and replacing cache file.");
		$lockFile = $this->cachefile . '.lock';
		$fh       = fopen($lockFile, 'w');
		if (!$fh) {
			return $this->error("Could not open the lockfile for writing an image.");
		}
		if (flock($fh, LOCK_EX)) {
			@unlink($this->cachefile);
			rename($tempfile4, $this->cachefile);
			flock($fh, LOCK_UN);
			fclose($fh);
			@unlink($lockFile);
		} else {
			fclose($fh);
			@unlink($lockFile);
			@unlink($tempfile4);
			return $this->error("Could not get a lock for writing.");
		}
		$this->debug(3, "Done image replace with security header. Cleaning up and running cleanCache()");
		imagedestroy($canvas);
		imagedestroy($image);
		return true;
	}
	protected function calcDocRoot() {
		$docRoot = @$_SERVER['DOCUMENT_ROOT'];
		if (defined('LOCAL_FILE_BASE_DIRECTORY')) {
			$docRoot = LOCAL_FILE_BASE_DIRECTORY;
		}
		if (!isset($docRoot)) {
			$this->debug(3, "DOCUMENT_ROOT is not set. This is probably windows. Starting search 1.");
			if (isset($_SERVER['SCRIPT_FILENAME'])) {
				$docRoot = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
				$this->debug(3, "Generated docRoot using SCRIPT_FILENAME and PHP_SELF as: $docRoot");
			}
		}
		if (!isset($docRoot)) {
			$this->debug(3, "DOCUMENT_ROOT still is not set. Starting search 2.");
			if (isset($_SERVER['PATH_TRANSLATED'])) {
				$docRoot = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
				$this->debug(3, "Generated docRoot using PATH_TRANSLATED and PHP_SELF as: $docRoot");
			}
		}
		if ($docRoot && $_SERVER['DOCUMENT_ROOT'] != '/') {
			$docRoot = preg_replace('/\/$/', '', $docRoot);
		}
		$this->debug(3, "Doc root is: " . $docRoot);
		$this->docRoot = $docRoot;
	}
	protected function getLocalImagePath($src) {
		$src = ltrim($src, '/');
		if (!$this->docRoot) {
			$this->debug(3, "We have no document root set, so as a last resort, lets check if the image is in the current dir and serve that.");
			$file = preg_replace('/^.*?([^\/\\\\]+)$/', '$1', $src);
			if (is_file($file)) {
				return $this->realpath($file);
			}
			return $this->error("Could not find your website document root and the file specified doesn't exist in timthumbs directory. We don't support serving files outside timthumb's directory without a document root for security reasons.");
		} else if (!is_dir($this->docRoot)) {
			$this->error("Server path does not exist. Ensure variable \$_SERVER['DOCUMENT_ROOT'] is set correctly");
		}
		if (file_exists($this->docRoot . '/' . $src)) {
			$this->debug(3, "Found file as " . $this->docRoot . '/' . $src);
			$real = $this->realpath($this->docRoot . '/' . $src);
			if (stripos($real, $this->docRoot) === 0) {
				return $real;
			} else {
				$this->debug(1, "Security block: The file specified occurs outside the document root.");
			}
		}
		$absolute = $this->realpath('/' . $src);
		if ($absolute && file_exists($absolute)) {
			$this->debug(3, "Found absolute path: $absolute");
			if (!$this->docRoot) {
				$this->sanityFail("docRoot not set when checking absolute path.");
			}
			if (stripos($absolute, $this->docRoot) === 0) {
				return $absolute;
			} else {
				$this->debug(1, "Security block: The file specified occurs outside the document root.");
			}
		}
		$base = $this->docRoot;
		if (strstr($_SERVER['SCRIPT_FILENAME'], ':')) {
			$sub_directories = explode('\\', str_replace($this->docRoot, '', $_SERVER['SCRIPT_FILENAME']));
		} else {
			$sub_directories = explode('/', str_replace($this->docRoot, '', $_SERVER['SCRIPT_FILENAME']));
		}
		foreach ($sub_directories as $sub) {
			$base .= $sub . '/';
			$this->debug(3, "Trying file as: " . $base . $src);
			if (file_exists($base . $src)) {
				$this->debug(3, "Found file as: " . $base . $src);
				$real = $this->realpath($base . $src);
				if (stripos($real, $this->realpath($this->docRoot)) === 0) {
					return $real;
				} else {
					$this->debug(1, "Security block: The file specified occurs outside the document root.");
				}
			}
		}
		return false;
	}
	protected function realpath($path) {
		$remove_relatives = '/\w+\/\.\.\//';
		while (preg_match($remove_relatives, $path)) {
			$path = preg_replace($remove_relatives, '', $path);
		}
		return preg_match('#^\.\./|/\.\./#', $path) ? realpath($path) : $path;
	}
	protected function toDelete($name) {
		$this->debug(3, "Scheduling file $name to delete on destruct.");
		$this->toDeletes[] = $name;
	}
	protected function serveWebshot() {
		$this->debug(3, "Starting serveWebshot");
		$instr = "Please follow the instructions at http://code.google.com/p/timthumb/ to set your server up for taking website screenshots.";
		if (!is_file(WEBSHOT_CUTYCAPT)) {
			return $this->error("CutyCapt is not installed. $instr");
		}
		if (!is_file(WEBSHOT_XVFB)) {
			return $this->Error("Xvfb is not installed. $instr");
		}
		$cuty      = WEBSHOT_CUTYCAPT;
		$xv        = WEBSHOT_XVFB;
		$screenX   = WEBSHOT_SCREEN_X;
		$screenY   = WEBSHOT_SCREEN_Y;
		$colDepth  = WEBSHOT_COLOR_DEPTH;
		$format    = WEBSHOT_IMAGE_FORMAT;
		$timeout   = WEBSHOT_TIMEOUT * 1000;
		$ua        = WEBSHOT_USER_AGENT;
		$jsOn      = WEBSHOT_JAVASCRIPT_ON ? 'on' : 'off';
		$javaOn    = WEBSHOT_JAVA_ON ? 'on' : 'off';
		$pluginsOn = WEBSHOT_PLUGINS_ON ? 'on' : 'off';
		$proxy     = WEBSHOT_PROXY ? ' --http-proxy=' . WEBSHOT_PROXY : '';
		$tempfile  = tempnam($this->cacheDirectory, 'timthumb_webshot');
		$url       = $this->src;
		if (!preg_match('/^https?:\/\/[a-zA-Z0-9\.\-]+/i', $url)) {
			return $this->error("Invalid URL supplied.");
		}
		$url = preg_replace('/[^A-Za-z0-9\-\.\_:\/\?\&\+\;\=]+/', '', $url);
		if (WEBSHOT_XVFB_RUNNING) {
			putenv('DISPLAY=:100.0');
			$command = "$cuty $proxy --max-wait=$timeout --user-agent=\"$ua\" --javascript=$jsOn --java=$javaOn --plugins=$pluginsOn --js-can-open-windows=off --url=\"$url\" --out-format=$format --out=$tempfile";
		} else {
			$command = "$xv --server-args=\"-screen 0, {$screenX}x{$screenY}x{$colDepth}\" $cuty $proxy --max-wait=$timeout --user-agent=\"$ua\" --javascript=$jsOn --java=$javaOn --plugins=$pluginsOn --js-can-open-windows=off --url=\"$url\" --out-format=$format --out=$tempfile";
		}
		$this->debug(3, "Executing command: $command");
		$out = `$command`;
		$this->debug(3, "Received output: $out");
		if (!is_file($tempfile)) {
			$this->set404();
			return $this->error("The command to create a thumbnail failed.");
		}
		$this->cropTop = true;
		if ($this->processImageAndWriteToCache($tempfile)) {
			$this->debug(3, "Image processed succesfully. Serving from cache");
			return $this->serveCacheFile();
		} else {
			return false;
		}
	}
	protected function serveExternalImage() {
		if (!preg_match('/^https?:\/\/[a-zA-Z0-9\-\.]+/i', $this->src)) {
			$this->error("Invalid URL supplied.");
			return false;
		}
		$tempfile = tempnam($this->cacheDirectory, 'timthumb');
		$this->debug(3, "Fetching external image into temporary file $tempfile");
		$this->toDelete($tempfile);
		if (!$this->getURL($this->src, $tempfile)) {
			@unlink($this->cachefile);
			touch($this->cachefile);
			$this->debug(3, "Error fetching URL: " . $this->lastURLError);
			$this->error("Error reading the URL you specified from remote host." . $this->lastURLError);
			return false;
		}
		$mimeType = $this->getMimeType($tempfile);
		if (!preg_match("/^image\/(?:jpg|jpeg|gif|png)$/i", $mimeType)) {
			$this->debug(3, "Remote file has invalid mime type: $mimeType");
			@unlink($this->cachefile);
			touch($this->cachefile);
			$this->error("The remote file is not a valid image. Mimetype = '" . $mimeType . "'" . $tempfile);
			return false;
		}
		if ($this->processImageAndWriteToCache($tempfile)) {
			$this->debug(3, "Image processed succesfully. Serving from cache");
			return $this->serveCacheFile();
		} else {
			return false;
		}
	}
	public static function curlWrite($h, $d) {
		fwrite(self::$curlFH, $d);
		self::$curlDataWritten += strlen($d);
		if (self::$curlDataWritten > MAX_FILE_SIZE) {
			return 0;
		} else {
			return strlen($d);
		}
	}
	protected function serveCacheFile() {
		$this->debug(3, "Serving {$this->cachefile}");
		if (!is_file($this->cachefile)) {
			$this->error("serveCacheFile called in timthumb but we couldn't find the cached file.");
			return false;
		}
		$fp = fopen($this->cachefile, 'rb');
		if (!$fp) {
			return $this->error("Could not open cachefile.");
		}
		fseek($fp, strlen($this->filePrependSecurityBlock), SEEK_SET);
		$imgType = fread($fp, 3);
		fseek($fp, 3, SEEK_CUR);
		if (ftell($fp) != strlen($this->filePrependSecurityBlock) + 6) {
			@unlink($this->cachefile);
			return $this->error("The cached image file seems to be corrupt.");
		}
		$imageDataSize = filesize($this->cachefile) - (strlen($this->filePrependSecurityBlock) + 6);
		$this->sendImageHeaders($imgType, $imageDataSize);
		$bytesSent = @fpassthru($fp);
		fclose($fp);
		if ($bytesSent > 0) {
			return true;
		}
		$content = file_get_contents($this->cachefile);
		if ($content != FALSE) {
			$content = substr($content, strlen($this->filePrependSecurityBlock) + 6);
			echo $content;
			$this->debug(3, "Served using file_get_contents and echo");
			return true;
		} else {
			$this->error("Cache file could not be loaded.");
			return false;
		}
	}
	protected function sendImageHeaders($mimeType, $dataSize) {
		if (!preg_match('/^image\//i', $mimeType)) {
			$mimeType = 'image/' . $mimeType;
		}
		if (strtolower($mimeType) == 'image/jpg') {
			$mimeType = 'image/jpeg';
		}
		$gmdate_expires  = gmdate('D, d M Y H:i:s', strtotime('now +10 days')) . ' GMT';
		$gmdate_modified = gmdate('D, d M Y H:i:s') . ' GMT';
		header('Content-Type: ' . $mimeType);
		header('Accept-Ranges: none');
		header('Last-Modified: ' . $gmdate_modified);
		header('Content-Length: ' . $dataSize);
		if (BROWSER_CACHE_DISABLE) {
			$this->debug(3, "Browser cache is disabled so setting non-caching headers.");
			header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
			header("Pragma: no-cache");
			header('Expires: ' . gmdate('D, d M Y H:i:s', time()));
		} else {
			$this->debug(3, "Browser caching is enabled");
			header('Cache-Control: max-age=' . BROWSER_CACHE_MAX_AGE . ', must-revalidate');
			header('Expires: ' . $gmdate_expires);
		}
		return true;
	}
	protected function securityChecks() {
	}
	protected function param($property, $default = '') {
		if (isset($_GET[$property])) {
			return $_GET[$property];
		} else {
			return $default;
		}
	}
	protected function openImage($mimeType, $src) {
		switch ($mimeType) {
			case 'image/jpeg':
				$image = imagecreatefromjpeg($src);
				break;
			case 'image/png':
				$image = imagecreatefrompng($src);
				imagealphablending($image, true);
				imagesavealpha($image, true);
				break;
			case 'image/gif':
				$image = imagecreatefromgif($src);
				break;
			default:
				$this->error("Unrecognised mimeType");
		}
		return $image;
	}
	protected function getIP() {
		$rem = @$_SERVER["REMOTE_ADDR"];
		$ff  = @$_SERVER["HTTP_X_FORWARDED_FOR"];
		$ci  = @$_SERVER["HTTP_CLIENT_IP"];
		if (preg_match('/^(?:192\.168|172\.16|10\.|127\.)/', $rem)) {
			if ($ff) {
				return $ff;
			}
			if ($ci) {
				return $ci;
			}
			return $rem;
		} else {
			if ($rem) {
				return $rem;
			}
			if ($ff) {
				return $ff;
			}
			if ($ci) {
				return $ci;
			}
			return "UNKNOWN";
		}
	}
	protected function debug($level, $msg) {
		if (DEBUG_ON && $level <= DEBUG_LEVEL) {
			$execTime = sprintf('%.6f', microtime(true) - $this->startTime);
			$tick     = sprintf('%.6f', 0);
			if ($this->lastBenchTime > 0) {
				$tick = sprintf('%.6f', microtime(true) - $this->lastBenchTime);
			}
			$this->lastBenchTime = microtime(true);
			error_log("TimThumb Debug line " . __LINE__ . " [$execTime : $tick]: $msg");
		}
	}
	protected function sanityFail($msg) {
		return $this->error("There is a problem in the timthumb code. Message: Please report this error at <a href='http://code.google.com/p/timthumb/issues/list'>timthumb's bug tracking page</a>: $msg");
	}
	protected function getMimeType($file) {
		$info = getimagesize($file);
		if (is_array($info) && $info['mime']) {
			return $info['mime'];
		}
		return '';
	}
	protected function setMemoryLimit() {
		$inimem   = ini_get('memory_limit');
		$inibytes = timthumb::returnBytes($inimem);
		$ourbytes = timthumb::returnBytes(MEMORY_LIMIT);
		if ($inibytes < $ourbytes) {
			ini_set('memory_limit', MEMORY_LIMIT);
			$this->debug(3, "Increased memory from $inimem to " . MEMORY_LIMIT);
		} else {
			$this->debug(3, "Not adjusting memory size because the current setting is " . $inimem . " and our size of " . MEMORY_LIMIT . " is smaller.");
		}
	}
	protected static function returnBytes($size_str) {
		switch (substr($size_str, -1)) {
			case 'M':
			case 'm':
				return (int) $size_str * 1048576;
			case 'K':
			case 'k':
				return (int) $size_str * 1024;
			case 'G':
			case 'g':
				return (int) $size_str * 1073741824;
			default:
				return $size_str;
		}
	}
	protected function getURL($url, $tempfile) {
		$this->lastURLError = false;
		$url                = preg_replace('/ /', '%20', $url);
		if (function_exists('curl_init')) {
			$this->debug(3, "Curl is installed so using it to fetch URL.");
			self::$curlFH = fopen($tempfile, 'w');
			if (!self::$curlFH) {
				$this->error("Could not open $tempfile for writing.");
				return false;
			}
			self::$curlDataWritten = 0;
			$this->debug(3, "Fetching url with curl: $url");
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT);
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.122 Safari/534.30");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_WRITEFUNCTION, 'timthumb::curlWrite');
			@curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			@curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
			$curlResult = curl_exec($curl);
			fclose(self::$curlFH);
			$httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			if ($httpStatus == 404) {
				$this->set404();
			}
			if ($httpStatus == 302) {
				$this->error("External Image is Redirecting. Try alternate image url");
				return false;
			}
			if ($curlResult) {
				curl_close($curl);
				return true;
			} else {
				$this->lastURLError = curl_error($curl);
				curl_close($curl);
				return false;
			}
		} else {
			$img = @file_get_contents($url);
			if ($img === false) {
				$err = error_get_last();
				if (is_array($err) && $err['message']) {
					$this->lastURLError = $err['message'];
				} else {
					$this->lastURLError = $err;
				}
				if (preg_match('/404/', $this->lastURLError)) {
					$this->set404();
				}
				return false;
			}
			if (!file_put_contents($tempfile, $img)) {
				$this->error("Could not write to $tempfile.");
				return false;
			}
			return true;
		}
	}
	protected function serveImg($file) {
		$s = getimagesize($file);
		if (!($s && $s['mime'])) {
			return false;
		}
		header('Content-Type: ' . $s['mime']);
		header('Content-Length: ' . filesize($file));
		header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
		header("Pragma: no-cache");
		$bytes = @readfile($file);
		if ($bytes > 0) {
			return true;
		}
		$content = @file_get_contents($file);
		if ($content != FALSE) {
			echo $content;
			return true;
		}
		return false;
	}
	protected function set404() {
		$this->is404 = true;
	}
	protected function is404() {
		return $this->is404;
	}
}