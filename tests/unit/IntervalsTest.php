<?php
declare(strict_types=1);
namespace Interval;
require_once __DIR__ . '/../../vendor/autoload.php';

use Interval\Interval;
use Interval\Intervals;
use \Mockery as m;
class IntervalsTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function toStringTestProvider()
    {
        return [
            [[], '{}'],
            [[[0, 1]], '{[0, 1]}'],
            [[[0, 1], [3, 7]], '{[0, 1], [3, 7]}']
        ];
    }

    /**
     * @dataProvider toStringTestProvider
     * @param array $intervalsData
     * @param $expected
     * @test
     */
    public function toStringTest(array $intervalsData, $expected)
    {
        $array = [];
        foreach ($intervalsData as $intervalData) {
            $array[] = new Interval($intervalData[0], $intervalData[1]);
        }

        $intervals = new Intervals($array);
        $this->assertSame($expected, (string)$intervals);
    }

    public function excludePeriodsFromOtherPeriodsProvider()
    {
        return [
            [
                [
                    ['10:00', '12:00'],
                ],
                [],
                [
                    ['10:00', '12:00'],
                ],
            ],
            [
                [
                    ['10:00', '12:00'],
                ],
                [
                    ['09:00', '10:00'],
                    ['12:00', '14:00'],
                ],
                [
                    ['10:00', '12:00'],
                ],
            ],
            [
                [
                    ['10:00', '12:00'],
                ],
                [
                    ['10:30', '11:30'],
                ],
                [
                    ['10:00', '10:30'],
                    ['11:30', '12:00'],
                ],
            ],
            [
                [
                    ['10:00', '14:00'],
                ],
                [
                    ['11:00', '11:30'],
                    ['12:00', '12:30'],
                ],
                [
                    ['10:00', '11:00'],
                    ['11:30', '12:00'],
                    ['12:30', '14:00'],
                ],
            ],
            [
                [
                    ['10:00', '14:00'],
                    ['15:00', '16:00'],
                ],
                [
                    ['11:00', '11:30'],
                    ['12:00', '15:30'],
                ],
                [
                    ['10:00', '11:00'],
                    ['11:30', '12:00'],
                    ['15:30', '16:00'],
                ],
            ],
            [
                [
                    ['10:00', '13:00'],
                ],
                [
                    ['10:00', '12:00'],
                    ['12:00', '13:00'],
                ],
                [],
            ],
        ];
    }
}