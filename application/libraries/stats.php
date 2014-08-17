<?php
class Stats {
var $vars;

	function pullStats($set){
		$xp = new XsltProcessor();
		// create a DOM document and load the XSL stylesheet
		$xsl = new DomDocument;
		$xsl->load('stats.xslt');

		// import the XSL styelsheet into the XSLT process
		$xp->importStylesheet($xsl);
		// create a DOM document and load the XML datat
		$xml_doc = new DomDocument;
		$xml_doc->load('xmlcache/'.$set.'.xml');
		// transform the XML into HTML using the XSL file
		if ($xml = $xp->transformToXML($xml_doc)) {
			$stats_xml = simplexml_load_string($xml);
			$temp_bottom = array();
			$temp_top = array();
			foreach($stats_xml->top as $top){
				array_push($temp_top, (string)$top);
			}
			foreach($stats_xml->bottom as $bottom){
				array_push($temp_bottom, (string)$bottom);
			}
			$temp_return = array('bottom'=>$temp_bottom, 'top'=>$temp_top, 'total'=>(string)$stats_xml->total);

			return $temp_return;
		}

	}
}
