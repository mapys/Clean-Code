<?php

function renderPageWithSetupsAndTeardowns($pageData,$isSuite)
{
    try
    {
        $isTestPage = $pageData->hasAttribute("Test");
        if ($isTestPage) {
            $testPage = $pageData->getWikiPage();
            $newPageContent = new StringBuffer();

            includeSetupPages($testPage, $newPageContent, $isSuite);
            $newPageContent->append($pageData.getContent());
            includeTeardownPages($testPage, $newPageContent, $isSuite);
            $pageData->setContent($newPageContent->toString());
        }
        return $pageData->getHtml();
    }catch(Exception $e){
        return $e->getMessage();
    }
}