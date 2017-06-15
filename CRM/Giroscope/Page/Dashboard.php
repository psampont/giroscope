<?php

require_once 'CRM/Core/Page.php';

class CRM_Giroscope_Page_Dashboard extends CRM_Core_Page {
  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('Dashboard'));

    $query = "
  SELECT
   com.giro_type_num AS type,
   com.entity_id AS entity_id,
   com.num,
   com.description AS com_description,
   type.entity,
   type.description as type_description
  FROM
   civicrm_giro_scope as com LEFT JOIN civicrm_giro_type as type ON com.giro_type_num = type.num
  ORDER BY  type, entity_id, com.num;  ";
    $result = array();
    $query_result = CRM_Core_DAO::executeQuery($query);
    while ($query_result->fetch()) {
      $modulo = ((($query_result->type * 10000) + $query_result->entity_id *1000) + $query_result->num) % 97;  
      $result[$query_result->entity][] = array(
        "type" => $query_result->type_description, 
        "entity_id" => $query_result->entity_id,  
        "index" => $query_result->num, 
        "description" => $query_result->com_description,
        "communication" => sprintf("+++%03s/%04s/%03s%02s+++",$query_result->type, $query_result->entity_id, $query_result->num, $modulo)
      );
    }

    $this->assign('entities', $result);

    parent::run();
  }
}
