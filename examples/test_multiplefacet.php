<?php

require(__DIR__.'/init.php');

htmlHeader();


$client = new Solarium\Client($config);


$query = $client->createSelect();


$query->setQuery('proptype:Condo AND city:"Park City"');


$query->setStart(2)->setRows(20);


$query->setFields(array('proptype','city','listprice', 'totbed', 'totbath', 'capgarage'));


$query->addSort('listprice', $query::SORT_ASC);


$resultset = $client->select($query);


echo 'NumFound: '.$resultset->getNumFound();




foreach ($resultset as $document) {

    echo '<hr/><table>';

    
    foreach ($document as $field => $value) {
        
        if (is_array($value)) {
            $value = implode(', ', $value);
        }

        echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
    }

    echo '</table>';
}
$client = new Solarium\Client($config);





$facetSet = $query->getFacetSet();


$facet = $facetSet->createFacetRange('totbed');
$facet->setField('totbed');
$facet->setStart(0);
$facet->setGap(2);
$facet->setEnd(20);


$resultset = $client->select($query);


echo 'NumFound: '.$resultset->getNumFound();


echo '<hr/>Facet ranges: totbed<br/>';
$facet = $resultset->getFacetSet()->getFacet('totbed');
foreach ($facet as $range => $count) {
    echo $range . ' to ' . ($range+2) . ' [' . $count . ']<br/>';
}
$facet = $facetSet->createFacetRange('totbath');
$facet->setField('totbath');
$facet->setStart(0);
$facet->setGap(2);
$facet->setEnd(22);

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet ranges:totbath<br/>';
$facet = $resultset->getFacetSet()->getFacet('totbath');
foreach ($facet as $range => $count) {
    echo $range . ' to ' . ($range+2) . ' [' . $count . ']<br/>';
}


htmlFooter();