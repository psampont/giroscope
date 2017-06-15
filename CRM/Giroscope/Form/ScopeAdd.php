<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Giroscope_Form_ScopeAdd extends CRM_Core_Form {
  public $_mode='campaign';

  public function buildQuickForm() {

    // add fields elements
    $this->add(
      'select', // field type
      'category', // field name
      'Category', // field label
      $this->getCategoriesOptions($this->_mode), // list of options
      TRUE // is required
    );
    switch ($this->_mode) {
      case "contact": 
	$this->addEntityRef('object', ts('Select Contact'), array(
	  'create' => TRUE
	), TRUE);
        break;
      case "campaign": 
        $this->addEntityRef('object', ts('Select Campaign'), array(
          'entity' => 'campaign',
          'placeholder' => ts('- Select a campaign'),
          'select' => array('minimumInputLength' => 0),
        ),TRUE);
        break;
      default :
        $this->addEntityRef('object', ts('Select Event'), array(
          'entity' => 'event',
          'placeholder' => ts('- Select an event -'),
          'select' => array('minimumInputLength' => 0),
        ),TRUE);
    }
    // add form elements
    $this->add(
      'text', // field type
      'index', // field name
      'Index', // field label
      array ('size' => 3, 'maxlength' => '3'),
      TRUE // is required
    );
    $this->add(
      'text', // field type
      'description', // field name
      'Description', // field label
      'ABC',
      FALSE // is required
    );

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Create'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  /**
   * This function is called prior to building and submitting the form
   */
  function preProcess() {
    $this->_mode = CRM_Utils_Request::retrieve('mode', 'String');
  }


  public function postProcess() {
    $values = $this->exportValues();
    $options = $this->getCategoriesOptions();

    $query = '
      INSERT INTO `civicrm_giro_scope`
        (`giro_type_num`, `entity_id`, `num`, `description`) 
      VALUES 
        (
         '.$values['category'].',
         '.$values['object'].',
         '.$values['index'].',
         "'.$values['description'].'"
       )
    ';
    $query_result = CRM_Core_DAO::executeQuery($query);

    CRM_Core_Session::setStatus(ts('Structured communication : +++%1/%2/%399+++ created.', array(
       1 => $values['category'], 
       2 => $values['object'], 
       3 => $values['index'] 
   )));

    parent::postProcess();
  }

  public function getEventsOptions() {
    $result = civicrm_api3('Event', 'getlist', array(
      'sequential' => 1,
    ));
    foreach ($result['values'] as $event) {
      $options[$event['id']] = $event['description'][0];
    }
    return $options;
  }


  public function getCampaignsOptions() {
    $result = civicrm_api3('Campaign', 'getlist', array(
      'sequential' => 1,
    ));
    foreach ($result['values'] as $campaign) {
      if ($campaign['tille'] == null) {
        $options[$campaign['id']] = ts("Campaign")." n.".$campaign['id'];
      }
      else {
        $options[$campaign['id']] = $campaign['title'];
      }
    }
    return $options;
  }

  public function getCategoriesOptions($entity='%') {

    $query = "
  SELECT
   num,
   description
  FROM
   civicrm_giro_type
  WHERE entity LIKE '$entity' AND is_deleted = false;
  ";
    $options = array();
    $query_result = CRM_Core_DAO::executeQuery($query);
    while ($query_result->fetch()) {
      $options[$query_result->num] = $query_result->description;
    }

    return $options;
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }
}
