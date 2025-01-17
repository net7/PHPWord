<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2018 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace Net7\PhpWord\Writer\Word2007\Style;

use PhpOffice\Common\XMLWriter;
use Net7\PhpWord\Settings;

/**
 * Style writer
 *
 * @since 0.10.0
 */
abstract class AbstractStyle
{
    /**
     * XML writer
     *
     * @var \PhpOffice\Common\XMLWriter
     */
    private $xmlWriter;

    /**
     * Style; set protected for a while
     *
     * @var string|\Net7\PhpWord\Style\AbstractStyle
     */
    protected $style;

    /**
     * Write style
     */
    abstract public function write();

    /**
     * Create new instance.
     *
     * @param \PhpOffice\Common\XMLWriter $xmlWriter
     * @param string|\Net7\PhpWord\Style\AbstractStyle $style
     */
    public function __construct(XMLWriter $xmlWriter, $style = null)
    {
        $this->xmlWriter = $xmlWriter;
        $this->style = $style;
    }

    /**
     * Get XML Writer
     *
     * @return \PhpOffice\Common\XMLWriter
     */
    protected function getXmlWriter()
    {
        return $this->xmlWriter;
    }

    /**
     * Get Style
     *
     * @return string|\Net7\PhpWord\Style\AbstractStyle
     */
    protected function getStyle()
    {
        return $this->style;
    }

    /**
     * Convert twip value
     *
     * @param int|float $value
     * @param int $default (int|float)
     * @return int|float
     */
    protected function convertTwip($value, $default = 0)
    {
        $factors = array(
            Settings::UNIT_CM    => 567,
            Settings::UNIT_MM    => 56.7,
            Settings::UNIT_INCH  => 1440,
            Settings::UNIT_POINT => 20,
            Settings::UNIT_PICA  => 240,
        );
        $unit = Settings::getMeasurementUnit();
        $factor = 1;
        if (in_array($unit, $factors) && $value != $default) {
            $factor = $factors[$unit];
        }

        return $value * $factor;
    }

    /**
     * Write child style.
     *
     * @param \PhpOffice\Common\XMLWriter $xmlWriter
     * @param string $name
     * @param mixed $value
     */
    protected function writeChildStyle(XMLWriter $xmlWriter, $name, $value)
    {
        if ($value !== null) {
            $class = 'PhpOffice\\PhpWord\\Writer\\Word2007\\Style\\' . $name;

            /** @var \Net7\PhpWord\Writer\Word2007\Style\AbstractStyle $writer */
            $writer = new $class($xmlWriter, $value);
            $writer->write();
        }
    }

    /**
     * Writes boolean as 0 or 1
     *
     * @param bool $value
     * @return null|string
     */
    protected function writeOnOf($value = null)
    {
        if ($value === null) {
            return null;
        }

        return $value ? '1' : '0';
    }

    /**
     * Assemble style array into style string
     *
     * @param array $styles
     * @return string
     */
    protected function assembleStyle($styles = array())
    {
        $style = '';
        foreach ($styles as $key => $value) {
            if (!is_null($value) && $value != '') {
                $style .= "{$key}:{$value}; ";
            }
        }

        return trim($style);
    }
}
