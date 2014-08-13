<?php
namespace Ben\DoctorsBundle\Pagination;

use IteratorAggregate;

class Paginator implements IteratorAggregate
{
    CONST VERSION = "2.0.*";
    
    CONST NUM = "(:num)";
    
    private $templateUrl;
    private $page = 0;
    private $totalItems = 0;
    private $itemsPerPage = 10;
    private $navigationSize = 10;
    private $totalPages = 0;
    private $pagePattern = "page=(:num)";
    private $url = "";
    private $prevTitle = "<";
    private $nextTitle = ">";
    private $firstTitle = "<<";
    private $lastTitle = ">>";
    

    
    public function __construct($pagePattern = "") 
    {
        $this->setUrl($this->getUri(), $pagePattern);
    }
    
    public function setUrl($url, $pagePattern = null) 
    {
        $this->url = $url;
        
        if($pagePattern) {
            $this->pagePattern = $pagePattern;
        }
        $this->prepareUrl();
        return $this;
    }
    
    /**
     * Set the items
     * 
     * @param int $totalItems - total items in the set
     * @param int $itemsPerPage - total items per page
     * @param int $navigationSize - navigation size, it will show a set for $x
     * @return Paginator
     */
    public function setItems($totalItems, $itemsPerPage = 10, $navigationSize = 10)
    {
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->navigationSize = $navigationSize;
        $this->totalPages = @ceil($this->totalItems/$this->itemsPerPage);
        return $this;
    }
    
    /**
     * Return the URI of the request
     * 
     * @return string
     */
    public function getUri()
    {
        $uri  = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
                    || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
        $uri .= "://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
        return $uri;
    }
    
    /**
     * Set the URL, automatically it will parse every thing to it
     * 
     * @param string $url
     * @return Paginator 
     */
    private function prepareUrl()
    {
        $url = $this->url;
        $pagePattern = $this->pagePattern;
        
        $pattern = str_replace(self::NUM, "([0-9]+)" ,$pagePattern);
        preg_match("~$pattern~i", $url, $m);
        /**
         * No match found. 
         * We'll add the pagination in the url, so this way it can be ready for next pages.
         * This way a url http://xyz.com/?q=boom , becomes http://xyz.com/?q=boom&page=2
         */
        if (count($m) == 0){
          $pag_ = str_replace(self::NUM, 0, $pagePattern);
          
          // page pattern contain the equal sign, we'll add it to the query ?page=123 
          if (strpos($pagePattern, "=") !== false){
              if (strpos($url,"?") !== false) {
                      $url .= "&".$pag_;
              } else {
                  $url .= "?".$pag_;
              }
            return $this->setUrl($url,$pagePattern);
            
          }  else if (strpos($pagePattern,"/") !== false){ //Friendly url : /page/123
              $segment = "";
              if (strpos($url,"?") !== false) {
                  list($segment,$query) = explode("?", $url, 2);
                    if(preg_match("/\/$/",$segment)){
                        $url = $segment.(preg_replace("/^\//","",$pag_));
                        $url .= ((preg_match("/\/$/",$pag_)) ? "" : "/"). "?{$query}";
                    }  else {
                        $url = $segment.$pag_;
                        $url .= ((preg_match("/\/$/",$pag_)) ? "" : "/"). "?{$query}";
                    }
              }  else {
                    if (preg_match("/\/$/",$segment)) {
                        $url .= (preg_replace("/^\//","",$pag_));
                    } else {
                        $url .= $pag_;    
                    }
              }
            return $this->setUrl($url, $pagePattern);
          }
        }        
        $match = current($m);
        $last = end($m);
        $page = $last ? $last : 1;
        
        // TemplateUrl will be used to create all the page numbers 
        $replacePageNumber = preg_replace("/[0-9]+/", "(#pageNumber)",$match);
        $this->templateUrl = str_replace($match, $replacePageNumber, $url);
        $this->setPage($page);
        return $this;
    }
    
    /**
     * Set the current page
     * @param int $page
     * @return Paginator
     */
    public function setPage($page = 1)
    {
        $this->page = $page;
        return $this;
    }
    
    
    public function addParams(Array $params)
    {
        
    }
    
    
    /**
     * Return the current page number
     * 
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * To get the start count of the items. Starts at 0
     * 
     * @return int
     */
    public function getStart()
    {   
        return $this->itemsPerPage * ($this->page - 1);    
    }
    
    /**
     * To get the end count of the items. Ends at -1
     * 
     * @return int
     */
    public function getEnd()
    {
        return (($this->itemsPerPage - 1) * $this->page) + ($this->page - 1);
    }
    
    /**
     * Return the total pages
     * 
     * @return int
     */
    public function count()
    {
        return $this->totalPages;
    }
    
    /**
     * Return the items per page
     * 
     * @return int
     */
    public function getPerPage()
    {
        return $this->itemsPerPage;
    }
    

    /**
     * Return the current page url or the url for a page number
     * @param int $pageNumber
     * @return string
     */
    public function getPageUrl($pageNumber = null)
    {
        $pageNumber = $pageNumber ?: $this->page; 
        
        if ($pageNumber > 0 && $pageNumber <= $this->totalPages) {
            return $this->parseTplUrl($pageNumber);
        } else {
            return "";
        }      
    }
    
