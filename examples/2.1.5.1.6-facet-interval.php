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
$facet = $facetSet->createFacetInterval('listprice');
$facet->setField('listprice');
$facet->setSet(array('Any+' => '[0,*)','100,00 - 200,00 ' => '[10000,20000)','300,00 - 400,00 ' => '[30000,40000)','500,00 - 600,00 ' => '[50000,60000)','700,00 +' => '[70000,*)'));
//$facet->setSet(array('1-9' => '[1,10)', '10-49' => '[10,50)', '49>' => '[50,*)'));

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet intervals:<br/>';
$facet = $resultset->getFacetSet()->getFacet('listprice');
foreach ($facet as $range => $count) {
    echo $range . ' to ' . ($range + 100000) . ' [' . $count . ']<br/>';
}

// show documents using the resultset iterator
foreach ($resultset as $document) {

    echo '<hr/><table>';
    echo '<tr><th>id</th><td>' . $document->id . '</td></tr>';
    echo '<tr><th>name</th><td>' . $document->name . '</td></tr>';
    echo '<tr><th>price</th><td>' . $document->price . '</td></tr>';
    echo '</table>';
}

htmlFooter();
