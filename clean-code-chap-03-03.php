<?php

function renderPageWithSetupsAndTeardowns($pageData, $isSuite)
{
    try
    {
        if (isTestPage($pageData)){
            includeSetupAndTeardownPages($pageData, $isSuite);
        }
        return $pageData.getHtml();
    }catch(Exception $e){
        return $e->getMessage();
    }
}