<?php

/**
 * MLinkPager class file
 *
 * @example
 *
 *     [first][prev][1][2][3][4][5]...[132][next][last]
 *
 *     [first][prev][1]...[6][7][8][9]...[132][next][last]
 *
 *     [first][prev][1]...[128][129][130][131][132][next][last]
 *
 * @version 0.1 24.09.2013
 * @author webmaxx <webmaxx@webmaxx.name>
 */
class MLinkPager extends CLinkPager
{

	public $showPrevButton = true;
	public $showNextButton = true;
	public $showFirstPage = false;
	public $showLastPage = false;
	public $showFirstButton = true;
	public $showLastButton = true;
	public $showDivider = true;
	public $dividerCssClass = 'divider';
	public $firstDivider = '...';
	public $lastDivider = '...';
	public $selectedPageTag = false;
	public $selectedPageOptions = array(
		'htmlOptions' => array(),
		'closeTag' => true,
	);

	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// first page
		if($this->showFirstPage)
			$buttons[]=$this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,$currentPage<=0,false);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		if ($this->showPrevButton)
			$buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);

		// first page button
		if($beginPage+1>1){
			if($this->showFirstButton)
				$buttons[]=$this->createPageButton(1,0,self::CSS_INTERNAL_PAGE,$currentPage>=$pageCount-1,false);
			if($this->showDivider && $this->firstDivider !== false && $beginPage+1>2)
				$buttons[]='<li class="'.self::CSS_INTERNAL_PAGE.' '.$this->dividerCssClass.'">'.CHtml::tag('span',array(),$this->firstDivider).'</li>';
		}

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i){
			if ($i==$currentPage && $this->selectedPageTag){
				$buttons[]='<li class="'.self::CSS_INTERNAL_PAGE.' '.$this->selectedPageCssClass.'">'.CHtml::tag($this->selectedPageTag,$this->selectedPageOptions['htmlOptions'],$i+1,$this->selectedPageOptions['closeTag']).'</li>';
			} else {
				$buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);
			}
		}

		// last page button
		if($endPage<$pageCount-1){
			if($this->showDivider && $this->lastDivider !== false && $endPage<$pageCount-2)
				$buttons[]='<li class="'.self::CSS_INTERNAL_PAGE.'">'.CHtml::tag('span',array(),$this->lastDivider).'</li>';
			if($this->showLastButton)
				$buttons[]=$this->createPageButton($pageCount,$pageCount-1,self::CSS_INTERNAL_PAGE,$currentPage>=$pageCount-1,false);
		}

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		if ($this->showNextButton)
			$buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);

		// last page
		if($this->showLastPage)
			$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);

		return $buttons;
	}

}
