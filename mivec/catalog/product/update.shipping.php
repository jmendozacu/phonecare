<?php
require dirname(__FILE__) . "/config.php";

define("__ATTR_PRODUCT_RECURRIN_ID__" , 100);
define("__ATTR_PRODUCT_DI_RECURRIN__" , 0);
define("__ATTR_PRODUCT_EN_RECURRIN__" , 1);

//set product status is `Enabled`

$sql = "SELECT a.entity_id,a.sku,b.`value` as status,b.attribute_id FROM "
    . __TABLE_PRODUCT__." a"
    ." LEFT JOIN ".__TABLE_PRODUCT_INT__." b ON(a.entity_id=b.entity_id)"
    ." WHERE b.attribute_id=".__ATTR_PRODUCT_RECURRIN_ID__
    ." AND b.value=".__ATTR_PRODUCT_EN_RECURRIN__
    ." ORDER BY entity_id ASC";

echo $sql . "</p>";

if ($row = $db->fetchAll($sql)) {
    foreach ($row as $rs) {
        try {
            $_id = $rs['entity_id'];
            if (updateStatus($_id)) {
                echo $_id . " update status successfully<br>";
                usleep(5);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
}


function updateStatus($_entityId)
{
    global $db;
    $sql = "UPDATE " . __TABLE_PRODUCT_INT__ . " SET `value`=" . __ATTR_PRODUCT_STATUS_ENABLED__
        ." WHERE entity_id=" . $_entityId;
    return $db->query($sql);
}
