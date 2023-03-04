<?php

namespace Wulfheart\LaravelActionsIdeHelper\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Riimu\Kit\PathJoin\Path;
use Wulfheart\LaravelActionsIdeHelper\Service\ActionInfoFactory;
use Wulfheart\LaravelActionsIdeHelper\Service\BuildIdeHelper;

class LaravelActionsIdeHelperCommand extends Command
{
    public $signature = 'ide-helper:actions';

    public $description = 'Generate a new IDE Helper file for Laravel Actions.';

    public function handle()
    {
        $actionsPath = Path::join(base_path(config('laravel-actions-ide-helper.path','app/Actions')));

        $outfile = Path::join(base_path(), '/'.config('laravel-actions-ide-helper.file_name','_ide_helper_actions.php'));

        $actionInfos = ActionInfoFactory::create($actionsPath);

        $result = BuildIdeHelper::create()->build($actionInfos);

        file_put_contents($outfile, $result);

        $this->comment('IDE Helpers generated for Laravel Actions at '.Str::of($outfile));
    }
}
