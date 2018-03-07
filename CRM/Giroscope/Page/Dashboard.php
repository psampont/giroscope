<?php

require_once 'CRM/Core/Page.php';

class CRM_Giroscope_Page_Dashboard extends CRM_Core_Page {
  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('Dashboard'));

    $query = "SELECT DISTINCT `entity` FROM `civicrm_giro_type` ORDER BY `num`";

    $query_result = CRM_Core_DAO::executeQuery($query);
    $entities = [];
    while ($query_result->fetch()) {
     $entities[] = ucfirst($query_result->entity);
    }
    $this->assign('entities', $entities);

    $query = "
  SELECT
   com.giro_type_num AS type,
   com.entity_id AS entity_id,
   com.num,
   com.description AS com_description,
   type.entity,
   type.description as type_description
  FROM
   civicrm_giro_scope as com RIGHT JOIN civicrm_giro_type as type ON com.giro_type_num = type.num
  ORDER BY  type, type.num, com.num;  ";
    $communications = [];
    $query_result = CRM_Core_DAO::executeQuery($query);
    while ($query_result->fetch()) {
      $query_result->entity= ucfirst($query_result->entity);
      $modulo = ((($query_result->type * 10000) + $query_result->entity_id *1000) + $query_result->num) % 97; 

      if ($query_result->entity_id != null) {
        switch ($query_result->entity) {
          case 'Campaign' :
          case 'Event' :
            $campaign = civicrm_api3($query_result->entity, 'getsingle', array(
              'sequential' => 1,
              'id' => $query_result->entity_id,
            ));
            $name = $campaign['title'];
            break;
          case 'Contact' :
            $campaign = civicrm_api3($query_result->entity, 'getsingle', array(
              'sequential' => 1,
              'id' => $query_result->entity_id,
            ));
            $name = $campaign['display_name'];
            break;
          default :
            $name = $query_result->entity.' n.'.$query_result->entity_id;
        }
      }
      else $name = '-';

      $communications[$query_result->entity][] = array(
        "type" => $query_result->type_description, 
        "entity_name" => $name,  
        "index" => $query_result->num, 
        "description" => $query_result->com_description,
        "communication" => sprintf("+++%03s/%04s/%03s%02s+++",$query_result->type, $query_result->entity_id, $query_result->num, $modulo)
      );
    }  

    $this->assign('communications', $communications);

    parent::run();
  }
}
