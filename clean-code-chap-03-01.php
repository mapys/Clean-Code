<?php

function testableHtml($pageData, $includeSuiteSetup)
{
    try
    {
        $wikiPage = $pageData->getWikiPage();
        $buffer = new StringBuffer();

        if ($pageData->hasAttribute("Test")) {
            if ($includeSuiteSetup) {
                $suiteSetup = PageCrawlerImpl::getInheritedPage(SuiteResponder::SUITE_SETUP_NAME, $wikiPage);
                if ($suiteSetup != null) {
                    $pagePath = $suiteSetup->getPageCrawler()->getFullPath($suiteSetup);
                    $pagePathName = PathParser::render($pagePath);
                    $buffer->append("!include -setup .")
                        ->append($pagePathName)
                        ->append("\n");
                }
            }

            $setup = PageCrawlerImpl::getInheritedPage("SetUp", wikiPage);
            if ($setup != null) {
                $setupPath = $wikiPage->getPageCrawler()->getFullPath($setup);
                $setupPathName = PathParser::render($setupPath);
                $buffer->append("!include -setup .")
                    ->append($setupPathName)
                    ->append("\n");
            }
        }

        $buffer->append($pageData->getContent());

        if ($pageData->hasAttribute("Test")) {
            $teardown = PageCrawlerImpl::getInheritedPage("TearDown", $wikiPage);
            if ($teardown != null) {
                $tearDownPath = $wikiPage->getPageCrawler()->getFullPath($teardown);
                $tearDownPathName = PathParser::render($tearDownPath);
                $buffer->append("\n")
                    ->append("!include -teardown .")
                    ->append($tearDownPathName)
                    ->append("\n");
            }
            
            if ($includeSuiteSetup) {
                $suiteTeardown = PageCrawlerImpl::getInheritedPage(SuiteResponder::SUITE_TEARDOWN_NAME, $wikiPage);
                if ($suiteTeardown != null) {
                    $pagePath = $suiteTeardown->getPageCrawler()->getFullPath($suiteTeardown);
                    $pagePathName = PathParser::render($pagePath);
                    $buffer->append("!include -teardown .")
                        ->append($pagePathName)
                        ->append("\n");
                }
            }
        }

        $pageData->setContent($buffer->toString());
        
        return $pageData->getHtml();
    }catch(Exception $e){
        return $e->getMessage();
    }
}