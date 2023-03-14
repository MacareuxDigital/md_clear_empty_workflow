<?php

namespace Macareux\ClearEmptyWorkflow\Task\Controller;

use Concrete\Core\Command\Batch\Batch;
use Concrete\Core\Command\Task\Controller\AbstractController;
use Concrete\Core\Command\Task\Input\InputInterface;
use Concrete\Core\Command\Task\Runner\BatchProcessTaskRunner;
use Concrete\Core\Command\Task\Runner\ProcessTaskRunner;
use Concrete\Core\Command\Task\Runner\TaskRunnerInterface;
use Concrete\Core\Command\Task\TaskInterface;
use Concrete\Core\Page\Workflow\Progress\ProgressList;
use Concrete\Core\User\Command\DeactivateUsersCommand;
use Concrete\Core\Workflow\EmptyWorkflow;
use Concrete\Core\Workflow\Progress\PageProgress;
use Concrete\Core\Workflow\Progress\Progress;
use Macareux\ClearEmptyWorkflow\Task\Command\ClearEmptyWorkflowCommand;

class ClearEmptyWorkflowController extends AbstractController
{
    public function getName(): string
    {
        return t('Clear Empty Workflow Progress');
    }

    public function getDescription(): string
    {
        return t('Clear workflow notifications you can not approve or deny.');
    }

    public function getTaskRunner(TaskInterface $task, InputInterface $input): TaskRunnerInterface
    {
        return new ProcessTaskRunner(
            $task,
            new ClearEmptyWorkflowCommand(),
            $input,
            t('Deleting empty workflow progress...')
        );
    }
}
