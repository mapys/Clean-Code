<?php

use App\Fitnesse;
use App\StringBuffer;
use App\SuiteResponder;
use App\PageCrawlerImpl;

class SetupTeardownIncluder {
    private $pageData;
    private $isSuite;
    private $testPage;
    private $newPageContent;
    private $pageCrawler;
    
    public function renderSuitePage($pageData, $isSuite)
    {
        try
        {
            return new SetupTeardownIncluder(pageData).render(isSuite);
        }catch(Exception $e){
            return $e->getMessage();
        }    
    }

    private function SetupTeardownIncluder($pageData) {
        $this->pageData = $pageData;
        $testPage = $pageData->getWikiPage();
        $pageCrawler = $testPage->getPageCrawler();
        $newPageContent = new StringBuffer();
    }

    private function renderTestPage($isSuite)
    {
        try
        {
            $this->isSuite = $isSuite;
            if ($this->isTestPage())
                $this->includeSetupAndTeardownPages();
            return $pageData->getHtml();
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    private function isTestPage()
    {
        return pageData.hasAttribute("Test");
    }

    private function includeSetupAndTeardownPages()
    {
        try
        {
            $this->includeSetupPages();
            $this->includePageContent();
            $this->includeTeardownPages();
            $this->updatePageContent();
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    private function includeSetupPages()
    {
        if($isSuite){
            includeSuiteSetupPage();
            includeSetupPage();
        }
    }

    private function includeSuiteSetupPage()
    {
        $this->include(SuiteResponder::SUITE_SETUP_NAME, "-setup");
    }

    private function includeSetupPage()
    {
        $this->include("SetUp", "-setup");
    }
    
    private function includePageContent()
    {
        $this->newPageContent->append($pageData->getContent());
    }

    private function includeTeardownPages()
    {
        $this->includeTeardownPage();
        if ($this->isSuite){
            $this->includeSuiteTeardownPage();
        }
    }
    
    private function includeTeardownPage()
    {
        $this->include("TearDown", "-teardown");
    }
        
    private function includeSuiteTeardownPage()
    {
        $this->include(SuiteResponder::SUITE_TEARDOWN_NAME, "-teardown");
    }
    
    private function updatePageContent()
    {
        $this->pageData->setContent($this->newPageContent->toString());
    }
        
    private function include($pageName, $arg)
    {
        $inheritedPage = $this->findInheritedPage($pageName);
        if ($inheritedPage != null) {
            $pagePathName = $this->getPathNameForPage($inheritedPage);
            $this->buildIncludeDirective($pagePathName, $arg);
        }
    }
        
    private function findInheritedPage($pageName)
    {
        return PageCrawlerImpl::getInheritedPage($pageName, $testPage);
    }
        
    private function getPathNameForPage($page)
    {
        $pagePath = $this->pageCrawler->getFullPath($page);
        return PathParser::render($pagePath);
    }
        
    private function buildIncludeDirective($pagePathName, $arg) {
        $newPageContent
            ->append("\n!include ")
            ->append(arg)
            ->append(" .")
            ->append(pagePathName)
            ->append("\n");
    }
}