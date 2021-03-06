<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2017 (original work) Open Assessment Technologies SA;
 *
 */

namespace oat\oatbox\log;


use Psr\Log\LogLevel;

class VerboseLoggerFactory
{
    /**
     * @var array   The verbose parameters and the connected log levels.
     */
    private static $levels = array(
        '-vvvv'       => LogLevel::DEBUG,
        '--verbose 4' => LogLevel::DEBUG,

        '-vvv'        => LogLevel::INFO,
        '--verbose 3' => LogLevel::INFO,

        '-vv'         => LogLevel::NOTICE,
        '--verbose 2' => LogLevel::NOTICE,

        '-v'          => LogLevel::ERROR,
        '--verbose 1' => LogLevel::ERROR,
    );

    /**
     * Make sure it can't be instantiated.
     */
    private function __construct()
    {
    }

    /**
     * Returns the configured instance of the verbose logger based on the arguments.
     *
     * @param array $arguments   The cli arguments.
     *
     * @return ColoredVerboseLogger|VerboseLogger
     */
    public static function getInstance(array $arguments)
    {
        if (in_array('-nc', $arguments) || in_array('--no-color', $arguments)) {
            return new VerboseLogger(static::getLogLevel($arguments));
        }

        return new ColoredVerboseLogger(static::getLogLevel($arguments));
    }

    /**
     * Returns the current log level based on the verbosity parameters.
     *
     * @param array $arguments
     *
     * @return string   Current log level or as default LogLevel::EMERGENCY
     */
    protected static function getLogLevel(array $arguments)
    {
        $argumentsForSearch = implode(' ', $arguments);
        foreach (static::$levels as $argumentPattern => $currentLevel) {
            if (strpos($argumentsForSearch, $argumentPattern) !== false) {
                return $currentLevel;
            }
        }

        return LogLevel::EMERGENCY;
    }
}
