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
$facet = $facetSet->createFacetRange('listprice');
$facet->setField('listprice');
$facet->setStart(10500);
$facet->setGap(20000);
$facet->setEnd(35000000);

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet ranges:<br/>';
$facet = $resultset->getFacetSet()->getFacet('listprice');
foreach ($facet as $range => $count) {
    echo $range . ' to ' . ($range+20000) . ' [' . $count . ']<br/>';
}

// show documents using the resultset iterator

htmlFooter();
