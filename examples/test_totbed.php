<?php

require(__DIR__.'/init.php');
htmlHeader();

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();

// get the facetset component
$facetSet = $query->getFacetSet();

// create a facet field instance and set options
$facet = $facetSet->createFacetRange('totbed');
$facet->setField('totbed');
$facet->setStart(0);
$facet->setGap(2);
$facet->setEnd(20);

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet ranges:<br/>';
$facet = $resultset->getFacetSet()->getFacet('totbed');
foreach ($facet as $range => $count) {
    echo $range . ' to ' . ($range+2) . ' [' . $count . ']<br/>';
}

// show documents using the resultset iterator

htmlFooter();