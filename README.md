![Build Status](https://github.com/mysql-workbench-schema-exporter/doctrine1-exporter/actions/workflows/continuous-integration.yml/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/mysql-workbench-schema-exporter/doctrine1-exporter/v/stable.svg)](https://packagist.org/packages/mysql-workbench-schema-exporter/doctrine1-exporter)
[![Total Downloads](https://poser.pugx.org/mysql-workbench-schema-exporter/doctrine1-exporter/downloads.svg)](https://packagist.org/packages/mysql-workbench-schema-exporter/doctrine1-exporter) 
[![License](https://poser.pugx.org/mysql-workbench-schema-exporter/doctrine1-exporter/license.svg)](https://packagist.org/packages/mysql-workbench-schema-exporter/doctrine1-exporter)

# README

This is an exporter to convert [MySQL Workbench](http://www.mysql.com/products/workbench/) Models (\*.mwb) to Doctrine 1 YAML Schema.

## Prerequisites

  * PHP 7.2+
  * Composer to install the dependencies

## Installation

```
composer require --dev mysql-workbench-schema-exporter/doctrine1-exporter
```

This will install the exporter and also require [mysql-workbench-schema-exporter](https://github.com/mysql-workbench-schema-exporter/doctrine1-exporter).

You then can invoke the CLI script using `vendor/bin/mysql-workbench-schema-export`.

## Configuration

  * [Doctrine 1.0 YAML Schema](/docs/doctrine1-yaml.md)

## Command Line Interface (CLI)

See documentation for [mysql-workbench-schema-exporter](https://github.com/mysql-workbench-schema-exporter/doctrine1-exporter#command-line-interface-cli)

## Links

  * [MySQL Workbench](http://wb.mysql.com/)
  * [Doctrine Project](http://www.doctrine-project.org/)
