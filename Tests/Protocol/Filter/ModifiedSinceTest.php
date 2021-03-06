<?php

namespace Debril\RssAtomBundle\Protocol\Filter;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-02-12 at 22:48:55.
 */
class ModifiedSinceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ModifiedSince
     */
    protected $object;

    /**
     *
     * @var DateTime
     */
    protected $date;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->date = new \DateTime();
        $this->object = new ModifiedSince($this->date);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers Debril\RssAtomBundle\Protocol\Filter\ModifiedSince::getDate
     * @todo   Implement testGetDate().
     */
    public function testGetDate()
    {
        $this->assertInstanceOf('\DateTime', $this->object->getDate());
        $this->assertEquals($this->date, $this->object->getDate());
    }

    /**
     * @covers Debril\RssAtomBundle\Protocol\Filter\ModifiedSince::isValid
     * @todo   Implement testIsValid().
     */
    public function testIsValid()
    {
        $item = new \Debril\RssAtomBundle\Protocol\Parser\Item();

        $date = clone $this->date;
        $this->assertFalse($this->object->isValid($item), 'Item must not be valid if no date is specified');
        $item->setUpdated($date->sub(new \DateInterval('P1D')));
        $this->assertFalse($this->object->isValid($item), 'Item must not be valid if its date is prior to modifiedSince');
        $item->setUpdated($date->add(new \DateInterval('P2D')));
        $this->assertTrue($this->object->isValid($item), 'Item must be valid if its date is after modifiedSince');
    }

}
