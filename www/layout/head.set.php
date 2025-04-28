<!DOCTYPE HTML>
<html lang="ko">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="format-detection" content="telephone=no" />
<?php
switch (USE_MOBILE) {
    case "Y" :
        $use_respd = true;
        break;

    case "N" :
        $use_respd = false;
        break;

    case "C" :
        $use_respd = ($CONF['use_mobile'] == "Y") ? true : false;
        break;
}
if ($use_respd === true) {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />'.PHP_EOL;
} else {
    echo '<meta name="viewport" content="width=1400,user-scalable=yes" />'.PHP_EOL;
}
?>
<meta name="description" content="<?php echo $CONF['description']; ?>" />
<meta property="og:type" content="<?php echo $CONF['og_type']; ?>" />
<meta property="og:description" content="<?php echo $CONF['og_description']; ?>" />
<meta property="og:url" content="<?php echo $CONF['og_url']; ?>" />
<?php if ($CONF['og_image']) { ?>
<meta property="og:image" content="<?php echo $CONF['og_image']; ?>" />
<?php } ?>
<?php if ($CONF['naver_verific']) { ?>
<meta name="naver-site-verification" content="<?php echo $CONF['naver_verific']; ?>" />
<?php } ?>
<?php if ($CONF['google_verific']) { ?>
<meta name="google-site-verification" content="<?php echo $CONF['google_verific']; ?>" />
<?php } ?>
<?php if ($CONF['meta']) echo $CONF['meta'].PHP_EOL; ?>
<?php if ($CONF['use_rss'] == 'Y') { ?>
<link rel="alternate" type="application/rss+xml" title="<?php echo $CONF['title']; ?> Feed" href="<?php echo PH_DOMAIN; ?>/rss" />
<?php } ?>
<?php if ($CONF['favicon']) { ?>
<link rel="icon" href="<?php echo $CONF['favicon']?>" />
<link rel="shortcut icon" href="<?php echo $CONF['favicon']; ?>" />
<link rel="apple-touch-icon" href="<?php echo $CONF['favicon']; ?>" />
<?php } ?>
<link rel="stylesheet" href="<?php echo PH_DIR; ?>/layout/css/jquery.common.css<?php echo SET_CACHE_HASH; ?>" />
<link rel="stylesheet" href="<?php echo PH_DIR; ?>/layout/css/common.css<?php echo SET_CACHE_HASH; ?>" />
<link rel="stylesheet" href="<?php echo PH_THEME_DIR; ?>/layout/css/layout.css<?php echo SET_CACHE_HASH; ?>" />
<?php if ($use_respd === true) { ?>
<link rel="stylesheet" href="<?php echo PH_THEME_DIR; ?>/layout/css/respond.css<?php echo SET_CACHE_HASH; ?>" />
<?php } ?>
<link rel="stylesheet" href="<?php echo PH_PLUGIN_DIR; ?>/<?php echo PH_PLUGIN_CKEDITOR; ?>/contents_view.css<?php echo SET_CACHE_HASH; ?>" />
<?php
// 모듈별 CSS
foreach ($MODULE as $key => $value) {
    $file = PH_THEME_PATH."/mod-".$value."/style.css";
    if (file_exists($file)) echo '<link rel="stylesheet" href="'.PH_THEME_DIR.'/mod-'.$value.'/style.css'.SET_CACHE_HASH.'"/>'.PHP_EOL;
}
?>

<?php
// Datatable이 사용된 페이지 
$URL_slices = explode('/', $_SERVER['REQUEST_URI']);
$page = explode('_', $URL_slices[count($URL_slices)-1]);
  
