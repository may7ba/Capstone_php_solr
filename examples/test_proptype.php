<?php

require(__DIR__.'/init.php');
htmlHeader();

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();

// get the facetset component
$facetSet = $query->getFacetSet('proptype:*');

// create a facet field instance and set options
$facetSet->createFacetField('proptype')->setField('proptype_s');

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
//echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet counts for field "proptype":<br/>';
$facet = $resultset->getFacetSet()->getFacet('proptype');
foreach ($facet as $value => $count) {
    echo $value . ' [' . $count . ']<br/>';
}



htmlFooter();