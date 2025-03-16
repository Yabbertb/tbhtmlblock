<?php
/**
 * 2007-2016 PrestaShop
 *
 * Thirty Bees is an extension to the PrestaShop e-commerce software developed by PrestaShop SA
 * Copyright (C) 2017-2024 thirty bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * @author    Thirty Bees <modules@thirtybees.com>
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2017-2024 thirty bees
 * @copyright 2007-2016 PrestaShop SA
 * @license   https://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  PrestaShop is an internationally registered trademark & property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @param TbHtmlBlock $object
 * @param bool $install
 *
 * @return bool
 * @throws PrestaShopDatabaseException
 * @throws PrestaShopException
 */
function upgrade_module_1_4($object, $install = false)
{
    if ($object->active || $install) {
        $results = [];
        $results[] = Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'tbhtmlblock_shop` (
                `id_block` INT(11) UNSIGNED NOT NULL,
                `id_shop` INT(11) UNSIGNED NOT NULL DEFAULT 1,
                PRIMARY KEY (`id_block`, `id_shop`)
            ) ENGINE='._MYSQL_ENGINE_.' CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ');
        $results[] = Db::getInstance()->execute('
            INSERT INTO `'._DB_PREFIX_.'tbhtmlblock_shop` (id_block)
            SELECT id_block
            FROM `'._DB_PREFIX_.'tbhtmlblock`
        ');
        foreach ($results as $result) {
            if (!$result) {
                return false;
            }
        }
        return true;
    }
    return false;
}
