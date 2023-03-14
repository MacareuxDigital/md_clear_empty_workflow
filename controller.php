<?php

namespace Concrete\Package\MdClearEmptyWorkflow;

use Concrete\Core\Command\Task\Manager as TaskManager;
use Concrete\Core\Package\Package;
use Macareux\ClearEmptyWorkflow\Task\Controller\ClearEmptyWorkflowController;

class Controller extends Package
{
    protected $appVersionRequired = '9.0.0';

    protected $pkgHandle = 'md_clear_empty_workflow';

    protected $pkgVersion = '0.0.1';

    protected $pkgAutoloaderRegistries = [
        'src' => '\Macareux\ClearEmptyWorkflow',
    ];

    public function getPackageName()
    {
        return t('Macareux Clear Empty Workflow');
    }

    public function getPackageDescription()
    {
        return t('Install a task to remove annoying workflow notifications you can not approve or deny.');
    }

    public function install()
    {
        $pkg = parent::install();

        $this->installContentFile('install/tasks.xml');

        return $pkg;
    }

    public function on_start()
    {
        /** @var TaskManager $taskManager */
        $taskManager = $this->app->make(TaskManager::class);
        $taskManager->extend('clear_empty_workflow', function () {
            return app(ClearEmptyWorkflowController::class);
        });
    }
}
