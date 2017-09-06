<?php
# Alert the user that this is not a valid access point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'WfExplore',
	'author' => 'Pierre Boutet',
	//'url' => 'https://www.mediawiki.org/wiki/Extension:WfExplore',
	'descriptionmsg' => 'wfexplore-desc',
	'version' => '0.1.0',
);
$wgAutoloadClasses['SpecialWfExplore'] = __DIR__ . '/includes/SpecialWfExplore.php'; # Location of the SpecialWfSearch class (Tell MediaWiki to load this file)
$wgAutoloadClasses['WfExploreQueryParser'] = __DIR__ . "/includes/WfExploreQueryParser.php";
$wgAutoloadClasses['WfExploreTag'] = __DIR__ . "/includes/WfExploreTag.php";
$wgAutoloadClasses['WfExploreCore'] = __DIR__ . "/includes/WfExploreCore.php";
$wgAutoloadClasses['WikifabExploreResultFormatter'] = __DIR__ . '/includes/WikifabExploreResultFormatter.php'; # Location of the WikifabSearchResultFormatter class
//$wgAutoloadClasses['WfTutorialUtils'] = __DIR__ . '/includes/WfTutorialUtils.php'; # tools for using tutorial forms pages


$wgMessagesDirs['WfExplore'] = __DIR__ . "/i18n"; # Location of localisation files (Tell MediaWiki to load them)
//$wgExtensionMessagesFiles['WfExploreAlias'] = __DIR__ . '/WfExplore.alias.php'; # Location of an aliases file

// Allow translation of the parser function name
$wgExtensionMessagesFiles['WfExploreMagic'] = __DIR__ . '/WfExplore.magic.php';
$wgSpecialPages['WfExplore'] = 'SpecialWfExplore'; # Tell MediaWiki about the new special page and its class name
$egWfExploreLayoutForm= __DIR__ . '/views/LayoutExploreForm.php';
//$GLOBALS['egChameleonLayoutFileSearchResult'];

$wgExploreDefaultsFieldsDisplayValues = [
		'Main_Picture' => 'No-image-yet.jpg',
		'group-logo' => 'no-logo-group.gif'
];


$wgResourceModules['ext.wikifab.wfExplore.js'] = array(
		'scripts' => 'wf-explore.js',
		'styles' => array('wf-explore.css'),
		'localBasePath' => __DIR__,
		'remoteExtPath' => 'Explore',
		'messages' => array(
				'wfexplore-load-more-tutorials-previous'
		)
);
$wgResourceModules['ext.wikifab.wfexplore.css'] = array(
	'styles' => array('wf-explore.css'),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Explore'
);

$wgResourceModules['ext.wikifab.wfexplore'] = array(
	'dependencies' => array(
			'ext.wikifab.wfexplore.css',
			'ext.wikifab.wfExplore.js'
	),
);

$wfexploreExtractTags = true;
$wgExploreIsLocalized = false;

$wgExploreResultsLayouts = [
		'event' => __DIR__ . '/views/layout-event.html'
];

$wgHooks['ParserFirstCallInit'][] = 'WfExploreParserFunctions';


# Parser function to insert a link changing a tab.
function WfExploreParserFunctions( $parser ) {
	global $wgOut;

	$wgOut->addModuleStyles(
		array(
				'ext.wikifab.wfexplore.css'
		)
	);
	$wgOut->addModules( array( 'ext.wikifab.wfexplore' ) );
	$parser->setFunctionHook( 'displayExplore', array('WfExploreTag', 'addSampleParser' ));
	$parser->setFunctionHook( 'exploreQuery', array('WfExploreQueryParser', 'addSampleParser' ));
	return true;
}



