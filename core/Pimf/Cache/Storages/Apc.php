<?php
/**
 * Pimf
 *
 * PHP Version 5
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://krsteski.de/new-bsd-license/
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to gjero@krsteski.de so we can send you a copy immediately.
 *
 * @copyright Copyright (c) 2010-2011 Gjero Krsteski (http://krsteski.de)
 * @license http://krsteski.de/new-bsd-license New BSD License
 */

/**
 * @package Pimf_Cache_Storages
 * @author Gjero Krsteski <gjero@krsteski.de>
 */
class Pimf_Cache_Storages_Apc extends Pimf_Cache_Storages_Storage
{
  /**
   * The cache key from the cache configuration file.
   * @var string
   */
  protected $key;

  /**
   * Create a new APC cache storage instance.
   * @param string $key
   */
  public function __construct($key)
  {
    $this->key = (string)$key;
  }

  /**
   * Retrieve an item from the cache storage.
   * @param string $key
   * @return mixed
   */
  protected function retrieve($key)
  {
    if (($cache = apc_fetch($this->key . $key)) !== false) {
      return $cache;
    }
  }

  /**
   * Write an item to the cache for a given number of minutes.
   *
   * <code>
   *    // Put an item in the cache for 15 minutes
   *    Cache::put('name', 'Robin', 15);
   * </code>
   *
   * @param string $key
   * @param mixed $value
   * @param int $minutes
   * @return bool|void
   */
  public function put($key, $value, $minutes)
  {
    return apc_store('' . $this->key . $key, $value, (int)$minutes * 60);
  }

  /**
   * Write an item to the cache that lasts forever.
   *
   * @param  string  $key
   * @param  mixed   $value
   * @return bool
   */
  public function forever($key, $value)
  {
    return $this->put($key, $value, 0);
  }

  /**
   * Delete an item from the cache.
   *
   * @param  string  $key
   * @return void
   */
  public function forget($key)
  {
    apc_delete($this->key . $key);
  }
}