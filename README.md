# README

![Build Status](https://github.com/mysql-workbench-schema-exporter/doctrine1-exporter/actions/workflows/continuous-integration.yml/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/mysql-workbench-schema-exporter/doctrine1-exporter/v/stable.svg)](https://packagist.org/packages/mysql-workbench-schema-exporter/doctrine1-exporter)
[![Total Downloads](https://poser.pugx.org/mysql-workbench-schema-exporter/doctrine1-exporter/downloads.svg)](https://packagist.org/packages/mysql-workbench-schema-exporter/doctrine1-exporter) 
[![License](https://poser.pugx.org/mysql-workbench-schema-exporter/doctrine1-exporter/license.svg)](https://packagist.org/packages/mysql-workbench-schema-exporter/doctrine1-exporter)

This is an exporter to convert [MySQL Workbench](http://www.mysql.com/products/workbench/) Models (\*.mwb) to Doctrine 1 YAML Schema.

## Prerequisites

  * PHP 5.4+
  * Composer to install the dependencies

## Installation

```
php composer.phar require --dev mysql-workbench-schema-exporter/doctrine1-exporter
```

This will install the exporter and also require [mysql-workbench-schema-exporter](https://github.com/mysql-workbench-schema-exporter/doctrine1-exporter).

You then can invoke the CLI script using `vendor/bin/mysql-workbench-schema-export`.

## Formatter Setup Options

Additionally to the [common options](https://github.com/mysql-workbench-schema-exporter/doctrine1-exporter#configuring-mysql-workbench-schema-exporter) of mysql-workbench-schema-exporter these options are supported:

### Doctrine 1.0 YAML Schema

#### Setup Options

  * `extendTableNameWithSchemaName`

    Include schema name beside the table name.

    Default is `false`.

#### Model Comment Behavior

  * `{d:externalRelations}relation{/d:externalRelations}`

  * `{MwbExporter:actAs}actAs: [Timestampable]{/MwbExporter:actAs}`

    The following example export Doctrine behavior by using Table comment:

        {MwbExporter:actAs}
          actAs:
            timestampable:
              [..]
        {/MwbExporter:actAs}

  * Foreign key name

    To replace relations name by the name of the foreign key, start the foreign key name with `d:`.


## Command Line Interface (CLI)

See documentation for [mysql-workbench-schema-exporter](https://github.com/mysql-workbench-schema-exporter/doctrine1-exporter#command-line-interface-cli)

## Links

  * [MySQL Workbench](http://wb.mysql.com/)
  * [Doctrine Project](http://www.doctrine-project.org/)
