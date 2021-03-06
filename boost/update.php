<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id$
 */
function carousel_update(&$content, $version)
{
    switch ($version) {
        case version_compare($version, '1.1.0', '<'):
            $db = \phpws2\Database::newDB();
            $t1 = $db->addTable('caro_slide');
            if (!$t1->columnExists('url')) {
                $dt = $t1->addDataType('url', 'text');
                $dt->add();
            }

            $content[] = '<pre>1.1.0
--------------------
+ Slide is linkable.
</pre>';
        case version_compare($version, '1.2.0', '<'):
            $db = \phpws2\Database::newDB();
            if (!$db->tableExists('caro_keyed_slide')) {
                $keyed_slide = $db->buildTable('caro_keyed_slide');
                $dt = $keyed_slide->addDataType('slide_id', 'int');
                $dt = $keyed_slide->addDataType('key_id', 'int');
                $keyed_slide->create();
            }
            $content[] = '<pre>1.2.0
--------------------
+ Can now associate a slide to a page.
+ Can control iterations of slides
</pre>';
        case version_compare($version, '1.3.0', '<'):
            $db = \phpws2\Database::newDB();
            $tbl = $db->addTable('caro_slide');
            $dt = new \phpws2\Database\Datatype\Integer($tbl, 'caption_zone');
            $dt->setDefault(0);
            $dt->add();
            $content[] = '<pre>1.3.0
--------------------
+ Slide caption location added
</pre>';
        case version_compare($version, '1.3.1', '<'):
            $content[] = '<pre>1.3.1
--------------------
+ Fixed single slide setting.
</pre>';

        case version_compare($version, '1.4.0', '<'):
            $db = \phpws2\Database::newDB();
            $t = $db->addTable('caro_slide');
            $dt = new \phpws2\Database\Datatype\Smallint($t, 'show_title');
            $dt->add();
            $content[] = '<pre>1.4.0
--------------------
+ Slide title can now be hidden by unchecking "Show Title." Caption will still display.
</pre>';
    } // end of switch

    return true;
}

?>