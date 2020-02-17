<?php

function delete($page) {
    try {
        deletePageAndAllReferences(page);
    }
    catch (Exception $e) {
        logError($e);
    }
}

function deletePageAndAllReferences($page){
    deletePage(page);
    $registry->deleteReference($page->name);
    $configKeys->deleteKey($page->name->makeKey());
}

function logError(Exception $e) {
    $logger->log($e->getMessage());
}