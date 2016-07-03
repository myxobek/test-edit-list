<?php

class Checklist
{
    /**
     * Returns an array of checklist items
     */
    public static function getList()
    {
        $db = Db::getConnection();
        $checklist = [];

        $result = $db->query('SELECT id, string FROM checklist');

        $i = 0;
        while ($row = $result->fetch())
        {
            $checklist[ $i ]['id']      = $row['id'];
            $checklist[ $i ]['string']  = $row['string'];
            $i++;
        }

        return $checklist;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Inserts empty row into table
     *
     * @return  mixed
     */
    public static function addRow()
    {
        $db = Db::getConnection();

        $result = $db->query('INSERT INTO checklist ( string ) VALUES ( "" ) ');

        if( $result )
        {
            $id = $db->query('SELECT LAST_INSERT_ID()')->fetch();

            if( $id !== false )
            {
                return $id;
            }
            else
            {
                return NULL;
            }
        }
        else
        {
            return NULL;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Removes row from table
     *
     * @param   int     $id
     *
     * @return  bool
     */
    public static function removeRow( $id )
    {
        $db = Db::getConnection();

        $result = $db->query('DELETE FROM checklist WHERE checklist.id = ' . $id );

        return !!$result;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param $id
     * @param $string
     *
     * @return bool
     */
    public static function changeRow( $id, $string )
    {
        $db = Db::getConnection();

        $result = $db->query('UPDATE checklist SET string = "' . $string . '" WHERE id = ' . $id );

        return !!$result;
    }

}