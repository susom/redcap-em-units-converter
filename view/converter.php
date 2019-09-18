<?php

namespace Stanford\UnitsConverter;

/** @var \Stanford\UnitsConverter\UnitsConverter $this */


/**
 * get all fields with notes
 */
$notesFields = array();
foreach ($this->getFields() as $field) {
    if ($field['element_note'] != null) {
        $parts = explode("=", $field['element_note']);
        $field['type'] = $parts[0];
        $field['unit'] = end($parts);
        $notesFields[] = $field;
    }
}


?>
<script src="<?php echo $this->getUrl('assets/js/converter.js') ?>"></script>
<script>
    Converter.fields = <?php echo json_encode($notesFields)  ?>;

    Converter.init();
</script>
