<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

declare(strict_types=1);

namespace core_reportbuilder\local\aggregation;

use core_reportbuilder_generator;
use core_reportbuilder\manager;
use core_reportbuilder\local\report\column;
use core_reportbuilder\tests\core_reportbuilder_testcase;
use core_user\reportbuilder\datasource\users;
use stdClass;

/**
 * Unit tests for max aggregation
 *
 * @package     core_reportbuilder
 * @covers      \core_reportbuilder\local\aggregation\base
 * @covers      \core_reportbuilder\local\aggregation\max
 * @copyright   2021 Paul Holden <paulh@moodle.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class max_test extends core_reportbuilder_testcase {

    /**
     * Test aggregation when applied to column
     */
    public function test_column_aggregation(): void {
        $this->resetAfterTest();

        // Test subjects.
        $this->getDataGenerator()->create_user(['firstname' => 'Bob', 'suspended' => 1]);
        $this->getDataGenerator()->create_user(['firstname' => 'Bob', 'suspended' => 0]);

        /** @var core_reportbuilder_generator $generator */
        $generator = $this->getDataGenerator()->get_plugin_generator('core_reportbuilder');
        $report = $generator->create_report(['name' => 'Users', 'source' => users::class, 'default' => 0]);

        // Report columns, aggregated/sorted by user suspended.
        $generator->create_column(['reportid' => $report->get('id'), 'uniqueidentifier' => 'user:firstname']);
        $generator->create_column([
            'reportid' => $report->get('id'),
            'uniqueidentifier' => 'user:suspended',
            'aggregation' => max::get_class_name(),
            'sortenabled' => 1,
            'sortdirection' => SORT_DESC,
        ]);

        $content = $this->get_custom_report_content($report->get('id'));
        $this->assertEquals([
            ['Bob', 'Yes'],
            ['Admin', 'No'],
        ], array_map('array_values', $content));
    }

    /**
     * Data provider for {@see test_column_aggregation_with_callback}
     *
     * @return array[]
     */
    public static function column_aggregation_with_callback_provider(): array {
        return [
            [column::TYPE_INTEGER, [
                '0 (max)',
                '1 (max)',
            ]],
            [column::TYPE_FLOAT, [
                '0.0 (max)',
                '1.0 (max)',
            ]],
            [column::TYPE_TIMESTAMP, [
                '0 (max)',
                '1 (max)',
            ]],
            [column::TYPE_BOOLEAN, [
                'false (max)',
                'true (max)',
            ]],
        ];
    }

    /**
     * Test aggregation when applied to column with callback
     *
     * @param int $columntype
     * @param string[] $expected
     *
     * @dataProvider column_aggregation_with_callback_provider
     */
    public function test_column_aggregation_with_callback(int $columntype, array $expected): void {
        $this->resetAfterTest();

        // Test subjects.
        $this->getDataGenerator()->create_user(['firstname' => 'Bob', 'suspended' => 1]);
        $this->getDataGenerator()->create_user(['firstname' => 'Bob', 'suspended' => 0]);

        /** @var core_reportbuilder_generator $generator */
        $generator = $this->getDataGenerator()->get_plugin_generator('core_reportbuilder');
        $report = $generator->create_report(['name' => 'Users', 'source' => users::class, 'default' => 0]);

        // First column, sorted.
        $generator->create_column(['reportid' => $report->get('id'), 'uniqueidentifier' => 'user:firstname', 'sortenabled' => 1]);

        // This is the column we'll aggregate.
        $generator->create_column(
            ['reportid' => $report->get('id'), 'uniqueidentifier' => 'user:suspended', 'aggregation' => max::get_class_name()]
        );

        // Set callback to format the column (hack column definition to ensure callbacks are executed).
        $instance = manager::get_report_from_persistent($report);
        $instance->get_column('user:suspended')
            ->set_type($columntype)
            ->set_callback(static function(int|float|bool $value, stdClass $row, $arguments, ?string $aggregation): string {
                // Simple callback to return the given value, and append aggregation type.
                return var_export($value, true) . " ({$aggregation})";
            });

        $content = $this->get_custom_report_content($report->get('id'));
        $this->assertEquals([
            ['Admin', $expected[0]],
            ['Bob', $expected[1]],
        ], array_map('array_values', $content));
    }
}
