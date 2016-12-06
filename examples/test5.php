<?php

require(__DIR__.'/init.php');
htmlHeader();

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$proptype = null;$city = null;$totbed = null;$totbath = null;$capgarage=null;
$query = $client->createSelect();

if(isset($_GET["proptype"])){
$proptype= urldecode($_GET["proptype"]);

if(preg_match('/^[a-z\s]*$/i', $proptype))
{
$proptype = $_GET["proptype"];
$proptype = '"'.$proptype.'"';
}
else{
$proptype = '*';

}


}
else
{
$proptype = '*';

}
if(isset($_GET["city"])){
$city= urldecode($_GET["city"]);

if(preg_match('/^[a-z\s]*$/i', $city))
{
$city = $_GET["city"];
$city = '"'.$city.'"';
}
else{
$city = '*';
}
}
else
{
$city = '*';
}
if(isset($_GET["totbed"])){
//$totbed = $_GET["totbed"];
//$totbed = $_GET["totbed"];
if (!filter_var($_GET["totbed"], FILTER_VALIDATE_INT) === false) {
   $totbed =$_GET["totbed"];
} else {
    $totbed ='*';
}


 }

else
{
$totbed = '*';
}
if(isset($_GET["totbath"])){
//$totbath = $_GET["totbath"];
if (!filter_var($_GET["totbath"], FILTER_VALIDATE_INT) === false) {
   $totbath =$_GET["totbath"];
} else {
    $totbath ='*';
}
}
else
{
$totbath = '*';
}
if(isset($_GET["capgarage"])){
if (!filter_var($_GET["capgarage"], FILTER_VALIDATE_INT) === false) {
   $capgarage =$_GET["capgarage"];
} else {
    $capgarage ='*';
}
}
else
{
$capgarage= '*';
}
 if($proptype!=null)
 {
 $propquery='proptype:'.$proptype;
 }
 else{
 $propquery='proptype:'.'*';
 }
 if($city!=null)
 {
 $cityquery=' city:'.$city;
 }
 else{
 $cityquery=' city:'.'*';
 }
 if($totbed!=null)
 {
 $totbedquery=' totbed:'.$totbed;
 }
  
 else{
$totbedquery=' totbed:'.'*';
 }
 if($totbath!=null)
 {
 $totbathquery=' totbath:'.$totbath;
 }
 else{
$totbathquery=' totbath:'.'*';
 }
 if($capgarage!=null)
 {
 $capgaragequery=' capgarage:'.$capgarage;
 }
 else{
$capgaragequery=' capgarage:'.'*';
 }

	
//$city = filter_var($_GET["city"], FILTER_SANITIZE_STRING);
//$query->setQuery('proptype:'.$proptype.' AND city:'.$city);
$query->setQuery($propquery.' AND'.$cityquery.' AND'. $totbedquery.' AND'.$totbathquery.' AND'.$capgaragequery);
$querSentence=$propquery.' AND'.$cityquery.' AND'. $totbedquery.' AND'.$totbathquery.' AND'.$capgaragequery;
echo $querSentence.'<br/>';

//$query->setQuery('proptype:'.$proptype.' AND city:'.$city.' AND totbed:'.$totbed.' AND totbath:'.$totbath);
$query->addSort('listprice', $query::SORT_ASC);



// set fields to fetch (this overrides the default setting 'all fields')
$query->setFields(array('proptype','city','listprice', 'totbed', 'totbath', 'capgarage'));

// get the facetset component
$facetSet = $query->getFacetSet();

// create a facet field instance and set options
$facet = $facetSet->createFacetInterval('totbed');
$facet->setField('totbed');
$facet->setSet(array('Any+' => '[0,*)','1 ' => '[1,1]','2 ' => '[2,2]','3 ' => '[3,3]','4 ' => '[4,4]','5 ' => '[5,5]','6+' => '[6,*)'));
//$facetSet->createFacetField('totbed')->setField('totbed');



// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet intervals:totbed<br/>';
$bed=0;
$facet = $resultset->getFacetSet()->getFacet('totbed');
$city=str_replace('"', '', $city);
$proptype=str_replace('"', '', $proptype);
foreach ($facet as $range => $count) {
  

//echo'<a href="http://solarium-test.com/examples/test_results1.php?totbed='.$bed.'&city='.$city.'&proptype='.$proptype. '">' .$range . ' [' . $count . ']<br/></a>';
 echo'<a href="http://solarium-test.com/examples/test_results1.php?totbed='.$bed.'&city='.$city.'&proptype='.$proptype.'&totbath='.$totbath.'&capgarage='.$capgarage. '">' .$range . ' [' . $count . ']<br/></a>';
 $bed++;

}
//totbath
$facet = $facetSet->createFacetInterval('totbath');
$facet->setField('totbath');
$facet->setSet(array('Any+' => '[0,*)','1 ' => '[1,1]','2 ' => '[2,2]','3 ' => '[3,3]','4 ' => '[4,4]','5 ' => '[5,5]','6+' => '[6,*)'));
//$facetSet->createFacetField('totbed')->setField('totbed');



// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet intervals:totbath<br/>';
$bath=0;
$facet = $resultset->getFacetSet()->getFacet('totbath');
$city=str_replace('"', '', $city);
$proptype=str_replace('"', '', $proptype);
foreach ($facet as $range => $count) {
   


//echo'<a href="http://solarium-test.com/examples/test_results1.php?totbed='.$bed.'&city='.$city.'&proptype='.$proptype. '">' .$range . ' [' . $count . ']<br/></a>';
 echo'<a href="http://solarium-test.com/examples/test_results1.php?totbed='.$totbed.'&city='.$city.'&proptype='.$proptype.'&totbath='.$bath.'&capgarage='.$capgarage. '">' .$range . ' [' . $count . ']<br/></a>';
 $bath++;

}
//capgarage

$facet = $facetSet->createFacetInterval('capgarage');
$facet->setField('capgarage');
$facet->setSet(array('Any+' => '[0,*)','1 ' => '[1,1]','2 ' => '[2,2]','3 ' => '[3,3]','4 ' => '[4,4]','5 ' => '[5,5]','6+' => '[6,*)'));
//$facetSet->createFacetField('totbed')->setField('totbed');



// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet intervals:capgarage<br/>';
$garage=0;
$facet = $resultset->getFacetSet()->getFacet('capgarage');
$city=str_replace('"', '', $city);
$proptype=str_replace('"', '', $proptype);
foreach ($facet as $range => $count) {
   


//echo'<a href="http://solarium-test.com/examples/test_results1.php?totbed='.$bed.'&city='.$city.'&proptype='.$proptype. '">' .$range . ' [' . $count . ']<br/></a>';
 echo'<a href="http://solarium-test.com/examples/test_results1.php?totbed='.$totbed.'&city='.$city.'&proptype='.$proptype.'&totbath='.$totbath.'&capgarage='.$garage. '">' .$range . ' [' . $count . ']<br/></a>';
 $garage++;

}
// price

$facet = $facetSet->createFacetInterval('listprice');
$facet->setField('listprice');
$facet->setSet(array('Any+' => '[0,*)','100,000 - 200,000 ' => '[100000,200000)','200,001 - 300,000 ' => '[200001,300000)','300,001 - 400,000 ' => '[300001,400000)','400,001 - 500,000 ' => '[400001,500000)','500,001 +' => '[500001,*)'));
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







htmlFooter();