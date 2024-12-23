<?php

/*
 * The MIT License
 *
 * Copyright (c) 2010 Johannes Mueller <circus2(at)web.de>
 * Copyright (c) 2012-2024 Toha <tohenk@yahoo.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace MwbExporter\Formatter\Doctrine1\Yaml\Model;

use MwbExporter\Configuration\Comment as CommentConfiguration;
use MwbExporter\Configuration\Header as HeaderConfiguration;
use MwbExporter\Formatter\Doctrine1\Yaml\Configuration\TableNameExtend as TableNameExtendConfiguration;
use MwbExporter\Model\Table as BaseTable;
use MwbExporter\Writer\WriterInterface;

class Table extends BaseTable
{
    public function getActAsBehaviour()
    {
        return trim((string) $this->parseComment('actAs'));
    }

    public function getExternalRelations()
    {
        // processing external Relation
        // {d:externalRelations}[..]{/d:externalRelations}
        return trim((string) $this->parseComment('externalRelations'));
    }

    public function getInheritances()
    {
        return trim((string) $this->parseComment('inheritances'));
    }

    public function getModelName()
    {
        if ($this->isExternal()) {
            return $this->getRawTableName();
        } else {
            return parent::getModelName();
        }
    }

    public function writeTable(WriterInterface $writer)
    {
        if (!$this->isExternal()) {
            $writer
                ->open($this->getTableFileName())
                ->writeCallback(function(WriterInterface $writer, ?Table $_this = null) {
                    /** @var \MwbExporter\Configuration\Header $header */
                    $header = $this->getConfig(HeaderConfiguration::class);
                    if ($content = $header->getHeader()) {
                        $writer
                            ->writeComment($content)
                            ->write('')
                        ;
                    }
                    if ($_this->getConfig(CommentConfiguration::class)->getValue()) {
                        if ($content = $_this->getFormatter()->getComment(null)) {
                            $writer
                                ->writeComment($content)
                                ->write('')
                            ;
                        }
                    }
                })
                ->write('%s:', $this->getModelName())
                ->indent()
                ->writeIf($actAs = $this->getActAsBehaviour(), $actAs)
                ->write('tableName: '.($this->getConfig(TableNameExtendConfiguration::class)->getValue() ? $this->getSchema()->getName().'.' : '').$this->getRawTableName())
                ->writeCallback(function(WriterInterface $writer, ?Table $_this = null) {
                    $_this->getColumns()->write($writer);
                })
                ->writeCallback(function(WriterInterface $writer, ?Table $_this = null) {
                    $externalRelation = $_this->getExternalRelations();
                    if (count($_this->getTableRelations()) || $externalRelation) {
                        $writer->write('relations:');
                        $writer->indent();
                        foreach ($_this->getTableRelations() as $relation) {
                            $relation->write($writer);
                        }
                        if ($externalRelation) {
                            $writer->write($externalRelation);
                        }
                        $writer->outdent();
                    }
                })
                ->writeCallback(function(WriterInterface $writer, ?Table $_this = null) {
                    if (count($_this->getTableIndices())) {
                        $writer->write('indexes:');
                        $writer->indent();
                        foreach ($_this->getTableIndices() as $index) {
                            $index->write($writer);
                        }
                        $writer->outdent();
                    }
                })
                ->write('options:')
                ->indent()
                ->write('charset: '.(($charset = $this->parameters->get('defaultCharacterSetName')) ? $charset : 'utf8'))
                ->writeIf($engine = $this->parameters->get('tableEngine'), 'type: '.$engine)
                ->outdent()
                ->outdent()
                ->writeIf($inheritances = $this->getInheritances(), $inheritances)
                ->close()
            ;

            return self::WRITE_OK;
        }

        return self::WRITE_EXTERNAL;
    }
}
