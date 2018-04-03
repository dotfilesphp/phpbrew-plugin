<?php

namespace Dotfiles\Plugins\PHPBrew\Tests;

use Dotfiles\Plugins\PHPBrew\PHPBrewPlugin;
use Dotfiles\Core\Event\Dispatcher;
use Dotfiles\Plugins\Bash\Event\ReloadBashConfigEvent;
use Dotfiles\Core\Config\Config;

use PHPUnit\Framework\TestCase;

class PHPBrewPluginTest extends TestCase
{
    public function testGetName()
    {
        $phpbrew = new PHPBrewPlugin();
        $this->assertEquals('PHPBrew',$phpbrew->getName());
    }

    public function testHandleBashConfig()
    {
        $config = $this->createMock(Config::class);
        $config->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap([
                ['phpbrew.set_prompt', true],
                ['phpbrew.rc_enable',true],
            ]))
        ;
        $event = $this->createMock(ReloadBashConfigEvent::class);
        $event->expects($this->any())
            ->method('getConfig')
            ->willReturn($config)
        ;
        $event->expects($this->exactly(2))
            ->method('addHeaderConfig')
            ->withConsecutive(
                ['export PHPBREW_SET_PROMPT=1'],
                ['export PHPBREW_RC_ENABLE=1']
            )
        ;
        $event->expects($this->once())
            ->method('addFooterConfig')
            ->with('source $HOME/.phpbrew/bashrc')
        ;
        $phpbrew = new PHPBrewPlugin();
        $phpbrew->handleBashConfig($event);
    }
}
