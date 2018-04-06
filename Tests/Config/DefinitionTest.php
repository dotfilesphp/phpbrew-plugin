<?php

namespace Dotfiles\Plugins\PHPBrew\Tests\Config;

use Dotfiles\Core\Config\Config;

use Dotfiles\Plugins\PHPBrew\Config\Definition;
use PHPUnit\Framework\TestCase;

class DefinitionTest extends TestCase
{
    public function testProcess()
    {
        $cachePath = sys_get_temp_dir().'/dotfiles/test/cache/config.php';
        if(is_file($cachePath)){
            unlink($cachePath);
        }
        $config = new Config();
        $config->addDefinition(new Definition());
        $config->addConfigDir(__DIR__.'/fixtures');
        $config->setCachePath($cachePath);
        $config->loadConfiguration();
        $processed = $config->get();

        $this->assertTrue($processed['phpbrew']['set_prompt']);
        $this->assertArrayHasKey('machines',$processed['phpbrew']);
    }

}
