<?php

namespace Solomon04\Documentation\Commands;

use Solomon04\Documentation\Annotation\Endpoint;
use Solomon04\Documentation\Contracts\Documentation;
use Solomon04\Documentation\Contracts\Writer;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Solomon04\Documentation\Documenter\StringBladeProvider;
use Solomon04\Documentation\Exceptions\ApplicationSetupException;

class GenerateDocumentationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate your API Documentation';

    /**
     * @var Documentation
     */
    protected $documentation;

    /**
     * @var StringBladeProvider
     */
    protected $stringBladeProvider;


    /**
     * @var Writer
     */
    protected $writer;

    /**
     * @var int
     */
    protected $skipped = 0;

    /**
     * @var int
     */
    protected $saved = 0;

    public function __construct(Documentation $documentation, StringBladeProvider $stringBladeProvider, Writer $writer)
    {
        parent::__construct();
        $this->documentation = $documentation;
        $this->stringBladeProvider = $stringBladeProvider;
        $this->writer = $writer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (is_null(config('larecipe'))) {
            $this->error('Please install LaRecipe before continuing.');
            return;
        }

        $routes = $this->documentation->getFilteredRoutes();


        $endpoints = $routes->map(function (Endpoint $endpoint){
            try {
                $this->info('documenting: ' . $endpoint->uri . PHP_EOL);
                return $this->documentation->getMethodDocBlock($endpoint);
            }catch (\Exception $exception) {
                $this->skipped++;
                $this->warn('skipped: ' . $endpoint->uri . PHP_EOL);
                return false;
            }
        })->reject(function ($value) {
            return $value === false;
        });
        $namespaces = $this->documentation->groupEndpoints($endpoints);

        $namespaces = $namespaces->map(function ($namespace) {
            $items = $namespace->all();
            ksort($items);
            return collect($items);
        });

        $this->writer->menu($namespaces);

        $namespaces->map(function (Collection $namespace, string $name){
            $namespace->map(function (Collection $endpoints) use ($name){

                $this->writer->page($endpoints, $name);
            });
        });

        if ($this->skipped > 0) {
            $this->warn('Skipped: ' . $this->skipped . ' routes.');
        }

        return 0;
    }

}
