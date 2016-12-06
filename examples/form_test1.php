<html>
<head>
</head>
<body>
<FORM action="http://solarium-test.com/examples/form_test1.php" id=form method=GET name=form style="color:orange;font-size:15;">
    City:
	<br>
	<INPUT id="city" name="city" >
	<br>
	<br>
	Property Type:
	<br>
	<select id="proptype" name="proptype">
	<option value="*">any</option>
	 <option value="condo">Condo</option>
     <option value="single family">Single Family</option>
     <option value="townhouse">Town House</option>
     <option value="recreational">Recreational</option>
     <option value="mobile (w/o Land)">Mobile(w/o Land)</option>
     <option value="twin">Twin</option>
	</select>
	<br>
	<br>
	
   Total Bed:
	<br>
	<select id="totbed" name="totbed">
	 <option value="0">any</option>
     <option value="1">0</option>
	 <option value="2">1</option>
	 <option value="3">2</option>
	 <option value="4">3</option>
	 <option value="5">4</option>
	 <option value="6">5</option>
	 <option value="7">6+</option>
	 </select>
	<br>
	<br>
    Total Bath:
	<br>
	<select id="totbath" name="totbath">
	 <option value="0">any</option>
	 <option value="1">1</option>
	 <option value="2">2</option>
	 <option value="3">3</option>
	 <option value="4">4</option>
	 <option value="5">5</option>
	 <option value="6">6+</option>
	 </select>
    <br>
    <br>
    Garage:
	<br>
	<select id="capgarage" name="capgarage">
	<option value="0">any</option>
	 <option value="1">1</option>
	 <option value="2">2</option>
	 <option value="3">3</option>
	 <option value="4">4</option>
	 <option value="5">5</option>
	 <option value="6">6+</option>
	 </select>
    <br>
    <br>
	Price:
	<br>
	<select id="listprice" name="listprice">
	 <option value="1">any</option>
     <option value="2">$0-$100,000</option>
	 <option value="3">$100,001-$200,000</option>
	 <option value="4">$200,001-$300,000</option>
	 <option value="5">$300,001-$400,000</option>
	 <option value="6">$400,001-$500,000</option>
	 <option value="7">$500,001+</option>
	 
	 </select>
    <br>
    <br>	

	<INPUT type="submit" value="Submit" id=submit1 name=submit1> 
</FORM>				
</body>
</html>
	<?php

require(__DIR__.'/init.php');
htmlHeader();

// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$proptype = null;$city = null;$totbed = null;$totbath = null;$capgarage=null;$listprice=null;
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
if(isset($_GET["listprice"])){

if (!filter_var($_GET["listprice"], FILTER_VALIDATE_INT) === false) {
   $listprice =$_GET["listprice"];
} else {
    $listprice ='*';
}


 }

else
{
$listprice = '*';
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
 if($totbed!=null&$totbed!='0')
 {
 $totbedquery=' totbed:'.$totbed;
 }
 elseif($totbed==0){
 $totbedquery=' totbed:'.'0';
 }
  
 else{
$totbedquery=' totbed:'.'*';
echo "no zero";
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
 if($listprice!=null&$listprice!=1&$listprice!=2&$listprice!=3&$listprice!=4&$listprice!=5&$listprice!=6)
 {
 $listpricequery=' listprice:'.$listprice;
 }
 elseif($listprice==1){
$listpricequery=' listprice:'.'*';
 }
 elseif($listprice==2){
$listpricequery=' listprice:'.'[0 TO 100000]';
 }
 elseif($listprice==3){
$listpricequery=' listprice:'.'[100001 TO 200000]';
 }
  elseif($listprice==4){
$listpricequery=' listprice:'.'[200001 TO 300000]';
 }
  elseif($listprice==5){
$listpricequery=' listprice:'.'[300001 TO 400000]';
 }
  elseif($listprice==6){
$listpricequery=' listprice:'.'[400001 TO 500000]';
 }
  elseif($listprice==7){
$listpricequery=' listprice:'.'[500001 TO *]';
 }
 
 else{
$listpricequery=' listprice:'.'*';
 }
	

	
//$city = filter_var($_GET["city"], FILTER_SANITIZE_STRING);
//$query->setQuery('proptype:'.$proptype.' AND city:'.$city);
$query->setQuery($propquery.' AND'.$cityquery.' AND'. $totbedquery.' AND'.$totbathquery.' AND'.$capgaragequery.' AND'.$listpricequery);
$querSentence=$propquery.' AND'.$cityquery.' AND'. $totbedquery.' AND'.$totbathquery.' AND'.$capgaragequery.' AND'.$listpricequery;
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
$facet->setSet(array('Any+' => '[0,*)','0 ' => '[0,0]','1 ' => '[1,1]','2 ' => '[2,2]','3 ' => '[3,3]','4 ' => '[4,4]','5 ' => '[5,5]','6+' => '[6,*)'));
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
  if($count==0){
  echo $range . ' [' . $count . ']<br/>';
  }
else{
//echo'<a href="http://solarium-test.com/examples/test_results1.php?totbed='.$bed.'&city='.$city.'&proptype='.$proptype. '">' .$range . ' [' . $count . ']<br/></a>';
 
 echo'<a href="http://solarium-test.com/examples/result.php?totbed='.$bed.'&city='.$city.'&proptype='.$proptype.'&totbath='.$totbath.'&capgarage='.$capgarage.'&listprice='.$listprice. '">' .$range . ' [' . $count . ']<br/></a>';
 }
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
  if($count==0){
  echo $range . ' [' . $count . ']<br/>';
  }
else{
echo'<a href="http://solarium-test.com/examples/result.php?totbed='.$totbed.'&city='.$city.'&proptype='.$proptype.'&totbath='.$bath.'&capgarage='.$capgarage.'&listprice='.$listprice. '">' .$range . ' [' . $count . ']<br/></a>';
}
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
  if($count==0){
  echo $range . ' [' . $count . ']<br/>';
  }
else{

echo'<a href="http://solarium-test.com/examples/result.php?totbed='.$totbed.'&city='.$city.'&proptype='.$proptype.'&totbath='.$totbath.'&capgarage='.$garage.'&listprice='.$listprice. '">' .$range . ' [' . $count . ']<br/></a>';
 }
 $garage++;

}
// price

$facet = $facetSet->createFacetInterval('listprice');
$facet->setField('listprice');
$facet->setSet(array('Any+' => '[0,*)','0 - 100,000 ' => '[0,100000]','100,001 - 200,000 ' => '[100001,200000]','200,001 - 300,000 ' => '[200001,300000]','300,001 - 400,000 ' => '[300001,400000]','400,001 - 500,000 ' => '[400001,500000]','500,001 +' => '[500001,*)'));
// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Facet intervals:listprice<br/>';
$facet = $resultset->getFacetSet()->getFacet('listprice');
$city=str_replace('"', '', $city);
$proptype=str_replace('"', '', $proptype);
$price=1;
foreach ($facet as $range => $count) {
if($count==0){
echo $range . ' [' . $count . ']<br/>';
}
else{
    echo'<a href="http://solarium-test.com/examples/result.php?totbed='.$totbed.'&city='.$city.'&proptype='.$proptype.'&totbath='.$totbath.'&capgarage='.$capgarage.'&listprice='.$price. '">' .$range . ' [' . $count . ']<br/></a>';
    }
    $price++;
}







htmlFooter();