if ($page[0] == "dt")
{
  $page_css =  $URL_slices[count($URL_slices)-1]. ".css";
  $page_js =  $URL_slices[count($URL_slices)-1] . ".js";
?>
	<link rel="stylesheet" href="<?php echo PH_DIR; ?>/datatables/css/jquery.dataTables.min.css" />
	<link rel="stylesheet" href="<?php echo PH_DIR; ?>/datatables/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" href="<?php echo PH_DIR; ?>/datatables/css/select.dataTables.min.css" />
	<link rel="stylesheet" href="<?php echo PH_DIR; ?>/datatables/css/dataTables.dateTime.min.css" />
	<link rel="stylesheet" href="<?php echo PH_DIR; ?>/datatables/css/editor.dataTables.min.css" />
  <link rel="stylesheet" href="<?php echo PH_DIR; ?>/datatables/css/searchBuilder.dataTables.min.css" />
  
	<link rel="stylesheet" href="<?php echo PH_DIR; ?>/datatables/css/user/<?php echo $page_css?>" />	
<?php
}

?>


<script type="text/javascript">
var PH_DIR = '<?php echo PH_DIR; ?>';
var PH_DOMAIN = '<?php echo PH_DOMAIN; ?>';
var PH_PLUGIN_DIR = '<?php echo PH_PLUGIN_DIR; ?>';
var PH_NOW_TABINDEX = 0;
var PH_KPOSTCODE_API_URL = '<?php echo SET_KPOSTCODE_URL; ?>';
var PH_POST_MAX_SIZE = <?php echo $CONF['ini_post_max_size']; ?>;
</script>
<script src="<?php echo PH_DIR; ?>/layout/js/jquery.min.js<?php echo SET_CACHE_HASH; ?>"></script>
<script src="<?php echo PH_DIR; ?>/layout/js/jquery.common.js<?php echo SET_CACHE_HASH; ?>"></script>
<script src="<?php echo PH_DIR; ?>/layout/js/common.js<?php echo SET_CACHE_HASH; ?>"></script>
<script src="<?php echo PH_DIR; ?>/layout/js/global.js<?php echo SET_CACHE_HASH; ?>"></script>
<script src="<?php echo PH_THEME_DIR; ?>/layout/js/layout.js<?php echo SET_CACHE_HASH; ?>"></script>
<script src="<?php echo PH_PLUGIN_DIR; ?>/<?php echo PH_PLUGIN_CKEDITOR; ?>/ckeditor.js<?php echo SET_CACHE_HASH; ?>"></script>
<?php
// 모듈별 JS
foreach ($MODULE as $key => $value) {
    $file = PH_THEME_PATH."/mod-".$value."/script.js";
    if (file_exists($file)) echo '<script src="'.PH_THEME_DIR.'/mod-'.$value.'/script.js'.SET_CACHE_HASH.'"></script>'.PHP_EOL;
}
// script 소스코드 설정 반영
if ($CONF['script']) echo $CONF['script'].PHP_EOL;
?>


<?php
// Datatable이 사용된 페이지 
if ($page[0] == "dt")
{
?>
	<script src="<?php echo PH_DIR; ?>/datatables/js/jquery-3.7.0.js"></script>
	<script src="<?php echo PH_DIR; ?>/datatables/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo PH_DIR; ?>/datatables/js/dataTables.editor.min.js"></script>	
	<script src="<?php echo PH_DIR; ?>/datatables/js/dataTables.select.min.js"></script>  
	<script src="<?php echo PH_DIR; ?>/datatables/js/dataTables.dateTime.min.js"></script>
	<script src="<?php echo PH_DIR; ?>/datatables/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo PH_DIR; ?>/datatables/js/dataTables.searchBuilder.min.js"></script>
  <script src="<?php echo PH_DIR; ?>/datatables/js/buttons.colVis.min.js"></script>
  <script src="<?php echo PH_DIR; ?>/datatables/js/jszip.min.js"></script>
  <script src="<?php echo PH_DIR; ?>/datatables/js/buttons.html5.min.js"></script>
  <script src="<?php echo PH_DIR; ?>/datatables/js/buttons.print.min.js"></script>
  <script src="<?php echo PH_DIR; ?>/datatables/js/user/<?php echo $page_js?>"></script>
  <script type="text/javascript">
    var MB_NAME = '<?php echo isset($_SESSION['MB_NAME']) ? $_SESSION['MB_NAME'] : null ?>';
  </script>
<?php
}
?>

</head>
<body>
