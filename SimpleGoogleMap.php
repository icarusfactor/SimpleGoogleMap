<?php
/**
 * MediaWiki SimpleCalendar Extension
 * {{php}}{{Category:Extensions|SimpleGoogleMap}}
 * @package MediaWiki
 * @subpackage Extensions
 * @author  Daniel Yount aka @icarusfactor factorf2@yahoo.com
 * @licence GNU General Public Licence 3.0 or later
 */
 
define('SIMPLEGOOGLEMAP_VERSION','0.5');
 
$wgExtensionFunctions[] = 'wfSetupSimpleGoogleMap';
$wgHooks['LanguageGetMagic'][] = 'wfGoogleMapLanguageGetMagic';



 
$wgExtensionCredits['parserhook'][] = array(
        'name'        => 'Simple GoogleMap',
        'author'      => 'Daniel Yount - icarusfactor',
        'description' => 'A simple single marker Googlemap extension',
        'url'         => 'http://www.mediawiki.org',
        'version'     => SIMPLEGOOGLEMAP_VERSION
);
 
function wfGoogleMapLanguageGetMagic(&$magicWords,$langCode = 0) {
        $magicWords['gmap'] = array(0,'gmap');
        return true;
}
 
function wfSetupSimpleGoogleMap() {
        global $wgParser;
        $wgParser->setFunctionHook('gmap','wfRenderGmap');
        return true;
}
 
# Renders a table of all the individual month tables
function wfRenderGmap( &$parser) {
        $output = '';

        #$parser->mOutput->mCacheTime = -1;
        $argv = array();
        foreach (func_get_args() as $arg) if (!is_object($arg)) {
                if (preg_match('/^(.+?)\\s*=\\s*(.+)$/',$arg,$match)) $argv[$match[1]]=$match[2];
        }
        if (isset($argv['locate']))    $locate  = $argv['locate']; else $locate = 'United States';
        if (isset($argv['width']))      $width  = $argv['width'];  else $width  = '600';
        if (isset($argv['height']))     $height = $argv['height']; else $height = '400';


        
        $locate = str_replace( ' ' , '%20' , urlencode( $locate ) );

        $output =  '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q='.$locate.'&amp;t=h&amp;ie=UTF8&amp;output=embed"></iframe>'; 

        return $parser->insertStripItem( $output, $parser->mStripState );
        #return $output;


}
 
