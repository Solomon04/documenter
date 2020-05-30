<?php

namespace Solomon04\Documentation;

use Solomon04\Documentation\Commands\GenerateDocumentationCommand;
use Illuminate\Support\ServiceProvider;
use Minime\Annotations\Cache\ArrayCache;
use Minime\Annotations\Interfaces\ReaderInterface;
use Minime\Annotations\Parser;
use Solomon04\Documentation\Contracts\Documentation;
use Solomon04\Documentation\Contracts\Extractor;
use Solomon04\Documentation\Contracts\StringBlade;
use Solomon04\Documentation\Contracts\Writer;
use Solomon04\Documentation\Documenter\DocumentationProvider;
use Solomon04\Documentation\Documenter\ExtractorProvider;
use Solomon04\Documentation\Documenter\StringBladeProvider;
use Solomon04\Documentation\Documenter\WriterProvider;
use Solomon04\Documentation\Exceptions\ApplicationSetupException;

class DocumentationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws ApplicationSetupException
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/documentation.php' => config_path('documentation.php')
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateDocumentationCommand::class
            ]);
        }

        $this->app->bind(ReaderInterface::class, function (){
            return new \Minime\Annotations\Reader(
                $this->app->make(Parser::class),
                $this->app->make( ArrayCache::class)
            );
        });

        $this->app->bind(Extractor::class, function (){
            return $this->app->make(ExtractorProvider::class);
        });

        $this->app->bind(Documentation::class, function (){
            return $this->app->make(DocumentationProvider::class);
        });

        $this->app->bind(StringBlade::class, function (){
            return $this->app->make(StringBladeProvider::class);
        });

        $this->app->bind(Writer::class, function (){
            return $this->app->make(WriterProvider::class);
        });

    }
}
