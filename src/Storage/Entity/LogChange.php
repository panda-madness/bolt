<?php

namespace Bolt\Storage\Entity;

use Bolt\Collection\Bag;
use Bolt\Storage\Mapping\ClassMetadata;

/**
 * Entity for change logs.
 */
class LogChange extends Entity
{
    /** @var \DateTime */
    protected $date;
    /** @var int */
    protected $ownerid;
    /** @var string */
    protected $title;
    /** @var string */
    protected $contenttype;
    /** @var int */
    protected $contentid;
    /** @var string */
    protected $mutation_type;
    /** @var array */
    protected $diff;
    /** @var string */
    protected $comment;
    /** @var ClassMetadata */
    protected $contentTypeMeta;

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->ownerid;
    }

    /**
     * @param int $ownerId
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerid = $ownerId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contenttype;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contenttype = $contentType;
    }

    /**
     * @return int
     */
    public function getContentId()
    {
        return $this->contentid;
    }

    /**
     * @param int $contentId
     */
    public function setContentId($contentId)
    {
        $this->contentid = $contentId;
    }

    /**
     * @return string
     */
    public function getMutationType()
    {
        return $this->mutation_type;
    }

    /**
     * @param string $mutationType
     */
    public function setMutationType($mutationType)
    {
        $this->mutation_type = $mutationType;
    }

    /**
     * @return array
     */
    public function getDiff()
    {
        return $this->diff;
    }

    /**
     * @param array $diff
     */
    public function setDiff($diff)
    {
        $this->diff = $diff;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Allows injecting the metadata configuration into the record so output can be built based on variable types.
     *
     * @param ClassMetadata $config
     */
    public function setContentTypeMeta(ClassMetadata $config)
    {
        $this->contentTypeMeta = $config;
    }

    /**
     * Get changed fields.
     *
     * @param array $contentType
     *
     * @return array
     */
    public function getChangedFields(array $contentType)
    {
        $changedFields = Bag::from([]);

        if (empty($this->diff)) {
            return $changedFields;
        }

        // Get the ContentType that we're dealing with
        $fields = Bag::from($contentType['fields']);

        foreach ($this->diff as $key => $value) {
            if (!$fields->get($key)) {
                continue;
            }

            $type = $fields->get($key)['type'];
            $changedFields[$key] = [
                'type'   => $type,
                'label'  => empty($fields[$key]['label']) ? $key : $fields[$key]['label'],
                'before' => $value[0],
                'after'  => $value[1],
            ];

            $changedFields[$key] = array_merge($changedFields[$key], $this->fieldValues($key, $value, $fields));
        }

        return $changedFields;
    }

    /**
     * Compile changes for any field type.
     *
     * @param string $key
     * @param string $value
     * @param Bag    $fields
     *
     * @return array
     */
    private function fieldValues($key, $value, Bag $fields)
    {
        return [
            'type'   => $fields[$key]['type'],
            'before' => $value[0],
            'after'  => $value[1],
        ];
    }
}
