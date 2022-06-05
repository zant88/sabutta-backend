<?php

use yii\db\Migration;

/**
 * Class m220603_155520_view_sorted_waste
 */
class m220603_155520_view_sorted_waste extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $strQuery = "CREATE OR REPLACE
            ALGORITHM = UNDEFINED VIEW `vsumpilahan` AS
            select od.idsampah, o.tanggalinput as tgl, js.nama, od.berat, (od.berat * js.hargaperkg) as nilai
            from pupr.orderdetail od, pupr.jenissampah js , pupr.`order` o
            where
            js.idsampah = od.idsampah and 
            o.idorder = od.orderid and 
            od.orderid in (SELECT x.idorder FROM pupr.`order` x
            WHERE jnsTrxRequest = 'HASIL_GABRUKAN' and status ='COMPLETE' and lokasipenjemputan ='tpst01001'
            order by tanggalinput desc)
            order by o.tanggalinput desc";

        Yii::$app->db->createCommand($strQuery)->queryAll();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $strQuery = "DROP VIEW vsumpilahan";

        Yii::$app->db->createCommand($strQuery)->queryAll();
    }
}
