<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace Belazor\RateLimit;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\Mvc\Application;
use Belazor\RateLimit\Mvc\RateLimitRequestListener;

/**
 * Module
 *
 * @license MIT
 * @author Fillip Hannisdal <fillip@dragonbyte-tech.com>
 */
class Module
{
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(MvcEvent $e)
    {
        /** @var Application $application */
        $application     = $e->getApplication();
        $config          = $application->getConfig();

        if (!isset($config['rate_limit']['storage'])
            || empty($config['rate_limit']['storage'])
        ) {
            return;
        }

        $serviceManager  = $application->getServiceManager();
        $eventManager    = $application->getEventManager();

        /** @var RateLimitRequestListener $listener */
        $listener = $serviceManager->get(RateLimitRequestListener::class);
        $listener->attach($eventManager);
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }
}
