// create a client instance
$client = new Solarium\Client($config);

// get a select query instance
$query = $client->createSelect();

// get the dismax component and set a boost query
$dismax = $query->getEDisMax();
$dismax->setMinimumMatch('2');
$dismax->setBoostQuery('pf=title^100+content^0.1&qf=title^100+content^0.1&boost=score');

// set a query
$_SESSION["searchKeywords"] = stripslashes($_SESSION["searchKeywords"]);

if(@$_SESSION["searchAuthor"])
 $fq = $query->createFilterQuery('author')->setQuery('author_literal_value_str:'.$_SESSION["searchAuthor"].'*');

// create a filterquery using the API
if($arrTime)
 $fq = $query->createFilterQuery('displaydate_dt')->setQuery('displaydate_dt:['.$strSolrDate.' TO *]');

$fq = $query->createFilterQuery('categories_str')->setQuery('(+blog_name_str:"The Hill Times" AND -categories_str:classified AND -categories_str:author AND -categories_str:slideshow) OR (-blog_name_str:"The Hill Times" AND +(categories:story OR categories:"policy briefing"))');

if($strResult == 'Global')
 $fq = $query->createFilterQuery('blog_name_str')->setQuery('-blog_name_str:"The Hill Times" AND +(categories:story OR categories:"policy briefing")');
elseif($strResult == 'ForeignPolicy')
 $fq = $query->createFilterQuery('categories')->setQuery('+categories:"Global"');
elseif($strResult)
 $fq = $query->createFilterQuery('categories')->setQuery('+categories:"'.$strResult.'"');

if($strTag)
 $fq = $query->createFilterQuery('tags')->setQuery('+tags:"'.$strTag.'"');

$query->setQuery($_SESSION["searchKeywords"]);
//$query->setFields(array('title','content','tags'));
$query->setFields('*,score');
//$query->setFieldBoost('title', 4.5);

// get highlighting component and apply settings
$hl = $query->getHighlighting();
$hl->setFields('title, tags, content, author_literal_value_str');
$hl->setFragSize(300);
$hl->setSimplePrefix('<b>');
$hl->setSimplePostfix('</b>');

// set start and rows param (comparable to SQL limit) using fluent interface
$_SESSION["searchPaginationX"] = ($_SESSION["searchPagination"]-1)*10;
$query->setStart($_SESSION["searchPaginationX"])->setRows(10);

// set fields to fetch (this overrides the default setting 'all fields')

//$query->setFields(array('id','name','price', 'score'));

// sort the results by newest/oldest/relevance_score
if($_SESSION["searchSort"] == 'sortRelevance')
 $query->addSort('score', $query::SORT_DESC);
elseif($_SESSION["searchSort"] == 'sortOldest')
 $query->addSort('displaydate_dt', $query::SORT_ASC);
else
 $query->addSort('displaydate_dt', $query::SORT_DESC);

// add debug settings
$debug = $query->getDebug();
$debug->setExplainOther('author_literal_value_str:'.$_SESSION["searchAuthor"].'*');

// this executes the query and returns the result
$resultset = $client->select($query);
