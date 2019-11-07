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

namespace Net7\PhpWord\Writer\RTF\Part;

use Net7\PhpWord\Escaper\Rtf;
use Net7\PhpWord\Exception\Exception;
use Net7\PhpWord\Writer\AbstractWriter;

/**
 * @since 0.11.0
 */
abstract class AbstractPart
{
    /**
     * @var \Net7\PhpWord\Writer\AbstractWriter
     */
    private $parentWriter;

    /**
     * @var \Net7\PhpWord\Escaper\EscaperInterface
     */
    protected $escaper;

    public function __construct()
    {
        $this->escaper = new Rtf();
    }

    /**
     * @return string
     */
    abstract public function write();

    /**
     * @param \Net7\PhpWord\Writer\AbstractWriter $writer
     */
    public function setParentWriter(AbstractWriter $writer = null)
    {
        $this->parentWriter = $writer;
    }

    /**
     * @throws \Net7\PhpWord\Exception\Exception
     * @return \Net7\PhpWord\Writer\AbstractWriter
     */
    public function getParentWriter()
    {
        if ($this->parentWriter !== null) {
            return $this->parentWriter;
        }
        throw new Exception('No parent WriterInterface assigned.');
    }
}
