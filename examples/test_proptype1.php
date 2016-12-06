<?php

require(__DIR__.'/init.php');

htmlHeader();


$client = new Solarium\Client($config);


$query = $client->createSelect();


$query->setQuery('proptype:*');


$query->setStart(2)->setRows(5);


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
//new try


$facetSet = $query->getFacetSet('proptype');

// create a facet field instance and set options
$facetSet->createFacetField('proptype')->setField('proptype');

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