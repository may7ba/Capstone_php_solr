<?php

require(__DIR__.'/init.php');
htmlHeader();

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();
$proptype = $_GET["proptype"];
$city = $_GET["city"];
$totbed = $_GET["totbed"];
$totbath = $_GET["totbath"];
//$query->setQuery('proptype:'.$proptype.' AND city:'.$city);
$query->setQuery('proptype:'.$proptype.' AND city:'.$city.' AND totbed:'.$totbed.' AND totbath:'.$totbath);
//$query->setQuery('proptype:'.$proptype.' AND city:'.$city.' AND totbed:'.$totbed.' AND totbath:'.$totbath);
$query->addSort('listprice', $query::SORT_ASC);



// set fields to fetch (this overrides the default setting 'all fields')
$query->setFields(array('proptype','city','listprice', 'totbed', 'totbath', 'capgarage'));

// get the facetset component
$facetSet = $query->getFacetSet();

// create a facet field instance and set options
$facet = $facetSet->createFacetInterval('totbed');
$facet->setField('totbed');
$facet->setSet(array('0+' => '[0,*)','1+' => '[1,*)','2+' => '[2,*)','3+' => '[3,*)','4+' => '[4,*)','5+' => '[5,*)','6+' => '[6,*)','7+' => '[7,*)','8+' => '[8,*)','9+' => '[9,*)','10+' => '[10,*)','11+' => '[11,*)','12+' => '[12,*)','13+' => '[13,*)','14+' => '[14,*)','15+' => '[15,*)','16+' => '[16,*)','17+' => '[17,*)','18+' => '[18,*)','19+' => '[19,*)','20+' => '[20,*)'));


// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet intervals:totbed<br/>';
$facet = $resultset->getFacetSet()->getFacet('totbed');
foreach ($facet as $range => $count) {
    echo $range . ' [' . $count . ']<br/>';
}

//totbath
$facet = $facetSet->createFacetInterval('totbath');
$facet->setField('totbath');
$facet->setSet(array('0+' => '[0,*)','1+' => '[1,*)','2+' => '[2,*)','3+' => '[3,*)','4+' => '[4,*)','5+' => '[5,*)','6+' => '[6,*)','7+' => '[7,*)','8+' => '[8,*)','9+' => '[9,*)','10+' => '[10,*)','11+' => '[11,*)','12+' => '[12,*)','13+' => '[13,*)','14+' => '[14,*)','15+' => '[15,*)','16+' => '[16,*)','17+' => '[17,*)','18+' => '[18,*)','19+' => '[19,*)','20+' => '[20,*)'));


// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet intervals:totbath<br/>';
$facet = $resultset->getFacetSet()->getFacet('totbath');
foreach ($facet as $range => $count) {
    echo $range . ' [' . $count . ']<br/>';
}


//capgarage
$facet = $facetSet->createFacetInterval('capgarage');
$facet->setField('capgarage');
$facet->setSet(array('0+' => '[0,*)','1+' => '[1,*)','2+' => '[2,*)','3+' => '[3,*)','4+' => '[4,*)','5+' => '[5,*)','6+' => '[6,*)','7+' => '[7,*)','8+' => '[8,*)','9+' => '[9,*)','10+' => '[10,*)','11+' => '[11,*)','12+' => '[12,*)','13+' => '[13,*)','14+' => '[14,*)','15+' => '[15,*)','16+' => '[16,*)','17+' => '[17,*)','18+' => '[18,*)','19+' => '[19,*)','20+' => '[20,*)'));


// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet intervals:capgarage<br/>';
$facet = $resultset->getFacetSet()->getFacet('capgarage');
foreach ($facet as $range => $count) {
    echo $range . ' [' . $count . ']<br/>';
}




htmlFooter();
