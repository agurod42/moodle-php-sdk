<?php namespace MoodleSDK\Api\Model;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Api\ModelBase;
use MoodleSDK\Api\ModelCRUD;

class Course extends ModelBase implements ModelCRUD {

    private $id;
    private $shortName;
    private $displayName;
    private $fullName;
    private $format;
    private $summary;
    private $summaryFormat;
    private $summaryFiles;
    private $overviewFiles;
    private $categoryId;
    private $startDate;
    private $endDate;
    private $contacts;

    public function get(ApiContext $apiContext) {
        $json = $this->apiCall($apiContext, 'core_course_get_courses_by_field', [
            'field' => 'shortname',
            'value' => $this->getShortName()
        ]);

        $results = json_decode($json);

        $this->fromObject($results->courses[0]);

        return $this;
    }

    public function create(ApiContext $apiContext) {
        $json = $this->apiCall($apiContext, 'core_course_create_courses', [
            'courses' => [
                $this->toArray()
            ]
        ]);

        return $json;
    }
 
    public function update(ApiContext $apiContext) {
        $json = $this->apiCall($apiContext, 'core_course_update_courses', [
            'courses' => [
                $this->toArray()
            ]
        ]);

        return $json;
    }

    public function delete(ApiContext $apiContext) {
        $json = $this->apiCall($apiContext, 'core_course_delete_courses', [
            'courseids' => [$this->getId()]
        ]);

        return $json;
    }

    public function all(ApiContext $apiContext) {
        // $json = $this->apiCall($apiContext, 'core_course_get_courses', [
        //     'options' => [
        //         'ids' => [
        //         ]
        //     ]
        // ]);

        // $list = new UserList();
        // $list->fromJSON($json);
        // return $list;
    }

    public function fromArrayExcludedProperties() {
        return ['enrollmentmethods'];
    }

    public function toArrayExcludedProperties() {
        return ['displayname'];
    }

    // Properties Getters & Setters

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getShortName() {
        return $this->shortName;
    }

    public function setShortName($shortName) {
        $this->shortName = $shortName;
        return $this;
    }

    public function getDisplayName() {
        return $this->displayName;
    }

    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
        return $this;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName($fullName) {
        $this->fullName = $fullName;
        return $this;
    }

    public function getFormat() {
        return $this->format;
    }

    public function setFormat($format) {
        $this->format = $format;
        return $this;
    }

    public function getSummary() {
        return $this->sumary;
    }

    public function setSummary($summary) {
        $this->summary = $summart;
        return $this;
    }

    public function getSummaryFormat() {
        return $this->summaryFormat;
    }

    public function setSummaryFormat($summaryFormat) {
        $this->summaryFormat = $summaryFormat;
        return $this;
    }

    /**
     * @return File[]
     */
    public function getSummaryFiles() {
        return $this->summaryFiles;
    }

    public function setSummaryFiles($summaryFiles) {
        $this->summaryFiles = $summaryFiles;
        return $this;
    }

    /**
     * @return File[]
     */
    public function getOverviewFiles() {
        return $this->overviewFiles;
    }

    public function setOverviewFiles($overviewFiles) {
        $this->overviewFiles = $overviewFiles;
        return $this;
    }
    
    public function getCategoryId() {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return Contact[]
     */
    public function getContacts() {
        return $this->contacts;
    }

    public function setContacts($contacts) {
        $this->contacts = $contacts;
        return $this;
    }

}