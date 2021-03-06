<?php
namespace Litepie\Install;

use Illuminate\Console\Command;
use Litepie\Install\Installers\Installer;
use Litepie\Install\Installers\Traits\BlockMessage;
use Litepie\Install\Installers\Traits\SectionMessage;

class InstallCommand extends Command
{
    use BlockMessage, SectionMessage;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lavalite:install {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Lavalite';

    /**
     * @var Installer
     */
    private $installer;

    /**
     * Create a new command instance.
     *
     * @param Installer $installer
     * @internal param Filesystem $finder
     * @internal param Application $app
     * @internal param Composer $composer
     */
    public function __construct(Installer $installer)
    {
        parent::__construct();
        $this->getLaravel()['env'] = 'local';
        $this->installer           = $installer;
    }

    /**
     * Execute the actions
     *
     * @return mixed
     */
    public function handle()
    {
        $this->blockMessage('Welcome!', 'Starting the installation process...', 'comment');

        $success = $this->installer->stack([
            \Litepie\Install\Installers\Scripts\ProtectInstaller::class,
            \Litepie\Install\Installers\Scripts\ConfigureDatabase::class,
            \Litepie\Install\Installers\Scripts\SetAppKey::class,
            \Litepie\Install\Installers\Scripts\PackgeAssets::class,
            \Litepie\Install\Installers\Scripts\GenerateAutoload::class,
            \Litepie\Install\Installers\Scripts\PackageMigrators::class,
            \Litepie\Install\Installers\Scripts\PackageSeeders::class,
            \Litepie\Install\Installers\Scripts\PublishTheme::class,
            \Litepie\Install\Installers\Scripts\SetSuperuserUser::class,
        ])->install($this);

        if ($success) {
            $this->info('Lavalite is ready! You can now login with your username and password at [your application path/admin]');
        }

    }

}
