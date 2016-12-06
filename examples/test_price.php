<?php
$query = $client->createSelect();
$facetSet = $query->getFacetSet();
$facet = $facetSet->createFacetInterval('listprice');
$facet->setField('listprice');
$facet->setSet(array('Any+' => '[0,*)','100,000 - 200,000 ' => '[100000,200000]','300,000 - 400,000 ' => '[300000,400000]','500,000 - 600,000 ' => '[500000,600000]','700,000 +' => '[700,000,*)'));
// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet intervals:listprice<br/>';
$facet = $resultset->getFacetSet()->getFacet('listprice');
foreach ($facet as $range => $count) {
    echo $range . ' [' . $count . ']<br/>';
    }