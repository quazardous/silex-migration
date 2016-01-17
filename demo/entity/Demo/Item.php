<?php
namespace Demo;

/**
 * @Entity
 * @Table(name="item")
 */
class Item
{
    /**
     * @Id @Column(type="integer", nullable=false, options={"unsigned" = true}) @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string", length=32, nullable=true)
     */
    protected $value;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Item
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
