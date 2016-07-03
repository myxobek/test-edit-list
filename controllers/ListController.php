<?php

include_once ROOT . '/models/List.php';

class ListController
{

    public function actionIndex()
    {
        /*$newsList = array();
        $newsList = News::getNewsList();*/

        require_once(ROOT . '/views/list/index.php');

        return true;
    }

    public function actionView($id)
    {
        if ($id)
        {
            $newsItem = News::getNewsItemByID($id);

            require_once(ROOT . '/views/list/view.php');

            /*			echo 'actionView'; */
        }

        return true;

    }

}

