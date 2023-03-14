<?php

namespace Macareux\ClearEmptyWorkflow\Task\Command;

use Concrete\Core\Command\Task\Output\OutputAwareInterface;
use Concrete\Core\Command\Task\Output\OutputAwareTrait;
use Concrete\Core\Page\Workflow\Progress\ProgressList;
use Concrete\Core\Workflow\EmptyWorkflow;
use Concrete\Core\Workflow\Progress\Progress;

class ClearEmptyWorkflowCommandHandler implements OutputAwareInterface
{
    use OutputAwareTrait;

    public function __invoke(ClearEmptyWorkflowCommand $command)
    {
        $count = 0;
        $list = new ProgressList();
        $list->filter('wpApproved', 0);
        $list->sortBy('wpDateLastAction', 'desc');
        $r = $list->get();
        foreach ($r as $w) {
            /** @var Progress $wp */
            $wp = $w->getWorkflowProgressObject();
            $wo = $wp->getWorkflowObject();
            if ($wo instanceof EmptyWorkflow) {
                $wp->delete();
                $count++;
            }
        }

        $this->output->write(t2('%s workflow progress deleted.', '%s workflow progresses deleted.', $count));
    }
}
