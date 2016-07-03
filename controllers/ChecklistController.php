<?php

include_once ROOT . '/models/Checklist.php';

class ChecklistController
{
    /**
     * @return bool
     */
    public function actionIndex()
    {
        $checklist = [];
        $checklist = Checklist::getList();

        require_once(ROOT . '/views/checklist/index.php');

        return true;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Adds new string
     */
    public function actionAjaxAdd()
    {
        $id = Checklist::addRow();

        if ( !is_null( $id ) )
        {
            $id = $id[0];
        }

        header('Content-Type: application/json');
        echo json_encode(
            [
                'id'        => $id,
                'string'    => ''
            ]
        );
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Removes string
     */
    public function actionAjaxRemove()
    {
        $id = Filter::sanitize( $_POST['id'] );

        $result = Checklist::removeRow( $id );

        header('Content-Type: application/json');
        echo json_encode(
            [
                'result'    => $result
            ]
        );
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Checks for changes
     */
    public function actionAjaxCheck()
    {
        $result = Checklist::getList();

        header('Content-Type: application/json');
        echo json_encode(
            [
                'result'    => $result
            ]
        );
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * If string value was changed
     */
    public function actionAjaxChange()
    {
        $id     = Filter::sanitize( $_POST['id'] );
        $string = Filter::sanitize( $_POST['string'] );

        $result = Checklist::changeRow( $id, $string );

        header('Content-Type: application/json');
        echo json_encode(
            [
                'result'    => $result
            ]
        );
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}

