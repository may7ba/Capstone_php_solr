<?php

require(__DIR__.'/init.php');

htmlHeader();

// create a client instance
$client = new Solarium\Client($config);

$proptype = null;$city = null;$totbed = null;$totbath = null;$capgarage=null;
$query = $client->createSelect();

if (isset($_GET["proptype"])) {
    $proptype= urldecode($_GET["proptype"]);
    if (preg_match('/^[a-z\s]*$/i', $proptype)) {
        $proptype = $_GET["proptype"];
        $proptype = '"'.$proptype.'"';
    } else {
        $proptype = '*';
    }
} else {
    $proptype = '*';
}

if (isset($_GET["city"])) {
    $city= urldecode($_GET["city"]);

    if (preg_match('/^[a-z\s]*$/i', $city)) {
        $city = $_GET["city"];
        $city = '"'.$city.'"';
    } else {
        $city = '*';
    }
} else {
    $city = '*';
}

if (isset($_GET["totbed"])) {
if($totbed=='[6 TO *]')
 {
 $totbed='[6 TO *]';
 }
    //$totbed = $_GET["totbed"];
    //$totbed = $_GET["totbed"];
    if (!filter_var($_GET["totbed"], FILTER_VALIDATE_INT) === false) {
   

       $totbed =$_GET["totbed"];
      
      
    } else {
        $totbed ='*';
        
    }
} else {
    $totbed = '*';
 
}

if (isset($_GET["totbath"])) {
    //$totbath = $_GET["totbath"];
    if (!filter_var($_GET["totbath"], FILTER_VALIDATE_INT) === false) {
       $totbath =$_GET["totbath"];
    } else {
        $totbath ='*';
    }
} else {
    $totbath = '*';
}

if (isset($_GET["capgarage"])) {
    if (!filter_var($_GET["capgarage"], FILTER_VALIDATE_INT) === false) {
       $capgarage =$_GET["capgarage"];
    } else {
        $capgarage ='*';
    }
} else {
    $capgarage= '*';
}
 
if ($proptype!=null) {
    $propquery='proptype:'.$proptype;
} else {
     $propquery='proptype:'.'*';
}
 
if ($city!=null) {
    $cityquery=' city:'.$city;
} else {
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
	
//$city = filter_var($_GET["city"], FILTER_SANITIZE_STRING);
//$query->setQuery('proptype:'.$proptype.' AND city:'.$city);
$query->setQuery($propquery.' AND'.$cityquery.' AND'. $totbedquery.' AND'.$totbathquery.' AND'.$capgaragequery);
$querSentence=$propquery.' AND'.$cityquery.' AND'. $totbedquery.' AND'.$totbathquery.' AND'.$capgaragequery;
echo $querSentence.'<br/>';


// set start and rows param (comparable to SQL limit) using fluent interface
$query->setStart(0)->setRows(20);

// set fields to fetch (this overrides the default setting 'all fields')
$query->setFields(array('proptype','city','listprice', 'totbed', 'totbath','capgarage','zip'));

// sort the results by price ascending
$query->addSort('listprice', $query::SORT_ASC);

// this executes the query and returns the result
$resultset = $client->select($query);

// display the total number of documents found by solr
echo 'NumFound: '.$resultset->getNumFound();


// show documents using the resultset iterator
foreach ($resultset as $document) {

    echo '<hr/><table>';

    // the documents are also iterable, to get all fields
    foreach ($document as $field => $value) {
        // this converts multivalue fields to a comma-separated string
        if (is_array($value)) {
            $value = implode(', ', $value);
        }

        echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
    }

    echo '</table>';
}

htmlFooter();