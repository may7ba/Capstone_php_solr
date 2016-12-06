<html>
<head>
<link type ="text/css" rel ="stylesheet" href="saltyhomes.css" />
</head>
<body>
<div id="body_text">
				<br />
				<h1>Search all Utah Real Estate for Sale</h1>
				<div id="sublinks" style="z-index:99999999999; text-align:right;">
					<a class="buttonsearch" href="new-listings">Today's Hot New Listings</a>
					<a class="buttonsearch" href="zipcode_search">Zip Code Search</a>
					<a class="buttonsearch" href="featured_listings"> Featured Homes</a>
					<a class="buttonsearch" href="salt_lake_city_neighborhoods/neighborhoods">Salt Lake Neighborhoods</a>
					<br />
					<br />
				</div>
<FORM action="http://solarium-test.com/examples/form_test.php" id=form method=GET name=form style="color:#C0392B;font-size:15;">
   <b> City: </b>
	<br>
	<INPUT id="city" name="city" value="<?php echo isset($_GET["city"]) ? $_GET["city"]  : '' ?>" />
	<br>
	<br>
	<b>Property Type:</b>
	<br>
	<select id="proptype" name="proptype" value="<?php echo isset($_GET["proptype"]) ? $_GET["proptype"]  : '' ?>" />
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
	
   <b>Total Bed:</b>
	<br>
	<select id="totbed" name="totbed">
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
   <b> Total Bath:</b>
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
    <b>Garage:</b>
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
	<b>Price:</b>
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
    </body>
</html>
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
 if ($totbed!=null&$totbed!='6') {
    $totbedquery=' totbed:'.$totbed;
    
} 
elseif($totbed=='6')
 {
 $totbedquery=' totbed:'.'[6 TO *]';
 
 }
else {
    $totbedquery=' totbed:'.'*';
    
}

if ($totbath!=null&$totbath!='6') {
    $totbathquery=' totbath:'.$totbath;
}elseif($totbath=='6')
 {
 $totbathquery=' totbath:'.'[6 TO *]';
 
 } 
else {
    $totbathquery=' totbath:'.'*';
}

if ($capgarage!=null&$capgarage!='6') {
    $capgaragequery=' capgarage:'.$capgarage;
} elseif($capgarage=='6')
 {
 $capgaragequery=' capgarage:'.'[6 TO *]';
 
 } 
else {
    $capgaragequery=' capgarage:'.'*';
}
 if($listprice!=null&$listprice!=1&$listprice!=2&$listprice!=3&$listprice!=4&$listprice!=5&$listprice!=6&$listprice!=7)
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
$facet->setSet(array('Any+' => '[0,*)','1 ' => '[1,1]','2 ' => '[2,2]','3 ' => '[3,3]','4 ' => '[4,4]','5 ' => '[5,5]','6+' => '[6,*)'));
//$facetSet->createFacetField('totbed')->setField('totbed');



// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'Results Found: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Bedrooms<br/>';
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
 
 echo'<a href="http://solarium-test.com/examples/test_results2.php?totbed='.$bed.'&city='.$city.'&proptype='.$proptype.'&totbath='.$totbath.'&capgarage='.$capgarage.'&listprice='.$listprice. '">' .$range . ' [' . $count . ']<br/></a>';
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
echo 'Results Found: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Bath<br/>';
$bath=0;
$facet = $resultset->getFacetSet()->getFacet('totbath');
$city=str_replace('"', '', $city);
$proptype=str_replace('"', '', $proptype);
foreach ($facet as $range => $count) {
  if($count==0){
  echo $range . ' [' . $count . ']<br/>';
  }
else{
echo'<a href="http://solarium-test.com/examples/test_results2.php?totbed='.$totbed.'&city='.$city.'&proptype='.$proptype.'&totbath='.$bath.'&capgarage='.$capgarage.'&listprice='.$listprice. '">' .$range . ' [' . $count . ']<br/></a>';
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
echo 'Results Found: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Garage<br/>';
$garage=0;
$facet = $resultset->getFacetSet()->getFacet('capgarage');
$city=str_replace('"', '', $city);
$proptype=str_replace('"', '', $proptype);
foreach ($facet as $range => $count) {
  if($count==0){
  echo $range . ' [' . $count . ']<br/>';
  }
else{

echo'<a href="http://solarium-test.com/examples/test_results2.php?totbed='.$totbed.'&city='.$city.'&proptype='.$proptype.'&totbath='.$totbath.'&capgarage='.$garage.'&listprice='.$listprice. '">' .$range . ' [' . $count . ']<br/></a>';
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
echo 'Results Found: '.$resultset->getNumFound();

// display facet counts
echo '<hr/>Price<br/>';
$facet = $resultset->getFacetSet()->getFacet('listprice');
$city=str_replace('"', '', $city);
$proptype=str_replace('"', '', $proptype);
$price=1;
foreach ($facet as $range => $count) {
if($count==0){
echo $range . ' [' . $count . ']<br/>';
}
else{
    echo'<a href="http://solarium-test.com/examples/test_results2.php?totbed='.$totbed.'&city='.$city.'&proptype='.$proptype.'&totbath='.$totbath.'&capgarage='.$capgarage.'&listprice='.$price. '">' .$range . ' [' . $count . ']<br/></a>';
    }
    $price++;
}
htmlFooter();
?>
<div id="mlsinfo">
	<h4>Utah mls, real estate, homes, condos, and Realtor&reg; disclosures:</h4>
  	
    <p>
        <img src="http://saltyhomes.com/images/equalhousing.jpg" alt="equal housing real estate logo" width="100" height="95"/>
        Price per square foot and price per finished square foot are estimated based on data supplied by the listing broker.  Square footage should be confirmed by a licensed appraiser.  Google street view is approximate and historical, which may not reflect the most current view of a neighborhood.  Price history data for homes and condos reflects the date the information was received from the MLS.
    </p>
	
    "Realtor&reg;" is a registered trademark of the 
    <a href="http://www.realtor.org/">National Association of Realtors&reg;</a>.&nbsp;
    <a href="http://en.wikipedia.org/wiki/Realtor">Real estate agents</a>that are Realtors&reg; subscribe to ahigher&nbsp;
    <a href="http://www.realtor.org/mempolweb.nsf/pages/code">Realtor&reg; Code of Ethics and Standards of Practice</a>.&nbsp;
    
    <p>
        The information provided is for consumers' personal, non-commercial use and may not be used for any purpose other than to identify prospective homes, condos, and real estate consumers may be interested in purchasing.
        Information is deemed reliable but not guaranteed accurate. Buyer to verify all information. Maps are approximate. Statistical data and calculations shall be confirmed by consumers prior to making a purchase or sale of real estate in Utah.
        The multiple listing information is provided by Wasatch Front Regional Multiple Listing Service, Inc. from a copyrighted compilation of listings. The compilation of listings and each individual listing are &copy; 2016 Wasatch Front Regional Multiple Listing Service, Inc., All Rights Reserved.
        All data on saltyhomes.com is supplied according to the <a href="http://www.utahrealestate.com/page/do/policies.procedures" target="_blank">Wasatch Front Regional Multiple Listing Service Policies and Procedures</a>.Each Broker Subscriber expressly consents to all IDX Participating Brokers and all IDX Agents advertising all Listings for properties listed for sale by the Broker Subscriber in accordance with the IDX Policy, and in connection with such advertising, each Broker Subscriber consents to WFR granting licenses to all IDX Listings to IDX Participating Brokers, IDX Agents, Vendors and other third parties deemed appropriate by WFR to facilitate the display of IDX Listings by IDX Participating Brokers and IDX Agents.
    </p>
    
    <p>Fantis Group Real Estate is licensed for real estate in Utah.  Fantis Group Real Estate and Saltyhomes.com shares limited consumer information with Realtors<sup>&reg;</sup> and lenders for the purpose of helping potential buyers and sellers in real estate trasactions.</p>
    
    <div style="text-align:center;font-size:12px; margin-bottom:40px;">
    	&copy; 2009-2016 <a href="http://www.agentwebsitesutah.com">AgentWebsitesUtah.com</a>.  Some content under license. All other rights Reserved.
    </div>
</div>
		</div>			

