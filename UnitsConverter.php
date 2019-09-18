<?php

namespace Stanford\UnitsConverter;


/**
 * Class UnitsConverter
 * @package Stanford\UnitsConverter
 * @property array $fields;
 * @property int $projectId;
 * @property string $instrument;
 */
class UnitsConverter extends \ExternalModules\AbstractExternalModule
{

    private $fields;

    private $projectId;

    private $instrument;

    public function __construct()
    {
        try {
            parent::__construct();
            if (isset($_GET['pid'])) {
                $this->setProjectId(filter_var($_GET['pid'], FILTER_SANITIZE_NUMBER_INT));
            }
        } catch (\LogicException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return string
     */
    public function getInstrument()
    {
        return $this->instrument;
    }

    /**
     * @param string $instrument
     */
    public function setInstrument($instrument)
    {
        $this->instrument = $instrument;
    }

    /**
     * @return int
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param int $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function redcap_data_entry_form_top(
        $project_id,
        $record = null,
        $instrument,
        $event_id,
        $group_id = null,
        $repeat_instance = 1
    ) {
        $this->setInstrument($instrument);
        $this->getInstrumentFields();

        $this->includeFile("view/converter.php");
    }

    private function getInstrumentFields()
    {

        $instrument = $this->getInstrument();
        $projectId = $this->getProjectId();

        $sql = "select * from redcap_metadata where form_name = '$instrument' and project_id ='$projectId'";


        $q = db_query($sql);

        if (db_num_rows($q) > 0) {
            $fields = array();
            while ($row = db_fetch_assoc($q)) {
                $fields[] = $row;
            }
            $this->setFields($fields);
        }
    }

    /**
     * @param string $path
     */
    private function includeFile($path)
    {
        include_once $path;
    }
}