    /**
     * Return the next page url
     * 
     * @return string
     */
    public function getNextPageUrl()
    {
        return $this->getPageUrl($this->page + 1);        
    }
    
    /**
     * Get the prev page url
     * 
     * @return string
     */
    public function getPrevPageUrl()
    {
        return $this->getPageUrl($this->page - 1);      
    }
    
    /**
     * This method allow the iteration inside of foreach()
     *
     * @return Array
     */
    public function getIterator()
    {
        return $this->toArray();
    }
     
     /**
     * To set the previous and next title
      * 
     * @param type $prev : Prev | &laquo; | &larr;
     * @param type $next : Next | &raquo; | &rarr;
     * @return Paginator 
     */
    public function setPrevNextTitle($prev = "Prev", $next = "Next")
    {
        $this->prevTitle = $prev;
        $this->nextTitle = $next;
        return $this;
    }
    
     /**
     * To set the first and last title
      * 
     * @param string $first : First | &laquo; | &larr;
     * @param string $last : Last | &raquo; | &rarr;
     * @return Paginator 
     */
    public function setFirstLastTitle($first = "First", $last = "Last")
    {
        $this->firstTitle = $first;
        $this->lastTitle = $last;
        return $this;
    }

    
    
    /**
     * toArray() export the pagination into an array. This array can be used for your own template or for other usafe
     * @param int $totalItems - the total Items found
     * @return Array 
     *     [
     *          [
     *                "pageNumber", // the page number
     *                "label", // the label for the page number
     *                "url", // the url 
     *                "isCurrent" // bool  set if page is current or not
     *          ],
     *          ...
     *      ]
     */
    public function toArray()
    {
        $navigation = [];

        if($this->totalPages){
            
            $halfSet = @ceil($this->navigationSize/2);
            $start = 1;
            $end = ($this->totalPages < $this->navigationSize) ? $this->totalPages : $this->navigationSize;
            
            $showPrevNextNav = ($this->totalPages > $this->navigationSize) ? true : false;
            
            if ($this->page >= $this->navigationSize) {
               $start = $this->page - $this->navigationSize + $halfSet + 1;
               $end = $this->page + $halfSet -1;
            }
            if ($end > $this->totalPages) {
                $s = $this->totalPages - $this->navigationSize;
                $start = $s ? $s : 1;
                $end = $this->totalPages;  
            }
             
            $prev = $this->page - 1;
            if ($this->page >= $this->navigationSize && $showPrevNextNav) {
                // First
                $navigation[] = $this->buildPaginationModel(1, $this->firstTitle, false, "first"); 
                // Prev
                $navigation[] = $this->buildPaginationModel($prev, $this->prevTitle, false, "prev");
            }                          

            for ($i = $start; $i <= $end; $i++){
                $isCurrent = ($i == $this->page) ? true : false;
                $navigation[] = $this->buildPaginationModel($i, $i, $isCurrent);            
            }

            $next = $this->page + 1;                          
            if ($next < $this->totalPages && $end < $this->totalPages && $showPrevNextNav ) {
                $navigation[] = $this->buildPaginationModel($next, $this->nextTitle, false, "next"); 
            }
            
            if($this->totalPages > $this->navigationSize) {
                $navigation[] = $this->buildPaginationModel($this->totalPages, $this->lastTitle, false, "last"); 
            }
            
            
        }
        return $navigation;
    }   
    
    /**
     * Build the pagination model
     * 
     * @param int $pageNumber
     * @param string $label
     * @param bool $isCurrent
     * @param string $isLabel (first | prev | next | last)
     * @return Array
     */
    private function buildPaginationModel($pageNumber, $label, $isCurrent = false, $isLabel = "page")
    {
        return [
                    "page_number" => $pageNumber,
                    "label" => $label,
                    "url" => $this->parseTplUrl($pageNumber),
                    "is_current" => $isCurrent,
                    "is_{$isLabel}" => true // first, prev, next, last                   
                ];
    }
    
    /**
     * Render the paginator in HTML format
     * 
     * @param string $paginationClsName - The class name of the pagination
     * @param string $wrapTag
     * @param string $listTag
     * @return string
     * <code>
     * <div class='pagination'>
     *      <ul>
     *          <li>1</li>
     *          <li class='active'>2</li>
     *          <li>3</li>
     *      <ul>
     * </div>
     * </code>
     */
    public function toHtml($paginationClsName="pagination", $wrapTag = "ul", $listTag = "li")
    {
        $list = "";
        foreach ($this->toArray() as $page) {
            $href = "<a href=\"{$page["url"]}\">{$page["label"]}</a>";
            $tagClass = ($page["is_current"]) ? " class=\"active\" " : "";
            $list .= "<{$listTag}{$tagClass}>{$href}</{$listTag}>".PHP_EOL; 
        }
        return 
            "<div class=\"{$paginationClsName}\">
                <{$wrapTag}>{$list}</{$wrapTag}>
            </div>";    
    } 
    
    
    public function __toString() 
    {
        return $this->toHtml();
    }
    
    /**
     * Parse a page number in the template url
     * 
     * @param int $pageNumber
     * @return string 
     */
    private function parseTplUrl($pageNumber)
    {
        return str_replace("(#pageNumber)", $pageNumber, $this->templateUrl);
    }
        
}
